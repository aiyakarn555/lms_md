<?php

/**
 * This is the model class for table "q_questions".
 *
 * The followings are the available columns in table 'q_questions':
 * @property integer $question_id
 * @property integer $survey_section_id
 * @property integer $input_type_id
 * @property string $question_name
 * @property string $question_name_en
 * @property string $question_subtext
 * @property string $answer_required_yn
 * @property integer $option_group_id
 * @property string $allow_multiple_option_answers_yn
 */
class QQuestion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return QQuestion the static model class
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
		return 'q_questions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('survey_section_id, input_type_id, option_group_id', 'numerical', 'integerOnly'=>true),
			array('question_name, question_name_en', 'length', 'max'=>255),
			array('question_subtext', 'length', 'max'=>500),
			array('answer_required_yn, allow_multiple_option_answers_yn', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('question_id, survey_section_id, input_type_id, question_name, question_name_en, question_subtext, answer_required_yn, option_group_id, allow_multiple_option_answers_yn', 'safe', 'on'=>'search'),
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
			'choices'=>array(self::HAS_MANY, 'QChoice', 'question_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'question_id' => 'Question',
			'survey_section_id' => 'Survey Section',
			'input_type_id' => 'Input Type',
			'question_name' => 'Question Name',
			'question_name_en' => 'Question Name En',
			'question_subtext' => 'Question Subtext',
			'answer_required_yn' => 'Answer Required Yn',
			'option_group_id' => 'Option Group',
			'allow_multiple_option_answers_yn' => 'Allow Multiple Option Answers Yn',
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

		$criteria->compare('question_id',$this->question_id);
		$criteria->compare('survey_section_id',$this->survey_section_id);
		$criteria->compare('input_type_id',$this->input_type_id);
		$criteria->compare('question_name',$this->question_name,true);
		$criteria->compare('question_name_en',$this->question_name_en,true);
		$criteria->compare('question_subtext',$this->question_subtext,true);
		$criteria->compare('answer_required_yn',$this->answer_required_yn,true);
		$criteria->compare('option_group_id',$this->option_group_id);
		$criteria->compare('allow_multiple_option_answers_yn',$this->allow_multiple_option_answers_yn,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function checkQuestionBySurvey($survey_id) {
		
		//find section details
		$setArray = null;
		$question_sec = QSection::model()->findAll(array(
			'condition' => 'survey_header_id = "' . $survey_id . '"'
		));

		if($question_sec) {
			foreach($question_sec as $i => $section) {
				$setArray[$i]['section_id'] = $section['survey_section_id'];
				$setArray[$i]['section_name'] = $section['section_title'];

				//find question
				$curQuestion = self::model()->findAll(array(
					'condition' => 'survey_section_id = "' . $section['survey_section_id'] . '"',
				));
				if($curQuestion) {
					foreach($curQuestion as $j => $question) {
						//cur choice
						$curChoice = QChoice::model()->findAll(array(
							'condition' => 'question_id ="' . $question['question_id'] . '"',
						));

						if($question['question_name'] != null ) {
							$setArray[$i]['question'][$question['question_id']]['title'] = $question['question_name'];
							if($question['question_range'] > 0) {
								$setArray[$i]['question'][$question['question_id']]['range'] = $question['question_range'];
							}
						}

						if($curChoice &&  $question['question_range'] > 0) {
							// $setArray[$i]['question'][$question['question_id']]['choice'] = $curChoice;
							foreach($curChoice as $choice) {
								$times = QAnswers::model()->findAll(array(
									'condition' => 'choice_id ="' . $choice['option_choice_id'] . '"',
								));
								$setArray[$i]['question'][$question['question_id']]['times'] = count($times);
								for ($k=1; $k <= 5; $k++) {
									$count = QAnswers::model()->findAll(array(
										'condition' => 'choice_id ="' . $choice['option_choice_id'] . '" and answer_numeric="'.$k.'"'
									));
									$curPercentage = count($count)*100/count($times);
									$setArray[$i]['question'][$question['question_id']]['title'][$k] = $choice['option_choice_name'];
									$setArray[$i]['question'][$question['question_id']]['answer'][$k] = ($curPercentage==0)?'-':round($curPercentage, 2) . '%';
								}
							}
						}
					}
				}
			}
		}
		return $setArray;
	}
}