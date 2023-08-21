<?php

/**
 * This is the model class for table "m_titlequestion".
 *
 * The followings are the available columns in table 'm_titlequestion':
 * @property integer $Tit_nID
 * @property string $Tit_cNameTH
 * @property string $Tit_cNameEN
 * @property string $Tit_cDetailTH
 * @property string $Tit_cDetailEN
 * @property string $cCreateBy
 * @property string $dCreateDate
 * @property string $cUpdateBy
 * @property string $dUpdateDate
 * @property string $cActive
 *
 * The followings are the available model relations:
 * @property MQuestion[] $mQuestions
 */
class MTitlequestion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'm_titlequestion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Tit_cNameTH, Tit_cNameEN, cCreateBy, dCreateDate, cActive', 'required'),
			array('cCreateBy, cUpdateBy', 'length', 'max'=>255),
			array('cActive', 'length', 'max'=>1),
			array('Tit_cDetailTH, Tit_cDetailEN, dUpdateDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Tit_nID, Tit_cNameTH, Tit_cNameEN, Tit_cDetailTH, Tit_cDetailEN, cCreateBy, dCreateDate, cUpdateBy, dUpdateDate, cActive', 'safe', 'on'=>'search'),
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
			'mQuestions' => array(self::HAS_MANY, 'MQuestion', 'Tit_nID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Tit_nID' => 'Tit N',
			'Tit_cNameTH' => 'Tit C Name Th',
			'Tit_cNameEN' => 'Tit C Name En',
			'Tit_cDetailTH' => 'Tit C Detail Th',
			'Tit_cDetailEN' => 'Tit C Detail En',
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

		$criteria->compare('Tit_nID',$this->Tit_nID);
		$criteria->compare('Tit_cNameTH',$this->Tit_cNameTH,true);
		$criteria->compare('Tit_cNameEN',$this->Tit_cNameEN,true);
		$criteria->compare('Tit_cDetailTH',$this->Tit_cDetailTH,true);
		$criteria->compare('Tit_cDetailEN',$this->Tit_cDetailEN,true);
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
	 * @return MTitlequestion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
