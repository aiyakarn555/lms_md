<?php

/**
 * This is the model class for table "{{district}}".
 *
 * The followings are the available columns in table '{{district}}':
 * @property integer $dt_id
 * @property integer $code
 * @property string $dt_name_th
 * @property string $dt_name_en
 * @property integer $pv_id
 *
 * The followings are the available model relations:
 * @property MtProvince $pv
 */
class District extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{district}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, pv_id', 'numerical', 'integerOnly'=>true),
			array('dt_name_th, dt_name_en', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dt_id, code, dt_name_th, dt_name_en, pv_id', 'safe', 'on'=>'search'),
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
			'pv' => array(self::BELONGS_TO, 'MtProvince', 'pv_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'dt_id' => 'Dt',
			'code' => 'Code',
			'dt_name_th' => 'Dt Name Th',
			'dt_name_en' => 'Dt Name En',
			'pv_id' => 'Pv',
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

		$criteria->compare('dt_id',$this->dt_id);
		$criteria->compare('code',$this->code);
		$criteria->compare('dt_name_th',$this->dt_name_th,true);
		$criteria->compare('dt_name_en',$this->dt_name_en,true);
		$criteria->compare('pv_id',$this->pv_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return District the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
