<?php

/**
 * This is the model class for table "project".
 *
 * The followings are the available columns in table 'project':
 * @property integer $id
 * @property string $name
 * @property string $expire_date
 */
class Project extends CActiveRecord
{
	public $university_stored_ids = array();
	public $university_ids = array();
	public $university_search;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Project the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'project';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, start_date,expire_date,university_ids', 'required'),
			array('name', 'length', 'max'=>255),
			array('university_ids', 'type', 'type' => 'array', 'allowEmpty' => false),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, start_date, expire_date, university_search', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
//			'hasUniversities'=> array(self::HAS_MANY, 'ProjectUniversity', 'project_id'),
//			'universities' => array(self::HAS_MANY, 'TbUniversity', array('university_id'=>'id'),'through'=>'hasUniversities'),
			'universities'=>array(self::MANY_MANY, 'TbUniversity',
				'project_university(project_id, university_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'ชื่อโครงการ',
			'start_date' => 'วันเริ่มต้นโครงการ',
			'expire_date' => 'วันสิ้นสุดโครงการ',
			'university_search'=>'มหาวิทยาลัย',
			'university_ids'=>'มหาวิทยาลัย'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array(
			'universities' => array(
				'joinType' => 'INNER JOIN',
				//'on'       => 'userid = id',
			)
		);

		$criteria->together = true;

		$criteria->compare('id',$this->id);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('start_date',$this->expire_date,true);
		$criteria->compare('expire_date',$this->expire_date,true);
		$criteria->compare('university_id',$this->university_search);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function afterFind() {

		$this->university_ids = array();
		foreach ($this->universities as $r) {
			$this->university_ids[] = $r->id;
		}

		$this->university_stored_ids = $this->university_ids;

		$start_date = explode(" ",$this->start_date);
		$this->start_date = $start_date[0];

		$expire_date = explode(" ",$this->expire_date);
		$this->expire_date = $expire_date[0];

		parent::afterFind();
	}

	public function afterSave() {


		if (!$this->university_ids) //if nothing selected set it as an empty array
			$this->university_ids = array();

		//save the new selected ids that are not exist in the stored ids
		$ids_to_update = array_diff($this->university_ids, $this->university_stored_ids);
		foreach ($ids_to_update as $uid) {
			$p = new ProjectUniversity();
			$p->university_id = $uid;
			$p->project_id = $this->id;
			$p->save();
		}

		//remove the stored ids that are not exist in the selected ids
		$ids_to_remove = array_diff($this->university_stored_ids, $this->university_ids);

		foreach ($ids_to_remove as $did) {
			if ($p = ProjectUniversity::model()->findByAttributes(array("university_id"=>$did,"project_id"=>$this->id))) {
				$p->delete();
			}
		}

		parent::afterSave();
	}
}