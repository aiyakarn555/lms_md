<?php

/**
 * This is the model class for table "m_grading".
 *
 * The followings are the available columns in table 'm_grading':
 * @property integer $Gra_nID
 * @property integer $Gra_nScore
 * @property string $Gra_cDetailTH
 * @property string $Gra_cDetailEN
 * @property string $cCreateBy
 * @property string $dCreateDate
 * @property string $cUpdateBy
 * @property string $dUpdateDate
 * @property string $cActive
 *
 * The followings are the available model relations:
 * @property TAnswerquestionnaire[] $tAnswerquestionnaires
 */
class MGrading extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'm_grading';
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
			array('Gra_nScore', 'numerical', 'integerOnly'=>true),
			array('cCreateBy, cUpdateBy', 'length', 'max'=>255),
			array('cActive', 'length', 'max'=>1),
			array('Gra_cDetailTH, Gra_cDetailEN, dUpdateDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Gra_nID, Gra_nScore, Gra_cDetailTH, Gra_cDetailEN, cCreateBy, dCreateDate, cUpdateBy, dUpdateDate, cActive', 'safe', 'on'=>'search'),
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
			'tAnswerquestionnaires' => array(self::HAS_MANY, 'TAnswerquestionnaire', 'Gra_nID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Gra_nID' => 'Gra N',
			'Gra_nScore' => 'Gra N Score',
			'Gra_cDetailTH' => 'Gra C Detail Th',
			'Gra_cDetailEN' => 'Gra C Detail En',
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

		$criteria->compare('Gra_nID',$this->Gra_nID);
		$criteria->compare('Gra_nScore',$this->Gra_nScore);
		$criteria->compare('Gra_cDetailTH',$this->Gra_cDetailTH,true);
		$criteria->compare('Gra_cDetailEN',$this->Gra_cDetailEN,true);
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
	 * @return MGrading the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
