<?php

/**
 * This is the model class for table "{{trainee}}".
 *
 * The followings are the available columns in table '{{trainee}}':
 * @property integer $Id
 * @property integer $Version
 * @property string $FirstNameTh
 * @property string $LastNameTh
 * @property string $FirstNameEn
 * @property string $LastNameEn
 * @property string $NationalId
 * @property string $PassportId
 * @property string $SeamanBookId
 * @property string $DateOfBirth
 * @property string $NationalCardIssueDate
 * @property string $NationalCardExpiryDate
 * @property string $TelNumber
 * @property string $Email
 * @property string $TitleEn_id
 * @property string $TitleTh_id
 * @property string $Nationality_id
 */
class Trainee extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{trainee}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Version', 'required'),
			array('Version', 'numerical', 'integerOnly'=>true),
			array('TitleEn_id, TitleTh_id, Nationality_id', 'length', 'max'=>40),
			array('FirstNameTh, LastNameTh, FirstNameEn, LastNameEn, NationalId, PassportId, SeamanBookId, DateOfBirth, NationalCardIssueDate, NationalCardExpiryDate, TelNumber, Email', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, Version, FirstNameTh, LastNameTh, FirstNameEn, LastNameEn, NationalId, PassportId, SeamanBookId, DateOfBirth, NationalCardIssueDate, NationalCardExpiryDate, TelNumber, Email, TitleEn_id, TitleTh_id, Nationality_id', 'safe', 'on'=>'search'),
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
			'Id' => 'ID',
			'Version' => 'Version',
			'FirstNameTh' => 'First Name Th',
			'LastNameTh' => 'Last Name Th',
			'FirstNameEn' => 'First Name En',
			'LastNameEn' => 'Last Name En',
			'NationalId' => 'National',
			'PassportId' => 'Passport',
			'SeamanBookId' => 'Seaman Book',
			'DateOfBirth' => 'Date Of Birth',
			'NationalCardIssueDate' => 'National Card Issue Date',
			'NationalCardExpiryDate' => 'National Card Expiry Date',
			'TelNumber' => 'Tel Number',
			'Email' => 'Email',
			'TitleEn_id' => 'Title En',
			'TitleTh_id' => 'Title Th',
			'Nationality_id' => 'Nationality',
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

		$criteria->compare('Id',$this->Id);
		$criteria->compare('Version',$this->Version);
		$criteria->compare('FirstNameTh',$this->FirstNameTh,true);
		$criteria->compare('LastNameTh',$this->LastNameTh,true);
		$criteria->compare('FirstNameEn',$this->FirstNameEn,true);
		$criteria->compare('LastNameEn',$this->LastNameEn,true);
		$criteria->compare('NationalId',$this->NationalId,true);
		$criteria->compare('PassportId',$this->PassportId,true);
		$criteria->compare('SeamanBookId',$this->SeamanBookId,true);
		$criteria->compare('DateOfBirth',$this->DateOfBirth,true);
		$criteria->compare('NationalCardIssueDate',$this->NationalCardIssueDate,true);
		$criteria->compare('NationalCardExpiryDate',$this->NationalCardExpiryDate,true);
		$criteria->compare('TelNumber',$this->TelNumber,true);
		$criteria->compare('Email',$this->Email,true);
		$criteria->compare('TitleEn_id',$this->TitleEn_id,true);
		$criteria->compare('TitleTh_id',$this->TitleTh_id,true);
		$criteria->compare('Nationality_id',$this->Nationality_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Trainee the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
