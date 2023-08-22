<?php

/**
 * This is the model class for table "{{menu_registration}}".
 *
 * The followings are the available columns in table '{{menu_registration}}':
 * @property integer $id
 * @property string $label_regis
 * @property string $label_homepage
 * @property string $label_accept
 * @property string $label_reject
 * @property string $label_identification
 * @property string $label_email
 * @property string $label_courseAll
 * @property string $label_placeholder_course
 * @property string $label_title
 * @property string $label_firstname
 * @property string $label_lastname
 * @property string $label_phone
 * @property string $label_station
 * @property string $label_company
 * @property string $label_position
 * @property string $label_placeholder_station
 * @property string $label_placeholder_company
 * @property string $label_placeholder_position
 * @property string $label_save
 * @property string $label_alert_identification
 * @property string $label_alert_notNumber
 * @property string $label_dropdown_mr
 * @property string $label_dropdown_ms
 * @property string $label_dropdown_mrs
 * @property integer $lang_id
 * @property integer $parent_id
 * @property string $label_general_public
 * @property string $label_personnel
 * @property string $label_employee_id
 * @property string $label_passport
 * @property string $label_date_of_expiry
 * @property string $label_birthday
 * @property string $label_age
 * @property string $label_race
 * @property string $label_nationality
 * @property string $label_religion
 * @property string $label_sex
 * @property string $label_male
 * @property string $label_female
 * @property string $label_marital_status
 * @property string $label_single
 * @property string $label_marry
 * @property string $label_address
 * @property string $label_id_Line
 * @property string $label_history_of_severe_illness
 * @property string $label_never
 * @property string $label_ever
 * @property string $label_educational
 * @property string $label_education_level
 * @property string $label_academy
 * @property string $label_graduation_year
 * @property string $label_office
 * @property string $label_ship
 * @property string $label_branch
 * @property string $label_placeholder_branch
 * @property string $label_boat_person_report
 * @property string $label_boat_name
 * @property string $label_placeholder_boat_name
 * @property string $label_adress2
 * @property string $label_placeholder_address2
 * @property string $label_ship_up_date
 * @property string $label_ship_down_date
 * @property string $label_phone1
 * @property string $label_phone2
 * @property string $label_phone3
 * @property string $label_seamanbook
 * @property string $label_spouse_firstname
 * @property string $label_spouse_lastname
 * @property string $label_father_firstname
 * @property string $label_father_lastname
 * @property string $label_mother_firstname
 * @property string $label_mother_lastname
 * @property string $label_military
 * @property string $label_sickness
 * @property string $label_expected_salary
 * @property string $label_start_working
 * @property string $label_accommodation
 * @property string $label_domicile_address
 * @property string $label_occupation
 * @property string $label_ss_card
 * @property string $label_tax_payer
 * @property string $label_number_of_children
 * @property string $label_place_of_birth
 * @property string $label_place_issued
 * @property string $label_date_issued
 * @property string $label_tel
 * @property string $label_ship_public
 * @property string $label_name_emergency
 * @property string $label_relationship_emergency
 * @property string $label_FileAttachIdentification
 * @property string $label_FileAttachPassport
 * @property string $label_FileAttachCrewIdentification
 * @property string $label_AttachCopiesOfHousePaticular
 * @property string $label_OwnHouse
 * @property string $label_RentHouse
 * @property string $label_WithParents
 * @property string $label_Apartment
 * @property string $label_WithRelative
 * @property string $label_Enlisted
 * @property string $label_NotEnlisted
 * @property string $label_Exempt
 * @property string $label_month
 * @property string $label_blood
 * @property string $label_height
 * @property string $label_weight
 * @property string $label_addressParent
 */
