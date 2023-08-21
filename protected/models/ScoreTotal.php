<?php

/**
 * This is the model class for table "{{score_total}}".
 *
 * The followings are the available columns in table '{{score_total}}':
 * @property integer $score_total_id
 * @property integer $num_learn_id
 * @property integer $user_id
 * @property integer $score_total
 * @property integer $status_award
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class ScoreTotal extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ScoreTotal the static model class
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
		return '{{score_total}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('num_learn_id, course_id, user_id, score_total, status_award, update_date, update_by', 'required'),
			// array('num_learn_id, user_id, score_total, status_award, update_by', 'numerical', 'integerOnly'=>true),
			array('active', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('score_total_id, course_id, num_learn_id, user_id, score_total, score_point, status_award, update_date, update_by, active', 'safe', 'on'=>'search'),
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
			'numlearn' => array(self::BELONGS_TO, 'NumLearn', 'num_learn_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'score_total_id' => 'Score Total',
			'num_learn_id' => 'Num Learn',
			'user_id' => 'User',
			'score_total' => 'Score Total',
			'status_award' => 'Status Award',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'course_id'=>'Course ID',
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

		$criteria->compare('score_total_id',$this->score_total_id);
		$criteria->compare('num_learn_id',$this->num_learn_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('score_total',$this->score_total);
		$criteria->compare('score_total',$this->score_point);
		$criteria->compare('status_award',$this->status_award);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('course_id',$this->course_id);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
