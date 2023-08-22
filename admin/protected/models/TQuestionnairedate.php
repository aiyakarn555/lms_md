<?php

/**
 * This is the model class for table "t_questionnairedate".
 *
 * The followings are the available columns in table 't_questionnairedate':
 * @property integer $Yna_nID
 * @property string $Yna_dDate
 * @property string $cCreateBy
 * @property string $dCreateDate
 * @property string $cUpdateBy
 * @property string $dUpdateDate
 * @property string $cActive
 * @property integer $Gna_nID
 * @property integer $Mem_nID
 *
 * The followings are the available model relations:
 * @property MGroupquestionnaire $gnaN
 * @property TQuestionnairequestion[] $tQuestionnairequestions
 */
class TQuestionnairedate extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 't_questionnairedate';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Yna_dDate, cCreateBy, dCreateDate, cActive, Gna_nID, Mem_nID', 'required'),
			array('Gna_nID, Mem_nID', 'numerical', 'integerOnly'=>true),
			array('cCreateBy, cUpdateBy', 'length', 'max'=>255),
			array('cActive', 'length', 'max'=>1),
			array('dUpdateDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Yna_nID, Yna_dDate, cCreateBy, dCreateDate, cUpdateBy, dUpdateDate, cActive, Gna_nID, Mem_nID', 'safe', 'on'=>'search'),
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
			'gnaN' => array(self::BELONGS_TO, 'MGroupquestionnaire', 'Gna_nID'),
			'tQuestionnairequestions' => array(self::HAS_MANY, 'TQuestionnairequestion', 'Yna_nID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Yna_nID' => 'Yna N',
			'Yna_dDate' => 'Yna D Date',
			'cCreateBy' => 'C Create By',
			'dCreateDate' => 'D Create Date',
			'cUpdateBy' => 'C Update By',
			'dUpdateDate' => 'D Update Date',
			'cActive' => 'C Active',
			'Gna_nID' => 'Gna N',
			'Mem_nID' => 'Mem N',
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

		$criteria->compare('Yna_nID',$this->Yna_nID);
		$criteria->compare('Yna_dDate',$this->Yna_dDate,true);
		$criteria->compare('cCreateBy',$this->cCreateBy,true);
		$criteria->compare('dCreateDate',$this->dCreateDate,true);
		$criteria->compare('cUpdateBy',$this->cUpdateBy,true);
		$criteria->compare('dUpdateDate',$this->dUpdateDate,true);
		$criteria->compare('cActive',$this->cActive,true);
		$criteria->compare('Gna_nID',$this->Gna_nID);
		$criteria->compare('Mem_nID',$this->Mem_nID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TQuestionnairedate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
