<?php

/**
 * This is the model class for table "t_questionnairequestion".
 *
 * The followings are the available columns in table 't_questionnairequestion':
 * @property integer $Qna_nID
 * @property string $Que_cNameTH
 * @property string $Que_cNameEN
 * @property string $cCreateBy
 * @property string $dCreateDate
 * @property string $cUpdateBy
 * @property string $dUpdateDate
 * @property string $cActive
 * @property integer $Que_nID
 * @property integer $Yna_nID
 *
 * The followings are the available model relations:
 * @property TAnswerquestionnaire[] $tAnswerquestionnaires
 * @property MQuestion $queN
 * @property TQuestionnairedate $ynaN
 */
class TQuestionnairequestion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 't_questionnairequestion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Que_cNameTH, cCreateBy, dCreateDate, cActive, Que_nID, Yna_nID', 'required'),
			array('Que_nID, Yna_nID', 'numerical', 'integerOnly'=>true),
			array('cCreateBy, cUpdateBy', 'length', 'max'=>255),
			array('cActive', 'length', 'max'=>1),
			array('Que_cNameEN, dUpdateDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Qna_nID, Que_cNameTH, Que_cNameEN, cCreateBy, dCreateDate, cUpdateBy, dUpdateDate, cActive, Que_nID, Yna_nID', 'safe', 'on'=>'search'),
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
			'tAnswerquestionnaires' => array(self::HAS_MANY, 'TAnswerquestionnaire', 'Qna_nID'),
			'queN' => array(self::BELONGS_TO, 'MQuestion', 'Que_nID'),
			'ynaN' => array(self::BELONGS_TO, 'TQuestionnairedate', 'Yna_nID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Qna_nID' => 'Qna N',
			'Que_cNameTH' => 'Que C Name Th',
			'Que_cNameEN' => 'Que C Name En',
			'cCreateBy' => 'C Create By',
			'dCreateDate' => 'D Create Date',
			'cUpdateBy' => 'C Update By',
			'dUpdateDate' => 'D Update Date',
			'cActive' => 'C Active',
			'Que_nID' => 'Que N',
			'Yna_nID' => 'Yna N',
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

		$criteria->compare('Qna_nID',$this->Qna_nID);
		$criteria->compare('Que_cNameTH',$this->Que_cNameTH,true);
		$criteria->compare('Que_cNameEN',$this->Que_cNameEN,true);
		$criteria->compare('cCreateBy',$this->cCreateBy,true);
		$criteria->compare('dCreateDate',$this->dCreateDate,true);
		$criteria->compare('cUpdateBy',$this->cUpdateBy,true);
		$criteria->compare('dUpdateDate',$this->dUpdateDate,true);
		$criteria->compare('cActive',$this->cActive,true);
		$criteria->compare('Que_nID',$this->Que_nID);
		$criteria->compare('Yna_nID',$this->Yna_nID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TQuestionnairequestion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
