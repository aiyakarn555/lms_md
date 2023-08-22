<?php

class Profile extends UActiveRecord
{
	/**
	 * The followings are the available columns in table 'profiles':
	 * @var integer $user_id
	 * @var boolean $regMode
	 */
	public $regMode = false;
	
	private $_model;
	private $_modelReg;
	private $_rules = array();
	public $file_user;
	public $id;

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->getModule('user')->tableProfiles;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array( 
            // array('firstname, lastname,identification', 'required'),
            // array('firstname, lastname', 'required'),
            // array('age', 'numerical', 'integerOnly'=>true),
            // array('bussiness_model_id,bussiness_type_id,company,juristic,title_id, type_user, education, occupation, position, website, province, tel, phone, fax, advisor_email1, advisor_email2, generation, file,department, passport, date_of_expiry, race, nationality, religion, line_id, ship_id, ship_up_date, ship_down_date, address2, phone1, phone2, phone3, seamanbook, seaman_expire, pass_expire, ss_card,firstname_en,lastname_en, tax_payer, place_of_birth, hight, weight, hair_color, eye_color, place_issued, blood, spouse_firstname, spouse_lastname, father_firstname, father_lastname, mother_firstname, mother_lastname, military, sickness, start_working, occupation_spouse, occupation_father, occupation_mother, address_parent, mouth_birth, passport_place_issued, passport_date_issued, name_emergency, relationship_emergency', 'length', 'max'=>255),
            // array('firstname, lastname, expected_salary', 'length', 'max'=>50),
            // array('identification', 'length', 'max'=>13),
            // array('identification', 'length', 'max'=>13, 'min' => 13,'message' => 'กรอกเลขบัตรประชาชน 13 หลักเท่านั้น'),
            // array('sex,title_id', 'length', 'max'=>6),
            // array('identification', 'validateIdCard'),
            // array('identification', 'unique'
        
            //  , 'message' => 'เลขบัตรประชาชนนี้มีในระบบแล้ว'),

            // The following rule is used by search(). 
            // Please remove those attributes that should not be searched. 
            // array('bussiness_model_id,bussiness_type_id,company,juristic,user_id, title_id, firstname, lastname, active, generation, type_user, sex, birthday, age, education, occupation, position, website, address, province, tel, phone, fax, contactfrom, advisor_email1, advisor_email2, file,department, passport, date_of_expiry, race, nationality, religion, line_id, ship_id, ship_up_date, ship_down_date, address2, phone1, phone2, phone3, seamanbook, seaman_expire, pass_expire, ss_card,firstname_en,lastname_en, tax_payer, place_of_birth, hight, weight, hair_color, eye_color, place_issued, blood, spouse_firstname, spouse_lastname, father_firstname, father_lastname, mother_firstname, mother_lastname, military, sickness, start_working, occupation_spouse, occupation_father, occupation_mother, address_parent, mouth_birth, passport_place_issued, passport_date_issued, name_emergency, relationship_emergency', 'safe', 'on'=>'search'),
            // array('file_user', 'file', 'types'=>'pdf','allowEmpty' => true, 'on'=>'insert'),
			// array('file_user', 'file', 'types'=>'pdf',
			// 	'wrongType' => 'รองรับไฟล์ pdf เท่านั้น', 'allowEmpty' => true, // ข้อความเตือน
            //     'maxSize' => 1024 * 1024 * 5, // 5 MB
            //     'tooLarge' => 'ขนาดไฟล์ไม่เกิน 5MB' // ขนาดไฟล์
            //     ),
        ); 
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		$relations = array(
			'user'=>array(self::HAS_ONE, 'User', 'id'),
			'type_name'=>array(self::BELONGS_TO, 'TypeUser', 'type_user'),
			'ProfilesTitle'=>array(self::BELONGS_TO, 'ProfilesTitle', 'prefix_th'),
			'typeEmployee'=>array(self::BELONGS_TO, 'TypeEmployee', 'type_employee'),
		);
		if (isset(Yii::app()->getModule('user')->profileRelations)) $relations = array_merge($relations,Yii::app()->getModule('user')->profileRelations);
		return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */

