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
			array('label_regis, label_homepage, label_identification, label_email, label_courseAll, label_placeholder_course, label_title, label_firstname, label_lastname, label_phone, label_station, label_company, label_position, label_placeholder_station, label_placeholder_company, label_placeholder_position, label_save, label_alert_identification, label_alert_notNumber, label_general_public, label_personnel, label_employee_id, label_passport, label_date_of_expiry, label_birthday, label_age, label_race, label_nationality, label_religion, label_sex, label_male, label_female, label_marital_status, label_single, label_marry, label_address, label_id_Line, label_history_of_severe_illness, label_never, label_ever, label_educational, label_education_level, label_academy, label_graduation_year, label_office, label_ship', 'length', 'max'=>255),
			array('label_accept, label_reject', 'length', 'max'=>100),
			array('label_dropdown_mr, label_dropdown_ms, label_dropdown_mrs', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label_regis, label_homepage, label_accept, label_reject, label_identification, label_email, label_courseAll, label_placeholder_course, label_title, label_firstname, label_lastname, label_phone, label_station, label_company, label_position, label_placeholder_station, label_placeholder_company, label_placeholder_position, label_save, label_alert_identification, label_alert_notNumber, label_dropdown_mr, label_dropdown_ms, label_dropdown_mrs, lang_id, parent_id, label_general_public, label_personnel, label_employee_id, label_passport, label_date_of_expiry, label_birthday, label_age, label_race, label_nationality, label_religion, label_sex, label_male, label_female, label_marital_status, label_single, label_marry, label_address, label_id_Line, label_history_of_severe_illness, label_never, label_ever, label_educational, label_education_level, label_academy, label_graduation_year, label_office, label_ship', 'safe', 'on'=>'search'),
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
			'label_regis' => 'Label Regis',
			'label_homepage' => 'Label Homepage',
			'label_accept' => 'Label Accept',
			'label_reject' => 'Label Reject',
			'label_identification' => 'Label Identification',
			'label_email' => 'Label Email',
			'label_courseAll' => 'Label Course All',
			'label_placeholder_course' => 'Label Placeholder Course',
			'label_title' => 'Label Title',
			'label_firstname' => 'Label Firstname',
			'label_lastname' => 'Label Lastname',
			'label_phone' => 'Label Phone',
			'label_station' => 'Label Station',
			'label_company' => 'Label Company',
			'label_position' => 'Label Position',
			'label_placeholder_station' => 'Label Placeholder Station',
			'label_placeholder_company' => 'Label Placeholder Company',
			'label_placeholder_position' => 'Label Placeholder Position',
			'label_save' => 'Label Save',
			'label_alert_identification' => 'Label Alert Identification',
			'label_alert_notNumber' => 'Label Alert Not Number',
			'label_dropdown_mr' => 'Label Dropdown Mr',
			'label_dropdown_ms' => 'Label Dropdown Ms',
			'label_dropdown_mrs' => 'Label Dropdown Mrs',
			'lang_id' => 'Lang',
			'parent_id' => 'Parent',
			'label_general_public' => 'Label General Public',
			'label_personnel' => 'Label Personnel',
			'label_employee_id' => 'Label Employee',
			'label_passport' => 'Label Passport',
			'label_date_of_expiry' => 'Label Date Of Expiry',
			'label_birthday' => 'Label Birthday',
			'label_age' => 'Label Age',
			'label_race' => 'Label Race',
			'label_nationality' => 'Label Nationality',
			'label_religion' => 'Label Religion',
			'label_sex' => 'Label Sex',
			'label_male' => 'Label Male',
			'label_female' => 'Label Female',
			'label_marital_status' => 'Label Marital Status',
			'label_single' => 'Label Single',
			'label_marry' => 'Label Marry',
			'label_address' => 'Label Address',
			'label_id_Line' => 'Label Id Line',
			'label_history_of_severe_illness' => 'Label History Of Severe Illness',
			'label_never' => 'Label Never',
			'label_ever' => 'Label Ever',
			'label_educational' => 'Label Educational',
			'label_education_level' => 'Label Education Level',
			'label_academy' => 'Label Academy',
			'label_graduation_year' => 'Label Graduation Year',
			'label_office' => 'Label Office',
			'label_ship' => 'Label Ship',
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
