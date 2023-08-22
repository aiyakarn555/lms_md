<?php

/**
 * This is the model class for table "c_groupquestionnaire".
 *
 * The followings are the available columns in table 'c_groupquestionnaire':
 * @property integer $Gna_nID
 * @property string $Gna_cNameTH
 * @property string $Gna_cNameEN
 * @property string $Gna_dStart
 * @property string $Gna_dEnd
 * @property string $cCreateBy
 * @property string $dCreateDate
 * @property string $cUpdateBy
 * @property string $dUpdateDate
 * @property string $cActive
 *
 * The followings are the available model relations:
 * @property MGroup[] $mGroups
 * @property TQuestionnairedate[] $tQuestionnairedates
 */
class CGroupquestionnaire extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'c_groupquestionnaire';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Gna_cNameTH, Gna_cNameEN, Gna_dStart, Gna_dEnd, cCreateBy, dCreateDate, cActive', 'required'),
			array('cCreateBy, cUpdateBy', 'length', 'max'=>255),
			array('cActive', 'length', 'max'=>1),
			array('dUpdateDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Gna_nID, Gna_cNameTH, Gna_cNameEN, Gna_dStart, Gna_dEnd, cCreateBy, dCreateDate, cUpdateBy, dUpdateDate, cActive', 'safe', 'on'=>'search'),
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
			'mGroups' => array(self::HAS_MANY, 'MGroup', 'Gna_nID'),
			'tQuestionnairedates' => array(self::HAS_MANY, 'TQuestionnairedate', 'Gna_nID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Gna_nID' => 'Gna N',
			'Gna_cNameTH' => 'Gna C Name Th',
			'Gna_cNameEN' => 'Gna C Name En',
			'Gna_dStart' => 'Gna D Start',
			'Gna_dEnd' => 'Gna D End',
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

		$criteria->compare('Gna_nID',$this->Gna_nID);
		$criteria->compare('Gna_cNameTH',$this->Gna_cNameTH,true);
		$criteria->compare('Gna_cNameEN',$this->Gna_cNameEN,true);
		$criteria->compare('Gna_dStart',$this->Gna_dStart,true);
		$criteria->compare('Gna_dEnd',$this->Gna_dEnd,true);
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
	 * @return CGroupquestionnaire the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
