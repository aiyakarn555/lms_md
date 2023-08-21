<?php

/**
 * This is the model class for table "q_option_choices".
 *
 * The followings are the available columns in table 'q_option_choices':
 * @property integer $option_choice_id
 * @property integer $question_id
 * @property string $option_choice_name
 * @property string $option_choice_name_en
 * @property string $option_choice_type
 * @property integer $option_choice_order_flag
 */
class QChoice extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return QChoice the static model class
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
		return 'q_option_choices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('question_id, option_choice_order_flag', 'numerical', 'integerOnly'=>true),
			array('option_choice_name, option_choice_name_en', 'length', 'max'=>255),
			array('option_choice_type', 'length', 'max'=>7),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('option_choice_id, question_id, option_choice_name, option_choice_name_en, option_choice_type, option_choice_order_flag', 'safe', 'on'=>'search'),
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
			'option_choice_id' => 'Option Choice',
			'question_id' => 'Question',
			'option_choice_name' => 'Option Choice Name',
			'option_choice_name_en' => 'Option Choice Name En',
			'option_choice_type' => 'Option Choice Type',
			'option_choice_order_flag' => 'Option Choice Order Flag',
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

		$criteria->compare('option_choice_id',$this->option_choice_id);
		$criteria->compare('question_id',$this->question_id);
		$criteria->compare('option_choice_name',$this->option_choice_name,true);
		$criteria->compare('option_choice_name_en',$this->option_choice_name_en,true);
		$criteria->compare('option_choice_type',$this->option_choice_type,true);
		$criteria->compare('option_choice_order_flag',$this->option_choice_order_flag);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}