class MenuRegistration extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{menu_registration}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id, lang_id, parent_id', 'numerical', 'integerOnly'=>true),
			array('label_regis, label_homepage, label_OwnHouse, label_RentHouse, label_WithParents, label_Apartment, label_WithRelative, label_Enlisted, label_NotEnlisted, label_Exempt, label_month, label_blood, label_height, label_weight', 'length', 'max'=>50),
			array('label_accept, label_reject, label_identification, label_email, label_courseAll, label_placeholder_course, label_title, label_firstname, label_lastname, label_phone, label_station, label_company, label_position, label_placeholder_station, label_placeholder_company, label_placeholder_position, label_save, label_alert_identification, label_alert_notNumber, label_general_public, label_personnel, label_employee_id, label_passport, label_date_of_expiry, label_birthday, label_age, label_race, label_nationality, label_religion, label_sex, label_male, label_female, label_marital_status, label_single, label_marry, label_address, label_id_Line, label_history_of_severe_illness, label_never, label_ever, label_educational, label_education_level, label_academy, label_graduation_year, label_office, label_ship, label_branch, label_placeholder_branch, label_boat_person_report, label_boat_name, label_placeholder_boat_name, label_adress2, label_placeholder_address2, label_ship_up_date, label_ship_down_date, label_phone1, label_phone2, label_phone3, label_seamanbook, label_spouse_firstname, label_spouse_lastname, label_father_firstname, label_father_lastname, label_mother_firstname, label_mother_lastname, label_military, label_sickness, label_expected_salary, label_start_working, label_accommodation, label_domicile_address, label_occupation, label_ss_card, label_tax_payer, label_number_of_children, label_place_of_birth, label_place_issued, label_date_issued, label_tel, label_ship_public, label_name_emergency, label_relationship_emergency, label_FileAttachIdentification, label_FileAttachPassport, label_FileAttachCrewIdentification, label_AttachCopiesOfHousePaticular, label_addressParent', 'length', 'max'=>100),
			array('label_dropdown_mr, label_dropdown_ms, label_dropdown_mrs', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label_regis, label_homepage, label_accept, label_reject, label_identification, label_email, label_courseAll, label_placeholder_course, label_title, label_firstname, label_lastname, label_phone, label_station, label_company, label_position, label_placeholder_station, label_placeholder_company, label_placeholder_position, label_save, label_alert_identification, label_alert_notNumber, label_dropdown_mr, label_dropdown_ms, label_dropdown_mrs, lang_id, parent_id, label_general_public, label_personnel, label_employee_id, label_passport, label_date_of_expiry, label_birthday, label_age, label_race, label_nationality, label_religion, label_sex, label_male, label_female, label_marital_status, label_single, label_marry, label_address, label_id_Line, label_history_of_severe_illness, label_never, label_ever, label_educational, label_education_level, label_academy, label_graduation_year, label_office, label_ship, label_branch, label_placeholder_branch, label_boat_person_report, label_boat_name, label_placeholder_boat_name, label_adress2, label_placeholder_address2, label_ship_up_date, label_ship_down_date, label_phone1, label_phone2, label_phone3, label_seamanbook, label_spouse_firstname, label_spouse_lastname, label_father_firstname, label_father_lastname, label_mother_firstname, label_mother_lastname, label_military, label_sickness, label_expected_salary, label_start_working, label_accommodation, label_domicile_address, label_occupation, label_ss_card, label_tax_payer, label_number_of_children, label_place_of_birth, label_place_issued, label_date_issued, label_tel, label_ship_public, label_name_emergency, label_relationship_emergency, label_FileAttachIdentification, label_FileAttachPassport, label_FileAttachCrewIdentification, label_AttachCopiesOfHousePaticular, label_OwnHouse, label_RentHouse, label_WithParents, label_Apartment, label_WithRelative, label_Enlisted, label_NotEnlisted, label_Exempt, label_month, label_blood, label_height, label_weight, label_addressParent', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'label_regis' => 'สมัครเรียน',
			'label_homepage' => 'หน้าแรก',
			'label_accept' => 'ยอมรับ',
			'label_reject' => 'ไม่ยอมรับ',
			'label_identification' => 'เลขบัตรประจำตัวประชาชน',
			'label_email' => 'Email',
			'label_courseAll' => 'เลือกหลักสูตร',
			'label_placeholder_course' => 'กรุณาเลือกหลักสูตร',
			'label_title' => 'คำนำหน้า',
			'label_firstname' => 'ชื่อ',
			'label_lastname' => 'นามสกุล',
			'label_phone' => 'เบอร์โทรศัพท์',
			'label_station' => 'สถานี',
			'label_company' => 'แผนก',
			'label_position' => 'ตำแหน่ง',
			'label_placeholder_station' => 'เลือกสถานี',
			'label_placeholder_company' => 'เลือกแผนก',
			'label_placeholder_position' => 'เลือกตำแหน่ง',
			'label_save' => 'บันทึกข้อมูล',
			'label_alert_identification' => 'เลขบัตรประชาชนนี้ไม่ถูกต้อง ตามการคำนวณของระบบฐานข้อมูลทะเบียนราษฎร',
			'label_alert_notNumber' => 'ต้องเป็นตัวเลขเท่านั้น...กรุณาตรวจสอบข้อมูลของท่านอีกครั้ง...',
			'label_dropdown_mr' => 'นาย',
			'label_dropdown_ms' => 'นางสาว',
			'label_dropdown_mrs' => 'นาง',
			'lang_id' => 'Lang',
			'parent_id' => 'Parent',
			'label_general_public' => 'สำหรับบุคคลทั่วไป',
			'label_personnel' => 'สำหรับพนักงาน',
			'label_employee_id' => 'เลขประจำตัวพนักงาน',
			'label_passport' => 'เลขหนังสือเดินทาง',
			'label_date_of_expiry' => 'วันที่บัตรหมดอายุ',
			'label_birthday' => 'วันเดือนปีเกิด',
			'label_age' => 'อายุ',
			'label_race' => 'เชื้อชาติ',
			'label_nationality' => 'สัญชาติ',
			'label_religion' => 'ศาสนา',
			'label_sex' => 'เพศ',
			'label_male' => 'ชาย',
			'label_female' => 'หญิง',
			'label_marital_status' => 'สถานะภาพทางการสมรส',
			'label_single' => 'โสด',
			'label_marry' => 'สมรส',
			'label_address' => 'ที่อยู่',
			'label_id_Line' => 'ไอดีไลน์',
			'label_history_of_severe_illness' => 'ประวัติการเจ็บป่วยรุนแรง',
			'label_never' => 'ไม่เคย',
			'label_ever' => 'เคย',
			'label_educational' => 'ประวัติการศึกษา',
			'label_education_level' => 'ระดับการศึกษา',
			'label_academy' => 'สถานที่จบการศึกษา',
			'label_graduation_year' => 'ปีที่จบการศึกษา',
			'label_office' => 'ออฟฟิต',
			'label_ship' => 'เรือ',
			'label_branch' => 'ระดับ',
			'label_placeholder_branch' => 'เลือกระดับ',
			'label_boat_person_report' => 'ใบรายงานตัวคนประจำเรือ',
			'label_boat_name' => 'ขึ้นจากเรือชื่อ',
			'label_placeholder_boat_name' => 'ชื่อเรือ',
			'label_adress2' => 'ที่อยู่ปัจจุบันที่สามารถติดต่อได้',
			'label_placeholder_address2' => 'เขียนที่อยู่ตรงนี้',
			'label_ship_up_date' => 'เมื่อวันที่',
			'label_ship_down_date' => 'สามารถจะลงทำงานเรือครั้งต่อไป',
			'label_phone1' => 'เบอร์โทรศัพท์ที่สามารถติดต่อได้',
			'label_phone2' => 'เบอร์มือถือ',
			'label_phone3' => 'โทรศัพท์อื่นๆที่สามารถติดต่อได้',
			'label_seamanbook' => 'เลขหนังสือประจำลูกเรือ',
			'label_spouse_firstname' => 'ชื่อคู่สมรส',
			'label_spouse_lastname' => 'นามสกุลคู่สมรส',
			'label_father_firstname' => 'ชื่อบิดา',
			'label_father_lastname' => 'นามสกุลบิดา',
			'label_mother_firstname' => 'ชื่อมารดา',
			'label_mother_lastname' => 'นามสกุลมารดา',
			'label_military' => 'สถานะการรับใช้ชาติ',
			'label_sickness' => 'โรคที่เคยป่วย',
			'label_expected_salary' => 'เงินเดือนที่คาดหวัง',
			'label_start_working' => 'พร้อมที่จะเริ่มงานเมื่อ',
			'label_accommodation' => 'ที่อยู่อาศัย',
			'label_domicile_address' => 'ที่อยู่ตามบัตรประชาชน',
			'label_occupation' => 'อาชีพ',
			'label_ss_card' => 'บัตรประกันสังคมเลขที่',
			'label_tax_payer' => 'เลขที่บัตรประจำตัวผู้เสียภาษีอากร',
			'label_number_of_children' => 'จำนวนบุตร',
			'label_place_of_birth' => 'สถานที่เกิด',
			'label_place_issued' => 'สถานที่ออกบัตร',
			'label_date_issued' => 'วันที่ออกบัตร',
			'label_tel' => 'โทรศัพท์ที่ติดต่อฉุกเฉิน',
			'label_ship_public'=>'สำหรับคนประจำเรือ',
			'label_name_emergency'=>'ชื่อผู้ที่ติดต่อฉุกเฉิน',
			'label_relationship_emergency'=>'ความสัมพันธ์',
			'label_FileAttachIdentification' => 'ไฟล์สำเนาบัตรประชาชน',
			'label_FileAttachPassport' => 'ไฟล์พาสปอร์ต',
			'label_FileAttachCrewIdentification' => 'ไฟล์หนังสือประจำตัวลูกเรือ',
			'label_AttachCopiesOfHousePaticular' => 'ไฟล์สำเนาทะเบียนบ้าน',
			'label_OwnHouse' => 'ของตนเอง',
			'label_RentHouse' => 'บ้านเช่า',
			'label_WithParents' => 'อาศัยอยู่กับบิดามารดา',
			'label_Apartment' => 'อพาร์ทเม้นท์',
			'label_WithRelative' => 'อยู่กับญาติ/เพื่อน',
			'label_Enlisted' => 'เกณฑ์แล้ว',
			'label_NotEnlisted' => 'ยังไม่ได้เกณฑ์',
			'label_Exempt' => 'ได้รับการยกเว้น',
			'label_month' => 'เดือน',
			'label_blood' => 'กรุ๊ปเลือด',
			'label_height' => 'ส่วนสูง',
			'label_weight' => 'น้ำหนัก',
			'label_addressParent' => 'ใช้ที่อยู่ตามบัตรประชาชน',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('label_regis',$this->label_regis,true);
		$criteria->compare('label_homepage',$this->label_homepage,true);
		$criteria->compare('label_accept',$this->label_accept,true);
		$criteria->compare('label_reject',$this->label_reject,true);
		$criteria->compare('label_identification',$this->label_identification,true);
		$criteria->compare('label_email',$this->label_email,true);
		$criteria->compare('label_courseAll',$this->label_courseAll,true);
		$criteria->compare('label_placeholder_course',$this->label_placeholder_course,true);
		$criteria->compare('label_title',$this->label_title,true);
		$criteria->compare('label_firstname',$this->label_firstname,true);
		$criteria->compare('label_lastname',$this->label_lastname,true);
		$criteria->compare('label_phone',$this->label_phone,true);
		$criteria->compare('label_station',$this->label_station,true);
		$criteria->compare('label_company',$this->label_company,true);
		$criteria->compare('label_position',$this->label_position,true);
		$criteria->compare('label_placeholder_station',$this->label_placeholder_station,true);
		$criteria->compare('label_placeholder_company',$this->label_placeholder_company,true);
		$criteria->compare('label_placeholder_position',$this->label_placeholder_position,true);
		$criteria->compare('label_save',$this->label_save,true);
		$criteria->compare('label_alert_identification',$this->label_alert_identification,true);
		$criteria->compare('label_alert_notNumber',$this->label_alert_notNumber,true);
		$criteria->compare('label_dropdown_mr',$this->label_dropdown_mr,true);
		$criteria->compare('label_dropdown_ms',$this->label_dropdown_ms,true);
		$criteria->compare('label_dropdown_mrs',$this->label_dropdown_mrs,true);
		$criteria->compare('lang_id',$this->lang_id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('label_general_public',$this->label_general_public,true);
		$criteria->compare('label_personnel',$this->label_personnel,true);
		$criteria->compare('label_employee_id',$this->label_employee_id,true);
		$criteria->compare('label_passport',$this->label_passport,true);
		$criteria->compare('label_date_of_expiry',$this->label_date_of_expiry,true);
		$criteria->compare('label_birthday',$this->label_birthday,true);
		$criteria->compare('label_age',$this->label_age,true);
		$criteria->compare('label_race',$this->label_race,true);
		$criteria->compare('label_nationality',$this->label_nationality,true);
		$criteria->compare('label_religion',$this->label_religion,true);
		$criteria->compare('label_sex',$this->label_sex,true);
		$criteria->compare('label_male',$this->label_male,true);
		$criteria->compare('label_female',$this->label_female,true);
		$criteria->compare('label_marital_status',$this->label_marital_status,true);
		$criteria->compare('label_single',$this->label_single,true);
		$criteria->compare('label_marry',$this->label_marry,true);
		$criteria->compare('label_address',$this->label_address,true);
		$criteria->compare('label_id_Line',$this->label_id_Line,true);
		$criteria->compare('label_history_of_severe_illness',$this->label_history_of_severe_illness,true);
		$criteria->compare('label_never',$this->label_never,true);
		$criteria->compare('label_ever',$this->label_ever,true);
		$criteria->compare('label_educational',$this->label_educational,true);
		$criteria->compare('label_education_level',$this->label_education_level,true);
		$criteria->compare('label_academy',$this->label_academy,true);
		$criteria->compare('label_graduation_year',$this->label_graduation_year,true);
		$criteria->compare('label_office',$this->label_office,true);
		$criteria->compare('label_ship',$this->label_ship,true);
		$criteria->compare('label_branch',$this->label_branch,true);
		$criteria->compare('label_placeholder_branch',$this->label_placeholder_branch,true);
		$criteria->compare('label_boat_person_report',$this->label_boat_person_report,true);
		$criteria->compare('label_boat_name',$this->label_boat_name,true);
		$criteria->compare('label_placeholder_boat_name',$this->label_placeholder_boat_name,true);
		$criteria->compare('label_adress2',$this->label_adress2,true);
		$criteria->compare('label_placeholder_address2',$this->label_placeholder_address2,true);
		$criteria->compare('label_ship_up_date',$this->label_ship_up_date,true);
		$criteria->compare('label_ship_down_date',$this->label_ship_down_date,true);
		$criteria->compare('label_phone1',$this->label_phone1,true);
		$criteria->compare('label_phone2',$this->label_phone2,true);
		$criteria->compare('label_phone3',$this->label_phone3,true);
		$criteria->compare('label_seamanbook',$this->label_seamanbook,true);
		$criteria->compare('label_spouse_firstname',$this->label_spouse_firstname,true);
		$criteria->compare('label_spouse_lastname',$this->label_spouse_lastname,true);
		$criteria->compare('label_father_firstname',$this->label_father_firstname,true);
		$criteria->compare('label_father_lastname',$this->label_father_lastname,true);
		$criteria->compare('label_mother_firstname',$this->label_mother_firstname,true);
		$criteria->compare('label_mother_lastname',$this->label_mother_lastname,true);
		$criteria->compare('label_military',$this->label_military,true);
		$criteria->compare('label_sickness',$this->label_sickness,true);
		$criteria->compare('label_expected_salary',$this->label_expected_salary,true);
		$criteria->compare('label_start_working',$this->label_start_working,true);
		$criteria->compare('label_accommodation',$this->label_accommodation,true);
		$criteria->compare('label_domicile_address',$this->label_domicile_address,true);
		$criteria->compare('label_occupation',$this->label_occupation,true);
		$criteria->compare('label_ss_card',$this->label_ss_card,true);
		$criteria->compare('label_tax_payer',$this->label_tax_payer,true);
		$criteria->compare('label_number_of_children',$this->label_number_of_children,true);
		$criteria->compare('label_place_of_birth',$this->label_place_of_birth,true);
		$criteria->compare('label_place_issued',$this->label_place_issued,true);
		$criteria->compare('label_date_issued',$this->label_date_issued,true);
		$criteria->compare('label_tel',$this->label_tel,true);
		$criteria->compare('label_ship_public',$this->label_ship_public,true);
		$criteria->compare('label_name_emergency',$this->label_name_emergency,true);
		$criteria->compare('label_relationship_emergency',$this->label_relationship_emergency,true);
		$criteria->compare('label_FileAttachIdentification',$this->label_FileAttachIdentification,true);
		$criteria->compare('label_FileAttachPassport',$this->label_FileAttachPassport,true);
		$criteria->compare('label_FileAttachCrewIdentification',$this->label_FileAttachCrewIdentification,true);
		$criteria->compare('label_AttachCopiesOfHousePaticular',$this->label_AttachCopiesOfHousePaticular,true);
		$criteria->compare('label_OwnHouse',$this->label_OwnHouse,true);
		$criteria->compare('label_RentHouse',$this->label_RentHouse,true);
		$criteria->compare('label_WithParents',$this->label_WithParents,true);
		$criteria->compare('label_Apartment',$this->label_Apartment,true);
		$criteria->compare('label_WithRelative',$this->label_WithRelative,true);
		$criteria->compare('label_Enlisted',$this->label_Enlisted,true);
		$criteria->compare('label_NotEnlisted',$this->label_NotEnlisted,true);
		$criteria->compare('label_Exempt',$this->label_Exempt,true);
		$criteria->compare('label_month',$this->label_month,true);
		$criteria->compare('label_blood',$this->label_blood,true);
		$criteria->compare('label_height',$this->label_height,true);
		$criteria->compare('label_weight',$this->label_weight,true);
		$criteria->compare('label_addressParent',$this->label_addressParent,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MenuRegistration the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
