<?php

/**
 * This is the model class for table "q_survey_sections".
 *
 * The followings are the available columns in table 'q_survey_sections':
 * @property integer $survey_section_id
 * @property integer $survey_header_id
 * @property string $section_name_flag
 * @property string $section_title
 * @property string $section_title_en
 * @property string $section_subheading
 * @property string $section_subheading_en
 * @property string $section_required_yn
 */
class QSection extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return QSection the static model class
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
		return 'q_survey_sections';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('survey_header_id', 'numerical', 'integerOnly'=>true),
			array('section_name_flag, section_required_yn', 'length', 'max'=>1),
			array('section_title, section_title_en', 'length', 'max'=>255),
			array('section_subheading, section_subheading_en', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('survey_section_id, survey_header_id, section_name_flag, section_title, section_title_en, section_subheading, section_subheading_en, section_required_yn', 'safe', 'on'=>'search'),
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
			'questions'=>array(self::HAS_MANY, 'QQuestion', 'survey_section_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'survey_section_id' => 'Survey Section',
			'survey_header_id' => 'Survey Header',
			'section_name_flag' => 'Section Name Flag',
			'section_title' => 'Section Title',
			'section_title_en' => 'Section Title En',
			'section_subheading' => 'Section Subheading',
			'section_subheading_en' => 'Section Subheading En',
			'section_required_yn' => 'Section Required Yn',
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

		$criteria->compare('survey_section_id',$this->survey_section_id);
		$criteria->compare('survey_header_id',$this->survey_header_id);
		$criteria->compare('section_name_flag',$this->section_name_flag,true);
		$criteria->compare('section_title',$this->section_title,true);
		$criteria->compare('section_title_en',$this->section_title_en,true);
		$criteria->compare('section_subheading',$this->section_subheading,true);
		$criteria->compare('section_subheading_en',$this->section_subheading_en,true);
		$criteria->compare('section_required_yn',$this->section_required_yn,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}