	public function validateIdCard($attribute,$params){
        $str = $this->identification;
        $chk = strlen($str);
        if($chk == "13"){
            $id = str_split(str_replace('-', '', $this->identification)); //ตัดรูปแบบและเอา ตัวอักษร ไปแยกเป็น array $id
            $sum = 0;
            $total = 0;
            $digi = 13;
            for ($i = 0; $i < 12; $i++) {
                $sum = $sum + (intval($id[$i]) * $digi);
                $digi--;
            }
            $total = (11 - ($sum % 11)) % 10;
            if ($total != $id[12]) { //ตัวที่ 13 มีค่าไม่เท่ากับผลรวมจากการคำนวณ ให้ add error
                $this->addError('identification', 'เลขบัตรประชาชนนี้ไม่ถูกต้อง ตามการคำนวณของระบบฐานข้อมูลทะเบียนราษฎร์*');
            }
        }
    }

	public function attributeLabels()
	{
		return array( 
            'user_id' => UserModule::t('User ID'),
            'prefix_th' => 'คำนำหน้าชื่อ',
            'prefix_en' => 'คำนำหน้าชื่อ',
            'firstname' => UserModule::t('First Name'),
            'lastname' => UserModule::t('Last Name'),
            // 'firstname_en' => 'Firstname',
            // 'lastname_en' => 'Lastname',
            'privatemessage_return' => 'ข้อความตอบกลับ',
            'identification' => 'รหัสบัตรประชาชน',
            'type_user' => 'ประเภทสมาชิก',
            'sex' => "เพศ",
            'birthday' => 'วันเกิด',
            'age' => "อายุ",
            'education' => 'วุฒิการศึกษา',
            'occupation' => 'อาชีพ',
            'position' => UserModule::t('Position'),
            'website' => UserModule::t('Website'),
            'address' => 'ที่อยู่',
            'province' => 'จังหวัด',
            'tel' =>'โทรศัพท์',
            'phone' => 'โทรศัพท์เคลื่อนที่',
            'fax' => 'โทรสาร',
            'contactfrom' => 'ทราบช่องทางการติดต่อจากที่ใด',
            'advisor_email1' => UserModule::t('Advisor Email1'),
            'advisor_email2' => UserModule::t('Advisor Email2'),
            'file' => UserModule::t('File'),
            'generation'=>'รหัสรุ่น',
            'bussiness_model_id'=>'รูปแบบธุรกิจ',
            'bussiness_type_id'=>'ประเภทของธุรกิจ',
            'company'=>'ชื่อหน่วยงาน/บริษัท',
            'juristic'=>'เลขทะเบียนนิติบุคคล',
            'department' => 'หน่วยงาน',
            'passport' => 'เลขหนังสือเดินทาง',
            'date_of_expiry' => 'วันที่บัตรหมดอายุ',
            'race' => 'เชื้อชาติ',
            'nationality' => 'สัญชาติ',
            'religion' => 'ศาสนา',
            'history_of_illness' => 'ประวัติเจ็บป่วยรุนแรง',
            'status_sm' => 'สถานภาพ',
            'type_employee'=> 'ประเภทพนักงาน',
            'type_card'=> 'ประเภทบัตร',
            'line_id' => 'ID Line',
            'ship_id' => 'ชื่อเรือที่ขึ้น',
            'address2' => 'ที่อยู่ปัจจุบันที่สามารถติดต่อได้',
            'ship_up_date' => 'วันที่ขึ้นจากเรือ',
            'ship_down_date'=> 'วันที่กลับไปขึ้นเรือ',
            'phone1'=> 'เบอร์โทรศัพท์ที่สามารถติดต่อได้',
            'phone2' => 'เบอร์มือถือ',
            'phone3' => 'โทรศัพท์อื่นๆที่สามารถติดต่อได้',
            'seamanbook'=> 'เลขหนังสือประจำลูกเรือ',
            'seaman_expire'=> 'วันหมดอายุ(หนังสือประจำลูกเรือ)',
            'pass_expire' => 'pass_expire',
            'ss_card' => 'บัตรประกันสังคมเลขที่',
            'tax_payer' => 'เลขที่บัตรประจำตัวผู้เสียภาษีอากร',
            'number_of_children'=>'จำนวนบุตร', 
            'place_of_birth'=>'สถานที่เกิด', 
            'hight'=>'ส่วนสูง', 
            'weight'=>'น้ำหนัก', 
            'hair_color'=>'สีผม', 
            'eye_color'=>'สีตา', 
            'place_issued'=>'สถานที่ออกบัตร',
            'date_issued'=>'วันที่ออกบัตร', 
            'blood'=>'กรุ๊ปเลือด', 
            'spouse_firstname'=>'ชื่อคู่สมรส', 
            'spouse_lastname'=>'นามสกุลคู่สมรส', 
            'father_firstname'=>'ชื่อบิดา', 
            'father_lastname'=>'นามสกุลบิดา',
            'mother_firstname'=>'ชื่อมารดา', 
            'mother_lastname'=>'นามสกุลมารดา', 
            'military'=>'สถานะการรับใช้ชาติ', 
            'sickness'=>'โรคที่เคยป่วย', 
            'expected_salary'=>'เงินเดือนที่คาดหวัง', 
            'start_working'=>'พร้อมที่จะเริ่มงานเมื่อ', 
            'accommodation'=>'ที่พัก', 
            'domicile_address'=>'ที่อยู่ตามภูมิลำเนา',
            'occupation_spouse'=>'อาชีพคู่สมรส',
            'occupation_father'=>'อาชีพบิดา',
            'occupation_mother'=>'อาชีพมารดา',
            'address_parent'=>'ที่อยู่อาศัยตามบัตรประชาชน',
            'mouth_birth'=>'เดือน',
            'passport_place_issued'=>'สถานที่ออกบัตร',
            'passport_date_issued'=>'วันที่ออกบัตร',
            'name_emergency'=>'ชือบุคคลติดต่อฉุกเฉิน',
            'relationship_emergency'=>'ความสัมพันธ์',
            'employee_code'=>'รหัสพนักงาน',
            'group_bu' => 'Group BU',
            'bu' => 'BU',
            'department' => 'Department',
            'division' => 'Division',
            'section' => 'Section',
            'sub_section' => 'Sub Section',
        ); 
	}
	
