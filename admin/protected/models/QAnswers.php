<?php
/**
 * This is the model class for table "q_answers".
 *
 * The followings are the available columns in table 'q_answers':
 * @property integer $answer_id
 * @property integer $user_id
 * @property integer $question_option_id
 * @property integer $choice_id
 * @property integer $answer_numeric
 * @property string $answer_text
 * @property string $answer_textarea
 * @property string $answer_yn
 * @property integer $quest_ans_id
 */
class QAnswers extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return QAnswers the static model class
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
		return 'q_answers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, question_option_id, choice_id, answer_numeric, quest_ans_id', 'numerical', 'integerOnly'=>true),
			array('answer_text', 'length', 'max'=>255),
			array('answer_yn', 'length', 'max'=>1),
			array('answer_textarea', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('answer_id, user_id, question_option_id, choice_id, answer_numeric, answer_text, answer_textarea, answer_yn, quest_ans_id', 'safe', 'on'=>'search'),
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
			'answer_id' => 'Answer',
			'user_id' => 'User',
			'question_option_id' => 'Question Option',
			'choice_id' => 'Choice',
			'answer_numeric' => 'Answer Numeric',
			'answer_text' => 'Answer Text',
			'answer_textarea' => 'Answer Textarea',
			'answer_yn' => 'Answer Yn',
			'quest_ans_id' => 'User Survey Period',
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

		$criteria->compare('answer_id',$this->answer_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('question_option_id',$this->question_option_id);
		$criteria->compare('choice_id',$this->choice_id);
		$criteria->compare('answer_numeric',$this->answer_numeric);
		$criteria->compare('answer_text',$this->answer_text,true);
		$criteria->compare('answer_textarea',$this->answer_textarea,true);
		$criteria->compare('answer_yn',$this->answer_yn,true);
		$criteria->compare('quest_ans_id',$this->quest_ans_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}