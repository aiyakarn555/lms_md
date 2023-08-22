<?php

/**
 * This is the model class for table "m_question".
 *
 * The followings are the available columns in table 'm_question':
 * @property integer $Que_nID
 * @property string $Que_cNameTH
 * @property string $Que_cNameEN
 * @property string $Que_cDetailTH
 * @property string $Que_cDetailEN
 * @property string $cCreateBy
 * @property string $dCreateDate
 * @property string $cUpdateBy
 * @property string $dUpdateDate
 * @property string $cActive
 * @property integer $Tit_nID
 * @property integer $Tan_nID
 *
 * The followings are the available model relations:
 * @property MTitlequestion $titN
 * @property MTypeanswer $tanN
 * @property MSumquestionnaire[] $mSumquestionnaires
 * @property TQuestionnairequestion[] $tQuestionnairequestions
 */
class MQuestion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'm_question';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Que_cNameTH, Que_cNameEN, cCreateBy, dCreateDate, cActive, Tit_nID, Tan_nID', 'required'),
			array('Tit_nID, Tan_nID', 'numerical', 'integerOnly'=>true),
			array('cCreateBy, cUpdateBy', 'length', 'max'=>255),
			array('cActive', 'length', 'max'=>1),
			array('Que_cDetailTH, Que_cDetailEN, dUpdateDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Que_nID, Que_cNameTH, Que_cNameEN, Que_cDetailTH, Que_cDetailEN, cCreateBy, dCreateDate, cUpdateBy, dUpdateDate, cActive, Tit_nID, Tan_nID', 'safe', 'on'=>'search'),
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
			'titN' => array(self::BELONGS_TO, 'MTitlequestion', 'Tit_nID'),
			'tanN' => array(self::BELONGS_TO, 'MTypeanswer', 'Tan_nID'),
			'mSumquestionnaires' => array(self::HAS_MANY, 'MSumquestionnaire', 'Que_nID'),
			'tQuestionnairequestions' => array(self::HAS_MANY, 'TQuestionnairequestion', 'Que_nID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Que_nID' => 'Que N',
			'Que_cNameTH' => 'Que C Name Th',
			'Que_cNameEN' => 'Que C Name En',
			'Que_cDetailTH' => 'Que C Detail Th',
			'Que_cDetailEN' => 'Que C Detail En',
			'cCreateBy' => 'C Create By',
			'dCreateDate' => 'D Create Date',
			'cUpdateBy' => 'C Update By',
			'dUpdateDate' => 'D Update Date',
			'cActive' => 'C Active',
			'Tit_nID' => 'Tit N',
			'Tan_nID' => 'Tan N',
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

		$criteria->compare('Que_nID',$this->Que_nID);
		$criteria->compare('Que_cNameTH',$this->Que_cNameTH,true);
		$criteria->compare('Que_cNameEN',$this->Que_cNameEN,true);
		$criteria->compare('Que_cDetailTH',$this->Que_cDetailTH,true);
		$criteria->compare('Que_cDetailEN',$this->Que_cDetailEN,true);
		$criteria->compare('cCreateBy',$this->cCreateBy,true);
		$criteria->compare('dCreateDate',$this->dCreateDate,true);
		$criteria->compare('cUpdateBy',$this->cUpdateBy,true);
		$criteria->compare('dUpdateDate',$this->dUpdateDate,true);
		$criteria->compare('cActive',$this->cActive,true);
		$criteria->compare('Tit_nID',$this->Tit_nID);
		$criteria->compare('Tan_nID',$this->Tan_nID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MQuestion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
