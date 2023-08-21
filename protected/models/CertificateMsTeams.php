<?php

/**
 * This is the model class for table "{{certificate_ms_teams}}".
 *
 * The followings are the available columns in table '{{certificate_ms_teams}}':
 * @property integer $cert_id
 * @property integer $sign_id
 * @property integer $sign_id2
 * @property string $cert_number
 * @property string $cert_name
 * @property string $cert_background
 * @property string $cert_text
 * @property integer $cert_hide
 * @property integer $cert_hour
 * @property integer $cert_display
 * @property string $create_date
 * @property integer $create_by
 * @property string $update_date
 * @property integer $update_by
 * @property string $active
 * @property integer $cert_type
 */
class CertificateMsTeams extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{certificate_ms_teams}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sign_id, sign_id2', 'required'),
			array('sign_id, sign_id2, cert_hide, cert_hour, cert_display, create_by, update_by, cert_type', 'numerical', 'integerOnly'=>true),
			array('cert_number', 'length', 'max'=>100),
			array('cert_name', 'length', 'max'=>250),
			array('active', 'length', 'max'=>1),
			array('cert_background, cert_text, create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cert_id, sign_id, sign_id2, cert_number, cert_name, cert_background, cert_text, cert_hide, cert_hour, cert_display, create_date, create_by, update_date, update_by, active, cert_type', 'safe', 'on'=>'search'),
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
			'sign_id' => 'ลายเซนต์',
			'cert_name' => 'ชื่อใบประกาศนียบัตร',
			'cert_number' => 'เลขที่ใบประกาศนียบัตร',
			'cert_background' => 'พื้นหลัง',
			'cert_hide' => 'แสดงผล',
			'cert_hour' => 'Cert Hour',
			'cert_display' => 'ประเภทแสดงผล',
			'create_date' => 'วันที่เพิ่มข้อมูล',
			'create_by' => 'ผู้เพิ่มข้อมูล',
			'update_date' => 'วันที่แก้ไขข้อมูล',
			'update_by' => 'ผู้แก้ไขข้อมูล',
			'active' => 'y=แสดงผล n=ไม่แสดงผล',
			'cert_text' => 'ข้อความ',
			'cert_type' => 'cert_type',
			
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
		$criteria->compare('sign_id2',$this->sign_id2);
		$criteria->compare('cert_number',$this->cert_number,true);
		$criteria->compare('cert_name',$this->cert_name,true);
		$criteria->compare('cert_background',$this->cert_background,true);
		$criteria->compare('cert_text',$this->cert_text,true);
		$criteria->compare('cert_hide',$this->cert_hide);
		$criteria->compare('cert_hour',$this->cert_hour);
		$criteria->compare('cert_display',$this->cert_display);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_by',$this->create_by);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('cert_type',$this->cert_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CertificateMsTeams the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
