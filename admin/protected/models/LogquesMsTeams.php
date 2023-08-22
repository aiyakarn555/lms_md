<?php

/**
 * This is the model class for table "{{logques_ms_teams}}".
 *
 * The followings are the available columns in table '{{logques_ms_teams}}':
 * @property integer $logques_id
 * @property integer $gen_id
 * @property integer $lesson_teams_id
 * @property integer $score_id
 * @property integer $ques_id
 * @property integer $user_id
 * @property string $test_type
 * @property integer $ques_type
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 * @property integer $result
 * @property string $logques_text
 * @property integer $check
 * @property integer $confirm
 *
 * The followings are the available model relations:
 * @property Lesson $lessonTeams
 */
class LogquesMsTeams extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{logques_ms_teams}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gen_id, lesson_teams_id, score_id, ques_id, user_id, ques_type, create_by, update_by, result, check, confirm', 'numerical', 'integerOnly'=>true),
			array('test_type', 'length', 'max'=>4),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date, logques_text', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('logques_id, gen_id, lesson_teams_id, score_id, ques_id, user_id, test_type, ques_type, create_date, create_by, update_date, update_by, active, result, logques_text, check, confirm', 'safe', 'on'=>'search'),
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
			'lessonTeams' => array(self::BELONGS_TO, 'LessonMsTeams', 'lesson_teams_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'logques_id' => 'Logques',
			'gen_id' => 'Gen',
			'lesson_teams_id' => 'Lesson Teams',
			'score_id' => 'Score',
			'ques_id' => 'Ques',
			'user_id' => 'User',
			'test_type' => 'Test Type',
			'ques_type' => 'Ques Type',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'result' => 'Result',
			'logques_text' => 'Logques Text',
			'check' => 'Check',
			'confirm' => 'Confirm',
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

		$criteria->compare('logques_id',$this->logques_id);
		$criteria->compare('gen_id',$this->gen_id);
		$criteria->compare('lesson_teams_id',$this->lesson_teams_id);
		$criteria->compare('score_id',$this->score_id);
		$criteria->compare('ques_id',$this->ques_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('test_type',$this->test_type,true);
		$criteria->compare('ques_type',$this->ques_type);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('result',$this->result);
		$criteria->compare('logques_text',$this->logques_text,true);
		$criteria->compare('check',$this->check);
		$criteria->compare('confirm',$this->confirm);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LogquesMsTeams the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
