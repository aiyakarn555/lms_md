<?php

/**
 * This is the model class for table "{{capture_learn}}".
 *
 * The followings are the available columns in table '{{capture_learn}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $course_id
 * @property integer $lesson_id
 * @property string $time
 * @property integer $file_id
 * @property string $file_name
 * @property string $active
 * @property string $create_date
 * @property string $update_date
 */
class CaptureLearn extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{capture_learn}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, course_id, lesson_id, file_id', 'numerical', 'integerOnly' => true),
			array('time, file_name', 'length', 'max' => 255),
			array('active', 'length', 'max' => 1),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, course_id, lesson_id, time, file_id, file_name, active, create_date, update_date', 'safe', 'on' => 'search'),
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
			'pro' => array(self::BELONGS_TO, 'Profile', 'user_id'),
			'course' => array(self::BELONGS_TO, 'CourseOnline', 'course_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'course_id' => 'Course',
			'lesson_id' => 'Lesson',
			'time' => 'Time',
			'file_id' => 'File',
			'file_name' => 'File Name',
			'active' => 'Active',
			'create_date' => 'Create Date',
			'update_date' => 'Update Date',
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

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('course_id', $this->course_id);
		$criteria->compare('lesson_id', $this->lesson_id);
		$criteria->compare('time', $this->time, true);
		$criteria->compare('file_id', $this->file_id);
		$criteria->compare('file_name', $this->file_name, true);
		$criteria->compare('active', $this->active, true);
		$criteria->compare('create_date', $this->create_date, true);
		$criteria->compare('update_date', $this->update_date, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CaptureLearn the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}