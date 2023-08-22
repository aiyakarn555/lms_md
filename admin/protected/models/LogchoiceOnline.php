<?php

/**
 * This is the model class for table "{{logchoice_online}}".
 *
 * The followings are the available columns in table '{{logchoice_online}}':
 * @property integer $logchoice_id
 * @property integer $gen_id
 * @property integer $lesson_teams_id
 * @property integer $user_id
 * @property integer $score_id
 * @property integer $ques_id
 * @property integer $choice_id
 * @property string $test_type
 * @property integer $ques_type
 * @property integer $logchoice_answer
 * @property string $is_valid_choice
 * @property integer $logchoice_select
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class LogchoiceOnline extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{logchoice_online}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gen_id, lesson_teams_id, user_id, score_id, ques_id, choice_id, ques_type, logchoice_answer, logchoice_select, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('test_type', 'length', 'max'=>4),
			array('is_valid_choice, active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('logchoice_id, gen_id, lesson_teams_id, user_id, score_id, ques_id, choice_id, test_type, ques_type, logchoice_answer, is_valid_choice, logchoice_select, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
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
			'lessonTeams' => array(self::BELONGS_TO, 'LessonOnline', 'lesson_teams_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'logchoice_id' => 'Logchoice',
			'gen_id' => 'Gen',
			'lesson_teams_id' => 'Lesson Teams',
			'user_id' => 'User',
			'score_id' => 'Score',
			'ques_id' => 'Ques',
			'choice_id' => 'Choice',
			'test_type' => 'Test Type',
			'ques_type' => 'Ques Type',
			'logchoice_answer' => 'Logchoice Answer',
			'is_valid_choice' => 'Is Valid Choice',
			'logchoice_select' => 'Logchoice Select',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
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

		$criteria->compare('logchoice_id',$this->logchoice_id);
		$criteria->compare('gen_id',$this->gen_id);
		$criteria->compare('lesson_teams_id',$this->lesson_teams_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('score_id',$this->score_id);
		$criteria->compare('ques_id',$this->ques_id);
		$criteria->compare('choice_id',$this->choice_id);
		$criteria->compare('test_type',$this->test_type,true);
		$criteria->compare('ques_type',$this->ques_type);
		$criteria->compare('logchoice_answer',$this->logchoice_answer);
		$criteria->compare('is_valid_choice',$this->is_valid_choice,true);
		$criteria->compare('logchoice_select',$this->logchoice_select);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LogchoiceMsTeams the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}