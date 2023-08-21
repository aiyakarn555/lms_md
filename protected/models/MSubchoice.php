<?php

/**
 * This is the model class for table "m_subchoice".
 *
 * The followings are the available columns in table 'm_subchoice':
 * @property integer $Sch_nID
 * @property string $Sch_cNameTH
 * @property string $Sch_cNameEN
 * @property integer $Cho_nScore
 * @property integer $stat_txt
 * @property string $cCreateBy
 * @property string $dCreateDate
 * @property string $cUpdateBy
 * @property string $dUpdateDate
 * @property string $cActive
 * @property integer $Cho_nID
 * @property integer $Tan_nID
 *
 * The followings are the available model relations:
 * @property MChoice $choN
 * @property MTypeanswer $tanN
 * @property TAnswerquestionnaire[] $tAnswerquestionnaires
 */
class MSubchoice extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'm_subchoice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Sch_cNameTH, Sch_cNameEN, cCreateBy, dCreateDate, cActive, Cho_nID, Tan_nID', 'required'),
			array('Cho_nScore, stat_txt, Cho_nID, Tan_nID', 'numerical', 'integerOnly'=>true),
			array('cCreateBy, cUpdateBy', 'length', 'max'=>255),
			array('cActive', 'length', 'max'=>1),
			array('dUpdateDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Sch_nID, Sch_cNameTH, Sch_cNameEN, Cho_nScore, stat_txt, cCreateBy, dCreateDate, cUpdateBy, dUpdateDate, cActive, Cho_nID, Tan_nID', 'safe', 'on'=>'search'),
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
			'tanN' => array(self::BELONGS_TO, 'MTypeanswer', 'Tan_nID'),
			'tAnswerquestionnaires' => array(self::HAS_MANY, 'TAnswerquestionnaire', 'Sch_nID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Sch_nID' => 'Sch N',
			'Sch_cNameTH' => 'Sch C Name Th',
			'Sch_cNameEN' => 'Sch C Name En',
			'Cho_nScore' => 'Cho N Score',
			'stat_txt' => 'Stat Txt',
			'cCreateBy' => 'C Create By',
			'dCreateDate' => 'D Create Date',
			'cUpdateBy' => 'C Update By',
			'dUpdateDate' => 'D Update Date',
			'cActive' => 'C Active',
			'Cho_nID' => 'Cho N',
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

		$criteria->compare('Sch_nID',$this->Sch_nID);
		$criteria->compare('Sch_cNameTH',$this->Sch_cNameTH,true);
		$criteria->compare('Sch_cNameEN',$this->Sch_cNameEN,true);
		$criteria->compare('Cho_nScore',$this->Cho_nScore);
		$criteria->compare('stat_txt',$this->stat_txt);
		$criteria->compare('cCreateBy',$this->cCreateBy,true);
		$criteria->compare('dCreateDate',$this->dCreateDate,true);
		$criteria->compare('cUpdateBy',$this->cUpdateBy,true);
		$criteria->compare('dUpdateDate',$this->dUpdateDate,true);
		$criteria->compare('cActive',$this->cActive,true);
		$criteria->compare('Cho_nID',$this->Cho_nID);
		$criteria->compare('Tan_nID',$this->Tan_nID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MSubchoice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
