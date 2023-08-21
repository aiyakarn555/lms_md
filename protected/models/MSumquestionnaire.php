<?php

/**
 * This is the model class for table "m_sumquestionnaire".
 *
 * The followings are the available columns in table 'm_sumquestionnaire':
 * @property integer $Sna_nID
 * @property string $cCreateBy
 * @property string $dCreateDate
 * @property string $cUpdateBy
 * @property string $dUpdateDate
 * @property string $cActive
 * @property integer $Que_nID
 * @property integer $Cho_nID
 *
 * The followings are the available model relations:
 * @property MGroup[] $mGroups
 * @property MQuestion $queN
 * @property MChoice $choN
 */
class MSumquestionnaire extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'm_sumquestionnaire';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cCreateBy, dCreateDate, cActive, Que_nID, Cho_nID', 'required'),
			array('Que_nID, Cho_nID', 'numerical', 'integerOnly'=>true),
			array('cCreateBy, cUpdateBy', 'length', 'max'=>255),
			array('cActive', 'length', 'max'=>1),
			array('dUpdateDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Sna_nID, cCreateBy, dCreateDate, cUpdateBy, dUpdateDate, cActive, Que_nID, Cho_nID', 'safe', 'on'=>'search'),
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
			'mGroups' => array(self::HAS_MANY, 'MGroup', 'Sna_nID'),
			'queN' => array(self::BELONGS_TO, 'MQuestion', 'Que_nID'),
			'choN' => array(self::BELONGS_TO, 'MChoice', 'Cho_nID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Sna_nID' => 'Sna N',
			'cCreateBy' => 'C Create By',
			'dCreateDate' => 'D Create Date',
			'cUpdateBy' => 'C Update By',
			'dUpdateDate' => 'D Update Date',
			'cActive' => 'C Active',
			'Que_nID' => 'Que N',
			'Cho_nID' => 'Cho N',
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

		$criteria->compare('Sna_nID',$this->Sna_nID);
		$criteria->compare('cCreateBy',$this->cCreateBy,true);
		$criteria->compare('dCreateDate',$this->dCreateDate,true);
		$criteria->compare('cUpdateBy',$this->cUpdateBy,true);
		$criteria->compare('dUpdateDate',$this->dUpdateDate,true);
		$criteria->compare('cActive',$this->cActive,true);
		$criteria->compare('Que_nID',$this->Que_nID);
		$criteria->compare('Cho_nID',$this->Cho_nID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MSumquestionnaire the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
