<?php

/**
 * This is the model class for table "m_group".
 *
 * The followings are the available columns in table 'm_group':
 * @property integer $Gro_nID
 * @property string $cCreateBy
 * @property string $dCreateDate
 * @property string $cUpdateBy
 * @property string $cUpdateDate
 * @property string $cActive
 * @property integer $Gna_nID
 * @property integer $Sna_nID
 *
 * The followings are the available model relations:
 * @property CGroupquestionnaire $gnaN
 * @property MSumquestionnaire $snaN
 */
class MGroup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'm_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cCreateBy, dCreateDate, cActive, Gna_nID, Sna_nID', 'required'),
			array('Gna_nID, Sna_nID', 'numerical', 'integerOnly'=>true),
			array('cCreateBy, cUpdateBy', 'length', 'max'=>255),
			array('cActive', 'length', 'max'=>1),
			array('cUpdateDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Gro_nID, cCreateBy, dCreateDate, cUpdateBy, cUpdateDate, cActive, Gna_nID, Sna_nID', 'safe', 'on'=>'search'),
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
			'gnaN' => array(self::BELONGS_TO, 'CGroupquestionnaire', 'Gna_nID'),
			'snaN' => array(self::BELONGS_TO, 'MSumquestionnaire', 'Sna_nID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Gro_nID' => 'Gro N',
			'cCreateBy' => 'C Create By',
			'dCreateDate' => 'D Create Date',
			'cUpdateBy' => 'C Update By',
			'cUpdateDate' => 'C Update Date',
			'cActive' => 'C Active',
			'Gna_nID' => 'Gna N',
			'Sna_nID' => 'Sna N',
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

		$criteria->compare('Gro_nID',$this->Gro_nID);
		$criteria->compare('cCreateBy',$this->cCreateBy,true);
		$criteria->compare('dCreateDate',$this->dCreateDate,true);
		$criteria->compare('cUpdateBy',$this->cUpdateBy,true);
		$criteria->compare('cUpdateDate',$this->cUpdateDate,true);
		$criteria->compare('cActive',$this->cActive,true);
		$criteria->compare('Gna_nID',$this->Gna_nID);
		$criteria->compare('Sna_nID',$this->Sna_nID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MGroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
