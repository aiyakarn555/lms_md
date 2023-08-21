<?php

/**
 * This is the model class for table "{{auth_course}}".
 *
 * The followings are the available columns in table '{{auth_course}}':
 * @property integer $auth_id
 * @property integer $user_id
 * @property integer $course_id
 * @property integer $schedule_id
 * @property string $created
 */
class AuthCourse extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{auth_course}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, course_id, schedule_id', 'numerical', 'integerOnly'=>true),
			array('created, register_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('auth_id, user_id, course_id, schedule_id, created, register_date', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', array('user_id' => 'id')),
			'course' => array(self::BELONGS_TO, 'CourseOnline', 'course_id'),
			'schedule' => array(self::BELONGS_TO, 'Schedule', array('schedule_id' => 'id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'auth_id' => 'Auth',
			'user_id' => 'User',
			'course_id' => 'Course',
			'schedule_id' => 'Schedule',
			'register_date' => 'Register Date',
			'created' => 'Created',
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

		$criteria->compare('auth_id',$this->auth_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('register_date',$this->register_date);
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('schedule_id',$this->schedule_id);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AuthCourse the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
