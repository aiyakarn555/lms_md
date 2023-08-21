<?php

/**
 * This is the model class for table "{{learn}}".
 *
 * The followings are the available columns in table '{{learn}}':
 * @property integer $learn_id
 * @property integer $user_id
 * @property integer $lesson_id
 * @property string $learn_date
 */
class Learn extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Learn the static model class
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
		return '{{learn}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, lesson_id, learn_date', 'required'),
			array('user_id, lesson_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('learn_id, user_id, lesson_id, learn_date, create_date, gen_id, course_id, lesson_active, lesson_status', 'safe', 'on'=>'search'),
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
			'LessonMapper' => array(self::BELONGS_TO, 'Lesson', 'lesson_id'),
			'learnfile' => array(self::BELONGS_TO, 'LearnFile', 'learn_id'),
			'learnfileDate' => array(self::BELONGS_TO, 'LearnFile', array('learn_id'=>'learn_id')),
			'CourseGeneration' => array(self::BELONGS_TO, 'CourseGeneration', 'gen_id'),
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'learn_id' => 'Learn',
			'user_id' => 'User',
			'lesson_id' => 'Lesson',
			'learn_date' => 'Learn Date',
			'create_date' => 'Create Date',
			'gen_id' => 'gen_id',
			'course_id' => 'course_id',
			'lesson_active' => 'lesson_active',
			'lesson_status' => 'lesson_status',
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

		$criteria->compare('learn_id',$this->learn_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('lesson_id',$this->lesson_id);
		$criteria->compare('learn_date',$this->learn_date,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('gen_id',$this->gen_id,true);
		$criteria->compare('course_id',$this->course_id,true);
		$criteria->compare('lesson_active',$this->lesson_active,true);
		$criteria->compare('lesson_status',$this->lesson_status,true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public function beforeSave() 
    {
		if($this->isNewRecord)
		{
			$this->create_date = date("Y-m-d H:i:s");
		}
        return parent::beforeSave();
    }
}