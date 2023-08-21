<?php

/**
 * This is the model class for table "m_typeanswer".
 *
 * The followings are the available columns in table 'm_typeanswer':
 * @property integer $Tan_nID
 * @property string $Tan_cNameTH
 * @property string $Tan_cNameEN
 * @property string $Tan_cDescriptionTH
 * @property string $Tan_cDescriptionEN
 * @property string $Tan_cRulesTH
 * @property string $Tan_cRulesEN
 * @property string $cCreateBy
 * @property string $dCreateDate
 * @property string $cUpdateBy
 * @property string $dUpdateDate
 * @property string $cActive
 *
 * The followings are the available model relations:
 * @property MChoice[] $mChoices
 * @property MQuestion[] $mQuestions
 * @property MSubchoice[] $mSubchoices
 */
class MTypeanswer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'm_typeanswer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Tan_cNameTH, Tan_cNameEN, cCreateBy, dCreateDate, cActive', 'required'),
			array('cCreateBy, cUpdateBy', 'length', 'max'=>255),
			array('cActive', 'length', 'max'=>1),
			array('Tan_cDescriptionTH, Tan_cDescriptionEN, Tan_cRulesTH, Tan_cRulesEN, dUpdateDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Tan_nID, Tan_cNameTH, Tan_cNameEN, Tan_cDescriptionTH, Tan_cDescriptionEN, Tan_cRulesTH, Tan_cRulesEN, cCreateBy, dCreateDate, cUpdateBy, dUpdateDate, cActive', 'safe', 'on'=>'search'),
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
			'mChoices' => array(self::HAS_MANY, 'MChoice', 'Tan_nID'),
			'mQuestions' => array(self::HAS_MANY, 'MQuestion', 'Tan_nID'),
			'mSubchoices' => array(self::HAS_MANY, 'MSubchoice', 'Tan_nID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Tan_nID' => 'Tan N',
			'Tan_cNameTH' => 'Tan C Name Th',
			'Tan_cNameEN' => 'Tan C Name En',
			'Tan_cDescriptionTH' => 'Tan C Description Th',
			'Tan_cDescriptionEN' => 'Tan C Description En',
			'Tan_cRulesTH' => 'Tan C Rules Th',
			'Tan_cRulesEN' => 'Tan C Rules En',
			'cCreateBy' => 'C Create By',
			'dCreateDate' => 'D Create Date',
			'cUpdateBy' => 'C Update By',
			'dUpdateDate' => 'D Update Date',
			'cActive' => 'C Active',
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

		$criteria->compare('Tan_nID',$this->Tan_nID);
		$criteria->compare('Tan_cNameTH',$this->Tan_cNameTH,true);
		$criteria->compare('Tan_cNameEN',$this->Tan_cNameEN,true);
		$criteria->compare('Tan_cDescriptionTH',$this->Tan_cDescriptionTH,true);
		$criteria->compare('Tan_cDescriptionEN',$this->Tan_cDescriptionEN,true);
		$criteria->compare('Tan_cRulesTH',$this->Tan_cRulesTH,true);
		$criteria->compare('Tan_cRulesEN',$this->Tan_cRulesEN,true);
		$criteria->compare('cCreateBy',$this->cCreateBy,true);
		$criteria->compare('dCreateDate',$this->dCreateDate,true);
		$criteria->compare('cUpdateBy',$this->cUpdateBy,true);
		$criteria->compare('dUpdateDate',$this->dUpdateDate,true);
		$criteria->compare('cActive',$this->cActive,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MTypeanswer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
