<?php

/**
 * This is the model class for table "temp_quiz_ms_teams".
 *
 * The followings are the available columns in table 'temp_quiz_ms_teams':
 * @property integer $id
 * @property integer $gen_id
 * @property integer $user_id
 * @property string $type
 * @property integer $lesson_teams_id
 * @property integer $group_id
 * @property integer $ques_id
 * @property integer $number
 * @property string $ans_id
 * @property integer $status
 * @property string $time_start
 * @property string $question
 * @property string $time_up
 * @property integer $manage_id
 * @property string $logchoice_text
 * @property integer $ques_type
 * @property string $created_date
 */
class TempQuizMsTeams extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'temp_quiz_ms_teams';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gen_id, user_id, lesson_teams_id, group_id, ques_id, number, status, manage_id, ques_type', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>5),
			array('ans_id, question, time_up', 'length', 'max'=>255),
			array('time_start, logchoice_text, created_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, gen_id, user_id, type, lesson_teams_id, group_id, ques_id, number, ans_id, status, time_start, question, time_up, manage_id, logchoice_text, ques_type, created_date', 'safe', 'on'=>'search'),
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
			'gen_id' => 'Gen',
			'user_id' => 'User',
			'type' => 'Type',
			'lesson_teams_id' => 'Lesson Teams',
			'group_id' => 'Group',
			'ques_id' => 'Ques',
			'number' => 'Number',
			'ans_id' => 'Ans',
			'status' => 'Status',
			'time_start' => 'Time Start',
			'question' => 'Question',
			'time_up' => 'Time Up',
			'manage_id' => 'Manage',
			'logchoice_text' => 'Logchoice Text',
			'ques_type' => 'Ques Type',
			'created_date' => 'Created Date',
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
		$criteria->compare('gen_id',$this->gen_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('lesson_teams_id',$this->lesson_teams_id);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('ques_id',$this->ques_id);
		$criteria->compare('number',$this->number);
		$criteria->compare('ans_id',$this->ans_id,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('time_start',$this->time_start,true);
		$criteria->compare('question',$this->question,true);
		$criteria->compare('time_up',$this->time_up,true);
		$criteria->compare('manage_id',$this->manage_id);
		$criteria->compare('logchoice_text',$this->logchoice_text,true);
		$criteria->compare('ques_type',$this->ques_type);
		$criteria->compare('created_date',$this->created_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TempQuizMsTeams the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
