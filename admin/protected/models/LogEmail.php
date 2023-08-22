<?php

/**
 * This is the model class for table "log_email".
 *
 * The followings are the available columns in table 'log_email':
 * @property integer $id
 * @property string $course_id
 * @property string $message
 * @property integer $user_id
 * @property string $create_date
 */
class LogEmail extends CActiveRecord
{
	public $position_id;
	public $department_id;
	public $type_employee;
	public $search_name;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'log_email';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id,course_id', 'numerical', 'integerOnly'=>true),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, course_id, message, user_id, create_date, position_id, department_id, type_employee, search_name', 'safe', 'on'=>'search'),
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
			'course' => array(self::BELONGS_TO, 'CourseOnline', 'course_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'course_id' => 'หลักสูตร',
			'message' => 'message',
			'user_id' => 'User',
			'create_date' => 'Create Date',
			'position_id' => 'ตำแหน่ง',
			'department_id' => 'แผนก',
			'type_employee' => 'ประเภทพนักงาน',
			'search_name' => 'ชื่อ-สกุล, เลขบัตรประชาชน-พาสปอร์ต',
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

		$criteria->with = array('user');
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.course_id',$this->course_id,true);
		$criteria->compare('t.message',$this->message,true);
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('position_id',$this->position_id,true);
		$criteria->compare('department_id',$this->department_id,true);
		$criteria->compare('type_employee',$this->type_employee,true);
		$criteria->compare('t.create_date',$this->create_date,true);
		$criteria->compare('CONCAT(profile.firstname , " " , profile.lastname , " ", " ", username," ",profile.firstname_en , " " , profile.lastname_en ," ", " ", user.identification, " ", profile.passport)',$this->search_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LogEmail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
