<?php

/**
 * This is the model class for table "m_choice".
 *
 * The followings are the available columns in table 'm_choice':
 * @property integer $Cho_nID
 * @property string $Cho_cNameTH
 * @property string $Cho_cNameEN
 * @property integer $Cho_nScore
 * @property integer $stat_txt
 * @property string $cCreateBy
 * @property string $dCreateDate
 * @property string $cUpdateBy
 * @property string $dUpdateDate
 * @property string $cActive
 * @property integer $Tan_nID
 *
 * The followings are the available model relations:
 * @property MTypeanswer $tanN
 * @property MSubchoice[] $mSubchoices
 * @property MSumquestionnaire[] $mSumquestionnaires
 * @property TAnswerquestionnaire[] $tAnswerquestionnaires
 */
class MChoice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'm_choice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Cho_cNameTH, Cho_cNameEN, cCreateBy, dCreateDate, cActive, Tan_nID', 'required'),
			array('Cho_nScore, stat_txt, Tan_nID', 'numerical', 'integerOnly'=>true),
			array('cCreateBy, cUpdateBy', 'length', 'max'=>255),
			array('cActive', 'length', 'max'=>1),
			array('dUpdateDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Cho_nID, Cho_cNameTH, Cho_cNameEN, Cho_nScore, stat_txt, cCreateBy, dCreateDate, cUpdateBy, dUpdateDate, cActive, Tan_nID', 'safe', 'on'=>'search'),
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
			'tanN' => array(self::BELONGS_TO, 'MTypeanswer', 'Tan_nID'),
			'mSubchoices' => array(self::HAS_MANY, 'MSubchoice', 'Cho_nID'),
			'mSumquestionnaires' => array(self::HAS_MANY, 'MSumquestionnaire', 'Cho_nID'),
			'tAnswerquestionnaires' => array(self::HAS_MANY, 'TAnswerquestionnaire', 'Cho_nID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Cho_nID' => 'Cho N',
			'Cho_cNameTH' => 'Cho C Name Th',
			'Cho_cNameEN' => 'Cho C Name En',
			'Cho_nScore' => 'Cho N Score',
			'stat_txt' => 'Stat Txt',
			'cCreateBy' => 'C Create By',
			'dCreateDate' => 'D Create Date',
			'cUpdateBy' => 'C Update By',
			'dUpdateDate' => 'D Update Date',
			'cActive' => 'C Active',
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

		$criteria->compare('Cho_nID',$this->Cho_nID);
		$criteria->compare('Cho_cNameTH',$this->Cho_cNameTH,true);
		$criteria->compare('Cho_cNameEN',$this->Cho_cNameEN,true);
		$criteria->compare('Cho_nScore',$this->Cho_nScore);
		$criteria->compare('stat_txt',$this->stat_txt);
		$criteria->compare('cCreateBy',$this->cCreateBy,true);
		$criteria->compare('dCreateDate',$this->dCreateDate,true);
		$criteria->compare('cUpdateBy',$this->cUpdateBy,true);
		$criteria->compare('dUpdateDate',$this->dUpdateDate,true);
		$criteria->compare('cActive',$this->cActive,true);
		$criteria->compare('Tan_nID',$this->Tan_nID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MChoice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
