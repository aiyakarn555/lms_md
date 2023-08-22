<?php

/**
 * This is the model class for table "log_reset".
 *
 * The followings are the available columns in table 'log_reset':
 * @property integer $id
 * @property integer $user_id
 * @property integer $course_id
 * @property integer $lesson_id
 * @property string $reset_description
 * @property string $reset_date
 * @property integer $reset_type
 */
class LogReset extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{log_reset}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, course_id, lesson_id, reset_type, reset_by', 'numerical', 'integerOnly'=>true),
			array('reset_description, reset_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, course_id, lesson_id, reset_description, reset_date, reset_type, reset_by, gen_id', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO,'User','user_id'),
			// 'reset' => array(self::BELONGS_TO,'MMember','reset_by'),
			'reset' => array(self::BELONGS_TO, 'Profiles', 'reset_by'),
			'course' => array(self::BELONGS_TO,'CourseOnline','course_id'),
			// 'lesson' => array(self::BELONGS_TO,'LessonList','lesson_id'),
			'lesson' => array(self::BELONGS_TO, 'lesson', 'lesson_id'),
			
			'pro' => array(self::BELONGS_TO, 'Profile', 'user_id'),
			'mem' => array(self::BELONGS_TO, 'User', 'user_id','foreignKey' => array('user_id'=>'id')),
			// 'course' => array(self::BELONGS_TO, 'CourseOnline', 'course_id'),
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
			'reset_description' => 'Reset Description',
			'reset_date' => 'Reset Date',
			'reset_type' => '0=บทเรียน 1=สอบ',
			'gen_id' => 'gen_id',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('lesson_id',$this->lesson_id);
		$criteria->compare('reset_description',$this->reset_description,true);
		$criteria->compare('reset_date',$this->reset_date,true);
		$criteria->compare('reset_type',$this->reset_type);
		$criteria->compare('reset_by',$this->reset_by);
		$criteria->compare('gen_id',$this->gen_id);
		$criteria->with = array('course');
		$criteria->compare('courseonline.active', $this->course->active='y', true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
			    'defaultOrder'=>'id DESC',
			  ),
            'pagination'=>array(
                'pageSize'=>100,
            )
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LogReset the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
