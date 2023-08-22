<?php

/**
 * This is the model class for table "{{org_course}}".
 *
 * The followings are the available columns in table '{{org_course}}':
 * @property integer $id
 * @property integer $orgchart_id
 * @property integer $course_id
 * @property string $active
 */
class OrgCourse extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrgCourse the static model class
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
		return '{{org_course}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('id', 'required'),
			array('id, orgchart_id, course_id, parent_id', 'numerical', 'integerOnly'=>true),
			array('active', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, orgchart_id, course_id, parent_id, active', 'safe', 'on'=>'search'),
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
			'courses' => array(self::BELONGS_TO, 'CourseOnline', 'course_id'),
		);
	}

	

	public static function getChilds($parent) {
		$data = array();
		$course_id_arr = array();

		$OrgCourse = OrgCourse::model()->with('courses')->findAll('orgcourse.parent_id = '.$parent.' AND courseonline.active="y" AND orgcourse.orgchart_id ='.$_GET['id']);

		foreach($OrgCourse as $model) {
			if(!in_array($model->course_id, $course_id_arr)){
				$row['text'] = $model->courses->course_title;
				$row['data'] = $model->id;
				$row['children'] = OrgCourse::getChilds($model->id);
				$data[] = $row;
				$course_id_arr[] = $model->course_id;
			}
		}
		return $data;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'orgchart_id' => 'Orgchart',
			'course_id' => 'Course',
			'active' => 'Active',
		);
	}

	public function defaultScope()
	{
	    return array(
	    	'alias' => 'orgcourse',
	    	'order' => 'orgcourse.order desc',
	    	'condition' => 'orgcourse.active = "y"',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('orgchart_id',$this->orgchart_id);
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}