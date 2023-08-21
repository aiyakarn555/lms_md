<?php

/**
 * This is the model class for table "{{department}}".
 *
 * The followings are the available columns in table '{{department}}':
 * @property integer $id
 * @property integer $division_id
 * @property string $dep_title
 * @property string $create_date
 * @property string $active
 */
class Department extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{department}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('division_id', 'numerical', 'integerOnly'=>true),
			array('dep_title, active', 'length', 'max'=>255),
			array('create_date,lang_id,parent_id, type_employee_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, division_id, dep_title, create_date, active,lang_id,parent_id, type_employee_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'division_id' => 'กอง',
			'dep_title' => 'ชื่อแผนก',
			'create_date' => 'Create Date',
			'active' => 'Active',
			'parent_id' => 'เมนูหลัก',
			'lang_id' => 'ภาษา',
			'type_employee_id' => 'ประเภท',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('division_id',$this->division_id);
		$criteria->compare('dep_title',$this->dep_title,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('type_employee_id',$this->type_employee_id,true);
		$criteria->compare('active',y);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Department the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getDepartmentList($division_id=null){
		$strSql = $division_id != null ? ' AND division_id='.$division_id : '';
		$model = Department::model()->findAll('active = "y"');
		$list = CHtml::listData($model,'id','dep_title');
		return $list;
	}

	public function getDepartmentData(){
		$model = Department::model()->findAll('active = "y"');
		$list = CHtml::listData($model,'id','dep_title');
		return $list;
	}
}
