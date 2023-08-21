<?php

/**
 * This is the model class for table "{{certificate}}".
 *
 * The followings are the available columns in table '{{certificate}}':
 * @property integer $cert_id
 * @property integer $sign_id
 * @property string $cert_number
 * @property string $cert_name
 * @property string $cert_background
 * @property integer $cert_hide
 * @property integer $cert_hour
 * @property integer $cert_display
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 */
class Certificate extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{certificate}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sign_id', 'required'),
			array('sign_id, cert_hide, cert_hour, cert_display, create_by, update_by', 'numerical', 'integerOnly'=>true),
			array('cert_number', 'length', 'max'=>100),
			array('cert_name', 'length', 'max'=>250),
			array('active', 'length', 'max'=>1),
			array('cert_background, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cert_id, sign_id, cert_number, cert_name, cert_background, cert_hide, cert_hour, cert_display, create_date, create_by, update_date, update_by, active', 'safe', 'on'=>'search'),
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
			'usercreate' => array(self::BELONGS_TO, 'User', 'create_by'),
			'signature' => array(self::BELONGS_TO, 'Signature', 'sign_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cert_id' => 'รหัส ใบ cert',
			'sign_id' => 'Sign',
			'cert_number' => 'Cert Number',
			'cert_name' => 'ชื่อใบ cert',
			'cert_background' => 'พื้นหลัง',
			'cert_hide' => '1=display 0=hide',
			'cert_hour' => 'Cert Hour',
			'cert_display' => 'Cert Display',
			'create_date' => 'วันที่สร้าง',
			'create_by' => 'สร้างโดย',
			'update_date' => 'วันที่แก้ไข',
			'update_by' => 'แก้ไขโดย',
			'active' => 'y=แสดงผล n=ไม่แสดงผล',
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

		$criteria->compare('cert_id',$this->cert_id);
		$criteria->compare('sign_id',$this->sign_id);
		$criteria->compare('cert_number',$this->cert_number,true);
		$criteria->compare('cert_name',$this->cert_name,true);
		$criteria->compare('cert_background',$this->cert_background,true);
		$criteria->compare('cert_hide',$this->cert_hide);
		$criteria->compare('cert_hour',$this->cert_hour);
		$criteria->compare('cert_display',$this->cert_display);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Certificate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
