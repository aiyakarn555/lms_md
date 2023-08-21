<?php

/**
 * This is the model class for table "{{choice}}".
 *
 * The followings are the available columns in table '{{choice}}':
 * @property integer $choice_id
 * @property integer $ques_id
 * @property string $choice_detail
 * @property integer $choice_answer
 * @property string $choice_type
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 * @property integer $reference
 */
class ChoiceMsTeams extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Choice the static model class
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
		return '{{choice_ms_teams}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ques_id, choice_answer, create_by, update_by, reference', 'numerical', 'integerOnly'=>true),
			array('choice_detail', 'length', 'max'=>255),
			array('choice_type', 'length', 'max'=>10),
			array('active', 'length', 'max'=>1),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('choice_id, ques_id, choice_detail, choice_answer, choice_type, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
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
			'question' => array(self::BELONGS_TO, 'QuestionMsTeams', 'ques_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'choice_id' => 'Choice',
			'ques_id' => 'Ques',
			'choice_detail' => 'Choice Detail',
			'choice_answer' => 'Choice Answer',
			'choice_type' => 'Choice Type',
			'create_date' => 'Create Date',
			'create_by' => 'Create By',
			'update_date' => 'Update Date',
			'update_by' => 'Update By',
			'active' => 'Active',
			'reference' => 'reference',

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

		$criteria->compare('choice_id',$this->choice_id);
		$criteria->compare('ques_id',$this->ques_id);
		$criteria->compare('choice_detail',$this->choice_detail,true);
		$criteria->compare('choice_answer',$this->choice_answer);
		$criteria->compare('choice_type',$this->choice_type,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}