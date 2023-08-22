<?php

/**
 * This is the model class for table "{{org_country_section}}".
 *
 * The followings are the available columns in table '{{org_country_section}}':
 * @property integer $id
 * @property integer $division_id
 * @property string $code
 * @property string $name
 * @property string $active
 * @property string $create_date
 * @property string $update_date
 * @property integer $create_by
 * @property integer $update_by
 */
class OrgCountrySection extends CActiveRecord
{
	public $division_search;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{org_country_section}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('division_id, code, name', 'required'),
			array('division_id, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>50),
			array('name', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, division_id, code, name, active, create_date, update_date, create_by, update_by, division_search', 'safe', 'on'=>'search'),
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
			'division' => array(self::BELONGS_TO, 'OrgCountryDivision', 'division_id'),
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
			'division_id' => 'Division',
			'code' => 'Code',
			'name' => 'ชื่อ',
			'active' => 'สถานะ',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'department_search' => 'department Search',
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
		$criteria->with=array('division');
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.division_id',$this->division_id);
		$criteria->compare('t.code',$this->code,true);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('division.name',$this->division_search,true);
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
	 * @return OrgCountrySection the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
	{
	
		if(null !== Yii::app()->user && isset(Yii::app()->user->id))
			$id = Yii::app()->user->id;
		else
			$id = 0;

		if($this->isNewRecord)
		{
			$this->create_by = $id;
			$this->create_date = date("Y-m-d H:i:s");
			$this->update_by = $id;
			$this->update_date = date("Y-m-d H:i:s");
		}
		else
		{
			$this->update_by = $id;
			$this->update_date = date("Y-m-d H:i:s");
		}
		return parent::beforeSave();
	}
}
