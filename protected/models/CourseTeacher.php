<?php

/**
 * This is the model class for table "{{course_teacher}}".
 *
 * The followings are the available columns in table '{{course_teacher}}':
 * @property integer $id
 * @property integer $teacher_id
 * @property integer $course_id
 */
class CourseTeacher extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CourseTeacher the static model class
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
		return '{{course_teacher}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('teacher_id, course_id, survey_header_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, teacher_id, course_id, survey_header_id, title', 'safe', 'on'=>'search'),
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
			'teacher'=>array(self::BELONGS_TO, 'Teacher', 'teacher_id'),
			'course' => array(self::BELONGS_TO, 'CourseOnline', 'course_id'),
			'q_header'=>array(self::BELONGS_TO, 'QHeader', 'survey_header_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'teacher_id' => 'ผู้สอน',
			'course_id' => 'หลักสูตร',
			'survey_header_id' => 'แบบสอบถาม',
			'title' => 'หัวข้อ'
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
		$criteria->compare('teacher_id',$this->teacher_id,true);
		$criteria->compare('course_id',$this->course_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
