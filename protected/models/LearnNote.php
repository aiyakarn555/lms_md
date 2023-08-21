<?php

/**
 * This is the model class for table "{{learn_note}}".
 *
 * The followings are the available columns in table '{{learn_note}}':
 * @property integer $note_id
 * @property integer $user_id
 * @property integer $course_id
 * @property integer $lesson_id
 * @property integer $file_id
 * @property string $note_time
 * @property string $note_text
 * @property string $note_times
 * @property string $active
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $update_date
 */
class LearnNote extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{learn_note}}';
	}

	public function beforeSave() 
	{		

		if($this->isNewRecord)
		{
			$this->created_by = Yii::app()->user->id;
			$this->created_date = date("Y-m-d H:i:s");
		}else {
			$this->updated_by = Yii::app()->user->id;
			$this->update_date = date("Y-m-d H:i:s");
		}

		return parent::beforeSave();
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, course_id, lesson_id, file_id, created_by, updated_by', 'numerical', 'integerOnly'=>true),
			array('note_time, note_times', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			array('note_text, created_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('note_id, user_id, course_id, lesson_id, file_id, note_time, note_text, note_times, active, created_by, created_date, updated_by, update_date, gen_id', 'safe', 'on'=>'search'),
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
			'file' => array(self::BELONGS_TO, 'File', 'file_id'),
			'CourseGeneration' => array(self::BELONGS_TO, 'CourseGeneration', 'gen_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'note_id' => 'Note',
			'user_id' => 'User',
			'course_id' => 'Course',
			'lesson_id' => 'Lesson',
			'file_id' => 'File',
			'note_time' => 'Note Time',
			'note_text' => 'Note Text',
			'note_times' => 'Note Times',
			'active' => 'Active',
			'created_by' => 'Created By',
			'created_date' => 'Created Date',
			'updated_by' => 'Updated By',
			'update_date' => 'Update Date',
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

		$criteria->compare('note_id',$this->note_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('lesson_id',$this->lesson_id);
		$criteria->compare('file_id',$this->file_id);
		$criteria->compare('note_time',$this->note_time,true);
		$criteria->compare('note_text',$this->note_text,true);
		$criteria->compare('note_times',$this->note_times,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('gen_id',$this->gen_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LearnNote the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
