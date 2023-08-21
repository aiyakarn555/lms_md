<?php

/**
 * This is the model class for table "{{subdistrict}}".
 *
 * The followings are the available columns in table '{{subdistrict}}':
 * @property integer $sdt_id
 * @property integer $code
 * @property string $sdt_name_th
 * @property string $sdt_name_en
 * @property string $latitude
 * @property string $longitude
 * @property integer $dt_id
 * @property integer $zipcode
 *
 * The followings are the available model relations:
 * @property MtDistrict $dt
 */
class Subdistrict extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{subdistrict}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('latitude, longitude', 'required'),
			array('code, dt_id, zipcode', 'numerical', 'integerOnly'=>true),
			array('sdt_name_th, sdt_name_en', 'length', 'max'=>255),
			array('latitude, longitude', 'length', 'max'=>6),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sdt_id, code, sdt_name_th, sdt_name_en, latitude, longitude, dt_id, zipcode', 'safe', 'on'=>'search'),
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
			'dt' => array(self::BELONGS_TO, 'MtDistrict', 'dt_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sdt_id' => 'Sdt',
			'code' => 'Code',
			'sdt_name_th' => 'Sdt Name Th',
			'sdt_name_en' => 'Sdt Name En',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'dt_id' => 'Dt',
			'zipcode' => 'Zipcode',
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

		$criteria->compare('sdt_id',$this->sdt_id);
		$criteria->compare('code',$this->code);
		$criteria->compare('sdt_name_th',$this->sdt_name_th,true);
		$criteria->compare('sdt_name_en',$this->sdt_name_en,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('dt_id',$this->dt_id);
		$criteria->compare('zipcode',$this->zipcode);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Subdistrict the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
