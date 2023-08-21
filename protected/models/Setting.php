<?php
class Setting extends AActiveRecord
{
	public function tableName()
	{
		return '{{setting}}';
	}

	public function rules()
	{
		return array(
			array('settings_testing, settings_intro_status,password_expire_day,settings_score', 'numerical', 'integerOnly'=>true),
			array('settings_user_email, settings_pass_email', 'length', 'max'=>255),
			array('settings_user_email, settings_pass_email', 'required'),
			array('settings_intro_detail, settings_score, settings_register, settings_confirmmail, settings_intro_bg_color, settings_institution, settings_email, settings_tel, settings_line, settings_register_office, settings_register_personal', 'safe'),
			array('setting_id, settings_score, settings_user_email, settings_register, settings_confirmmail, settings_pass_email, settings_testing, settings_intro_status, settings_intro_detail, settings_intro_bg_color, settings_institution, settings_email, settings_tel, settings_line, settings_register_office, settings_register_personal', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'setting_id' => 'Setting',
			'settings_user_email' => 'User Email ที่ใช้ในการส่งข้อมูล',
			'settings_pass_email' => 'Pass Email ที่ใช้ในการส่งข้อมูล',
			'settings_register' => 'เปิด-ปิด การลงทะเบียน',
			'settings_score' => 'เปอร์เซ็นการคำนวณคะแนน การทดสอบผ่าน (ใส่ค่า 80 คือผ่าน 80 เปอร์เซ็นของคะแนนสอบ)',
			'settings_testing' => 'เปิด-ปิด การเฉลยข้อสอบ',
			'settings_intro_status' => 'เปิด-ปิด หน้า Intro',
			'settings_intro_detail' => 'รายละเอียดหน้า Intro',
			'settings_intro_bg_color' => 'สีพื้นหลังหน้า Intro',
			'settings_intro_bg' => 'รูปภาพพื้นหลัง Intro',
			'settings_institution' => 'รหัสสถาบัญ',
			'settings_email' => 'อีเมล์ที่ติดต่อได้',
			'settings_tel' => 'เบอร์โทรศัพท์ที่ติดต่อได้',
			'settings_line' => 'line ที่ติดต่อได้',
			'password_expire_day' => 'จำนวนวัน ที่รหัสผ่าน User จะหมดอายุ (ใส่ 0 หรือเว้นว่างถ้าไม่กำหนด)',
			'settings_register_office' => 'settings_register_office',
			'settings_register_personal' => 'settings_register_personal',
		);
	}

	public function beforeSave()
	{
		$this->settings_email = CHtml::encode($this->settings_email);
		$this->settings_tel = CHtml::encode($this->settings_tel);
		$this->settings_line = CHtml::encode($this->settings_line);
		$this->settings_intro_detail = CHtml::encode($this->settings_intro_detail);
		$this->settings_institution = CHtml::encode($this->settings_institution);
		return parent::beforeSave();
	}

	public function afterFind()
	{
		$this->settings_email = CHtml::decode($this->settings_email);
		$this->settings_tel = CHtml::decode($this->settings_tel);
		$this->settings_line = CHtml::decode($this->settings_line);
		$this->settings_intro_detail = CHtml::decode($this->settings_intro_detail);
		$this->settings_institution = CHtml::decode($this->settings_institution);
		$this->settings_register = CHtml::decode($this->settings_register);
		$this->settings_confirmmail = CHtml::decode($this->settings_confirmmail);
		$this->settings_register_office = CHtml::decode($this->settings_register_office);
		return parent::afterFind();
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('setting_id',$this->setting_id);
		$criteria->compare('settings_user_email',$this->settings_user_email,true);
		$criteria->compare('settings_pass_email',$this->settings_pass_email,true);
		$criteria->compare('settings_testing',$this->settings_testing);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getId()
	{
		return $this->setting_id;
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
