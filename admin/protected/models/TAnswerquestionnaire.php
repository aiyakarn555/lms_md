<?php

/**
 * This is the model class for table "t_answerquestionnaire".
 *
 * The followings are the available columns in table 't_answerquestionnaire':
 * @property integer $Ans_nID
 * @property string $Cho_cNameTH
 * @property string $Cho_cNameEN
 * @property string $Sch_cNameTH
 * @property string $Sch_cNameEN
 * @property string $Ans_Description
 * @property string $Ans_cOther
 * @property string $Ans_cComment
 * @property string $cCreateBy
 * @property string $dCreateDate
 * @property string $cUpdateBy
 * @property string $dUpdateDate
 * @property string $cActive
 * @property integer $Gra_nID
 * @property integer $Qna_nID
 * @property integer $Cho_nID
 * @property integer $Sch_nID
 *
 * The followings are the available model relations:
 * @property MChoice $choN
 * @property MGrading $graN
 * @property MSubchoice $schN
 * @property TQuestionnairequestion $qnaN
 */
class TAnswerquestionnaire extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 't_answerquestionnaire';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cCreateBy, dCreateDate, cActive', 'required'),
			array('Gra_nID, Qna_nID, Cho_nID, Sch_nID', 'numerical', 'integerOnly'=>true),
			array('cCreateBy, cUpdateBy', 'length', 'max'=>255),
			array('cActive', 'length', 'max'=>1),
			array('Cho_cNameTH, Cho_cNameEN, Sch_cNameTH, Sch_cNameEN, Ans_Description, Ans_cOther, Ans_cComment, dUpdateDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Ans_nID, Cho_cNameTH, Cho_cNameEN, Sch_cNameTH, Sch_cNameEN, Ans_Description, Ans_cOther, Ans_cComment, cCreateBy, dCreateDate, cUpdateBy, dUpdateDate, cActive, Gra_nID, Qna_nID, Cho_nID, Sch_nID', 'safe', 'on'=>'search'),
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
			'choN' => array(self::BELONGS_TO, 'MChoice', 'Cho_nID'),
			'graN' => array(self::BELONGS_TO, 'MGrading', 'Gra_nID'),
			'schN' => array(self::BELONGS_TO, 'MSubchoice', 'Sch_nID'),
			'qnaN' => array(self::BELONGS_TO, 'TQuestionnairequestion', 'Qna_nID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Ans_nID' => 'Ans N',
			'Cho_cNameTH' => 'Cho C Name Th',
			'Cho_cNameEN' => 'Cho C Name En',
			'Sch_cNameTH' => 'Sch C Name Th',
			'Sch_cNameEN' => 'Sch C Name En',
			'Ans_Description' => 'Ans Description',
			'Ans_cOther' => 'Ans C Other',
			'Ans_cComment' => 'Ans C Comment',
			'cCreateBy' => 'C Create By',
			'dCreateDate' => 'D Create Date',
			'cUpdateBy' => 'C Update By',
			'dUpdateDate' => 'D Update Date',
			'cActive' => 'C Active',
			'Gra_nID' => 'Gra N',
			'Qna_nID' => 'Qna N',
			'Cho_nID' => 'Cho N',
			'Sch_nID' => 'Sch N',
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

		$criteria->compare('Ans_nID',$this->Ans_nID);
		$criteria->compare('Cho_cNameTH',$this->Cho_cNameTH,true);
		$criteria->compare('Cho_cNameEN',$this->Cho_cNameEN,true);
		$criteria->compare('Sch_cNameTH',$this->Sch_cNameTH,true);
		$criteria->compare('Sch_cNameEN',$this->Sch_cNameEN,true);
		$criteria->compare('Ans_Description',$this->Ans_Description,true);
		$criteria->compare('Ans_cOther',$this->Ans_cOther,true);
		$criteria->compare('Ans_cComment',$this->Ans_cComment,true);
		$criteria->compare('cCreateBy',$this->cCreateBy,true);
		$criteria->compare('dCreateDate',$this->dCreateDate,true);
		$criteria->compare('cUpdateBy',$this->cUpdateBy,true);
		$criteria->compare('dUpdateDate',$this->dUpdateDate,true);
		$criteria->compare('cActive',$this->cActive,true);
		$criteria->compare('Gra_nID',$this->Gra_nID);
		$criteria->compare('Qna_nID',$this->Qna_nID);
		$criteria->compare('Cho_nID',$this->Cho_nID);
		$criteria->compare('Sch_nID',$this->Sch_nID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TAnswerquestionnaire the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
