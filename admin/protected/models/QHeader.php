<?php

/**
 * This is the model class for table "q_survey_headers".
 *
 * The followings are the available columns in table 'q_survey_headers':
 * @property integer $survey_header_id
 * @property string $survey_name
 * @property string $instructions
 * @property string $instructions_en
 * @property string $other_header_info
 */
class QHeader extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return QHeader the static model class
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
		return 'q_survey_headers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('survey_name', 'length', 'max'=>255),
			array('instructions, instructions_en', 'length', 'max'=>4096),
			array('other_header_info', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('type,survey_header_id, survey_name, instructions, instructions_en, other_header_info', 'safe', 'on'=>'search'),
			array('type,survey_header_id, survey_name, instructions, instructions_en, other_header_info', 'safe', 'on'=>'searchout'),
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
			'sections'=>array(self::HAS_MANY, 'QSection', 'survey_header_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'survey_header_id' => 'Survey Header',
			'survey_name' => 'ชื่อแบบสอบถาม',
			'instructions' => 'Instructions',
			'instructions_en' => 'Instructions En',
			'other_header_info' => 'Other Header Info',
		);
	}

	public function defaultScope()
    {
        // return array(
        //     'condition'=>' create_by = "'.Yii::app()->user->id.'" AND active="y" ',
        // );
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

		$criteria->compare('survey_header_id',$this->survey_header_id);
		$criteria->compare('survey_name',$this->survey_name,true);
		$criteria->compare('instructions',$this->instructions,true);
		$criteria->compare('instructions_en',$this->instructions_en,true);
		$criteria->compare('other_header_info',$this->other_header_info,true);
		$criteria->addCondition("type != 'outside' OR type IS NULL");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchout()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('survey_header_id',$this->survey_header_id);
		$criteria->compare('survey_name',$this->survey_name,true);
		$criteria->compare('instructions',$this->instructions,true);
		$criteria->compare('instructions_en',$this->instructions_en,true);
		$criteria->compare('other_header_info',$this->other_header_info,true);
		$criteria->addCondition("type = 'outside'");
		$modelUser = Users::model()->findByPk(Yii::app()->user->id);
		$group = json_decode($modelUser->group);
		if (!in_array(1, $group)){
			$groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
			$criteria->addInCondition('create_by', $groupUser);	
		}
		$criteria->order = 'survey_header_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}