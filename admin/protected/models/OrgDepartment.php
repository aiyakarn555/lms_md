<?php

/**
 * This is the model class for table "{{org_department}}".
 *
 * The followings are the available columns in table '{{org_department}}':
 * @property integer $id
 * @property integer $bu_id
 * @property string $code
 * @property string $name
 * @property string $active
 * @property string $create_date
 * @property string $update_date
 * @property integer $create_by
 * @property integer $update_by
 *
 * The followings are the available model relations:
 * @property OrgBu $bu
 * @property OrgDivision[] $orgDivisions
 */
class OrgDepartment extends CActiveRecord
{

	public $bu_search;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{org_department}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bu_id, code, name', 'required'),
			array('bu_id, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>50),
			array('name', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, bu_id, code, name, active, create_date, update_date, create_by, update_by, bu_search', 'safe', 'on'=>'search'),
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
			'bu' => array(self::BELONGS_TO, 'OrgBu', 'bu_id'),
			'orgDivisions' => array(self::HAS_MANY, 'OrgDivision', 'department_id'),
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'userupdate' => array(self::BELONGS_TO, 'User', 'update_by')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'bu_id' => 'Bu',
			'code' => 'Code',
			'name' => 'ชื่อ',
			'active' => 'สถานะ',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'bu_search' => 'Bu Search',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with=array('bu');
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.bu_id',$this->bu_id);
		$criteria->compare('t.code',$this->code,true);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('bu.name',$this->bu_search,true);
		$criteria->compare('t.active','y');
		$criteria->compare('t.create_date',$this->create_date,true);
		$criteria->compare('t.update_date',$this->update_date,true);
		$criteria->compare('t.create_by',$this->create_by);
		$criteria->compare('t.update_by',$this->update_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrgDepartment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
