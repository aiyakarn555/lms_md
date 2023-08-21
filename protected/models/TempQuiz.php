<?php

/**
 * This is the model class for table "temp_quiz".
 *
 * The followings are the available columns in table 'temp_quiz':
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property integer $lesson
 * @property integer $group_id
 * @property integer $ques_id
 * @property integer $number
 * @property integer $ans_id
 * @property integer $status
 * @property string $time_start
 * @property string $question
 * @property string $time_up
 */
class TempQuiz extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'temp_quiz';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, lesson, group_id, ques_id, number, status', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>5),
			array('question, time_up,ans_id', 'length', 'max'=>255),
			array('time_start', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, type, lesson, group_id, ques_id, number, ans_id, status, time_start, question, time_up, gen_id', 'safe', 'on'=>'search'),
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
			'quest' => array(self::BELONGS_TO, 'Question','ques_id'),
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
			'type' => 'Type',
			'lesson' => 'Lesson',
			'group_id' => 'Group',
			'ques_id' => 'Ques',
			'number' => 'Number',
			'ans_id' => 'Ans',
			'status' => 'Status',
			'time_start' => 'Time Start',
			'question' => 'Question',
			'time_up' => 'Time Up',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('lesson',$this->lesson);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('ques_id',$this->ques_id);
		$criteria->compare('number',$this->number);
		$criteria->compare('ans_id',$this->ans_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('time_start',$this->time_start,true);
		$criteria->compare('question',$this->question,true);
		$criteria->compare('time_up',$this->time_up,true);
		$criteria->compare('gen_id',$this->gen_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TempQuiz the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
