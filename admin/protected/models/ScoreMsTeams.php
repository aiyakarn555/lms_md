<?php

/**
 * This is the model class for table "{{score_ms_teams}}".
 *
 * The followings are the available columns in table '{{score_ms_teams}}':
 * @property integer $score_id
 * @property integer $ms_teams_id
 * @property integer $gen_id
 * @property integer $user_id
 * @property integer $lesson_teams_id
 * @property string $type
 * @property integer $score_number
 * @property integer $score_total
 * @property string $score_past
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 * @property integer $ques_type
 * @property integer $confirm
 */
class ScoreMsTeams extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{score_ms_teams}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ms_teams_id, gen_id, user_id, lesson_teams_id, score_number, score_total, create_by, update_by, ques_type, confirm', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>4),
			array('score_past, active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('score_id, ms_teams_id, gen_id, user_id, lesson_teams_id, type, score_number, score_total, score_past, create_date, create_by, update_date, update_by, active, ques_type, confirm', 'safe', 'on'=>'search'),
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
			'score_id' => 'Score',
			'ms_teams_id' => 'Ms Teams',
			'gen_id' => 'Gen',
			'user_id' => 'User',
			'lesson_teams_id' => 'Lesson Teams',
			'type' => 'Type',
			'score_number' => 'Score Number',
			'score_total' => 'Score Total',
			'score_past' => 'Score Past',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'ques_type' => 'Ques Type',
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

		$criteria->compare('score_id',$this->score_id);
		$criteria->compare('ms_teams_id',$this->ms_teams_id);
		$criteria->compare('gen_id',$this->gen_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('lesson_teams_id',$this->lesson_teams_id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('score_number',$this->score_number);
		$criteria->compare('score_total',$this->score_total);
		$criteria->compare('score_past',$this->score_past,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('ques_type',$this->ques_type);
		$criteria->compare('confirm',$this->confirm);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ScoreMsTeams the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