	private function rangeRules($str) {
		$rules = explode(';',$str);
		for ($i=0;$i<count($rules);$i++)
			$rules[$i] = current(explode("==",$rules[$i]));
		return $rules;
	}
	
	static public function range($str,$fieldValue=NULL) {
		$rules = explode(';',$str);
		$array = array();
		for ($i=0;$i<count($rules);$i++) {
			$item = explode("==",$rules[$i]);
			if (isset($item[0])) $array[$item[0]] = ((isset($item[1]))?$item[1]:$item[0]);
		}
		if (isset($fieldValue)) 
			if (isset($array[$fieldValue])) return $array[$fieldValue]; else return '';
		else
			return $array;
	}
	
	public function widgetAttributes() {
		$data = array();
		$model=$this->getFields();
		
		foreach ($model as $field) {
			if ($field->widget) $data[$field->varname]=$field->widget;
		}
		return $data;
	}
	
	public function widgetParams($fieldName) {
		$data = array();
		$model=$this->getFields();
		
		foreach ($model as $field) {
			if ($field->widget) $data[$field->varname]=$field->widgetparams;
		}
		return $data[$fieldName];
	}

	public function getEmail(){
		return $this->user->email;
	}
	
	public function getFields() {
		if ($this->regMode) {
			if (!$this->_modelReg)
				$this->_modelReg=ProfileField::model()->forRegistration()->findAll();
			return $this->_modelReg;
		} else {
			if (!$this->_model)
				$this->_model=ProfileField::model()->forOwner()->findAll();
			return $this->_model;
		}
	}

	public function getFullname() {
		if(!empty($this->firstname) && !empty($this->lastname)){
			$str = $this->firstname . ' ' . $this->lastname;
		}
		return $str;
	}
}