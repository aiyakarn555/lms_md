<?php

/**
 * This is the model class for table "{{users}}".
 *
 * The followings are the available columns in table '{{users}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $pic_user
 * @property string $orgchart_lv2
 * @property string $department_id
 * @property string $activkey
 * @property string $create_at
 * @property string $lastvisit_at
 * @property integer $superuser
 * @property integer $status
 * @property integer $online_status
 * @property integer $online_user
 * @property string $last_ip
 * @property string $last_activity
 * @property integer $lastactivity
 * @property string $avatar
 * @property string $company_id
 * @property string $division_id
 * @property string $position_id
 * @property string $bookkeeper_id
 * @property string $pic_cardid
 * @property integer $auditor_id
 * @property string $pic_cardid2
 * @property string $group
 * @property string $identification
 *
 * The followings are the available model relations:
 * @property Profiles $profiles
 */
class UsersAdmin extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $repeat_password;
	public $update_password;
	public $repeat_updatepassword;
	public $search_username;
	public $id_passport;
	public $course_id;
	public $news_per_page;
	public $name_search;
	public function tableName()
	{
		return '{{users}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, email, department_id, create_at', 'required'),
			array('department_id, superuser, status', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>20),
			array('password, email, activkey', 'length', 'max'=>128),
			array('pic_user', 'length', 'max'=>255),
			array('lastvisit_at,name_search', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, email, pic_user, department_id, activkey, create_at, lastvisit_at, superuser, status,name_search', 'safe', 'on'=>'search'),
		);
		// return array(
		// 	array('username, password, repeat_password, email, create_at,group', 'required'),
		// 	array('superuser, status, online_status, online_user, lastactivity, auditor_id, type_idcard', 'numerical', 'integerOnly'=>true),
		// 	array('username', 'length', 'max'=>13),
		// 	array('password, email, activkey', 'length', 'max'=>128),
		// 	array('pic_user, orgchart_lv2, department_id, avatar, company_id, division_id, position_id, pic_cardid, pic_cardid2, group, identification', 'length', 'max'=>255),
		// 	array('last_ip', 'length', 'max'=>100),
		// 	array('bookkeeper_id', 'length', 'max'=>13),
		// 	array('user_active,lastvisit_at, last_activity,name_search,news_per_page', 'safe'),
		// 	// array('email', 'unique', 'message' => 'อีเมล์นี้ถูกใช้งานแล้ว'),
		// 	array('username', 'unique', 'message' => 'รหัสบัตรประชาชน หรือ พาสปอร์ตถูกใช้งานแล้ว'),
		// 	// The following rule is used by search().
		// 	// @todo Please remove those attributes that should not be searched.
		// 	array('user_active,id, username, password, email, pic_user, orgchart_lv2, department_id, activkey, create_at, lastvisit_at, superuser, status, online_status, online_user, last_ip, last_activity, lastactivity, avatar, company_id, division_id, position_id, bookkeeper_id, pic_cardid, auditor_id, pic_cardid2, group, identification, repeat_updatepassword, update_password, id_passport, type_idcard, course_id, name_search, news_per_page', 'safe', 'on'=>'search'),
		// 	array('repeat_password', 'compare', 'compareAttribute'=>'password'),
		// 	array('repeat_updatepassword','compare', 'compareAttribute'=>'update_password'),
		// 	array('username','validateIdCard',),
		// 	array('identification','validateIdCard2'),
		// 	);
	}

	protected function afterSave()
	{
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		parent::afterSave();
	}

	public function validateIdCard($attribute,$params)
	{
		$str = $this->username;
		$chk = strlen($str);
		if($chk =="13"){
	        $id = str_split(str_replace('-', '', $this->username)); //ตัดรูปแบบและเอา ตัวอักษร ไปแยกเป็น array $id
	        $sum = 0;
	        $total = 0;
	        $digi = 13;
	        for ($i = 0; $i < 12; $i++) {
	        	$sum = $sum + (intval($id[$i]) * $digi);
	        	$digi--;
	        }
	        $total = (11 - ($sum % 11)) % 10;
	        if ($total != $id[12]) { //ตัวที่ 13 มีค่าไม่เท่ากับผลรวมจากการคำนวณ ให้ add error
	        	$this->addError('username', 'หมายเลขบัตรประชาชนไม่ถูกต้อง');
	        }
	    }
	}
	public function validateIdCard2($attribute,$params)
	{
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
	        	$this->addError('identification', 'หมายเลขบัตรประชาชนไม่ถูกต้อง');
	        }
	    }
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			// 'member' => array(self::HAS_ONE, 'MMember', array('m_id' => 'id')),
			'profiles' => array(self::HAS_ONE, 'Profiles', array('user_id' => 'id')),
			'divisions' => array(self::HAS_ONE, 'Division', array('id' => 'division_id')),
			'departments' => array(self::HAS_ONE, 'Department', array('id' => 'department_id')),
			'company' => array(self::HAS_ONE, 'Company', array('company_id' => 'company_id')),
			'position' => array(self::HAS_ONE, 'Position', array('id' => 'position_id')),


			);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'pic_user' => 'Pic User',
			'department_id' => 'Department',
			'activkey' => 'Activkey',
			'create_at' => 'Create At',
			'lastvisit_at' => 'Lastvisit At',
			'superuser' => 'Superuser',
			'status' => 'Status',
			'name_search'=>'ชื่อ - นามสกุล(ไทย-Eng), บัตรประชาชน, พาสปอร์ต',
		);
		// return array(
		// 	'id' => 'ID',
		// 	'username' => 'ชื่อผู้ใช้',
		// 	'password' => 'รหัสผ่าน',
		// 	'repeat_password' => 'ยืนยันรหัสผ่าน',
		// 	'email' => 'อีเมล์',
		// 	'pic_user' => 'Pic User',
		// 	'orgchart_lv2' => 'Orgchart Lv2',
		// 	'department_id' => 'Department',
		// 	'activkey' => 'Activkey',
		// 	'create_at' => 'Create At',
		// 	'lastvisit_at' => 'Lastvisit At',
		// 	'superuser' => 'Superuser',
		// 	'status' => 'เปิด/ปิดการใช้งาน',
		// 	'online_status' => 'Online Status',
		// 	'online_user' => 'Online User',
		// 	'last_ip' => 'Last Ip',
		// 	'last_activity' => 'Last Activity',
		// 	'lastactivity' => 'Lastactivity',
		// 	'avatar' => 'Avatar',
		// 	'company_id' => 'Company',
		// 	'division_id' => 'Division',
		// 	'position_id' => 'Position',
		// 	'bookkeeper_id' => 'Bookkeeper',
		// 	'pic_cardid' => 'Pic Cardid',
		// 	'auditor_id' => 'Auditor',
		// 	'pic_cardid2' => 'Pic Cardid2',
		// 	'group' => 'Group',
		// 	'identification' => 'Identification',
		// 	'update_password' => 'เปลี่ยนรหัสผ่านใหม่',
		// 	'repeat_updatepassword' => 'ยืนยันรหัสผ่าน',
		// 	'id_passport' => 'เลขพาสสปอร์ต (สำหรับต่างชาติเท่านั้น) ',
		// 	'user_active'=>'เปิด/ปิดการใช้งาน'
		// 	);
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
		$criteria->order = 'create_at DESC';
		$criteria->compare('del_status',0);
		$criteria->with = array('profiles','divisions');
		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('pic_user',$this->pic_user,true);
		$criteria->compare('orgchart_lv2',$this->orgchart_lv2,true);
		$criteria->compare('department_id',$this->department_id,true);
		$criteria->compare('activkey',$this->activkey,true);
		$criteria->compare('create_at',$this->create_at,true);
		$criteria->compare('lastvisit_at',$this->lastvisit_at,true);
		// $criteria->compare('superuser',1);
		$criteria->compare('superuser',$this->superuser);
		$criteria->compare('status',$this->status);
		// $criteria->compare('online_status',$this->online_status);
		// $criteria->compare('online_user',$this->online_user);
		// $criteria->compare('last_ip',$this->last_ip,true);
		// $criteria->compare('last_activity',$this->last_activity,true);
		// $criteria->compare('lastactivity',$this->lastactivity);
		// $criteria->compare('avatar',$this->avatar,true);
		// $criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('division_id',$this->division_id,true);
		// $criteria->compare('position_id',$this->position_id,true);
		// $criteria->compare('bookkeeper_id',$this->bookkeeper_id,true);
		// $criteria->compare('pic_cardid',$this->pic_cardid,true);
		// $criteria->compare('auditor_id',$this->auditor_id);
		// $criteria->compare('pic_cardid2',$this->pic_cardid2,true);
		// $criteria->compare('group',$this->group,true);
		// $criteria->compare('identification',$this->identification,true);
		$criteria->compare(
            'CONCAT(profiles.firstname," "
            ,profiles.lastname," ",profiles.firstname," "
            ," ",profiles.identification)',$this->name_search,true);

		$poviderArray = array('criteria' => $criteria);
        // Page
		if (isset($this->news_per_page)) {
			$poviderArray['pagination'] = array('pageSize' => intval($this->news_per_page));
		} else {
			$poviderArray['pagination'] = array('pageSize' => intval(20));
		}

		return new CActiveDataProvider($this, $poviderArray);
	}

	public function searchLearnReset()
	{
		$criteria=new CDbCriteria;
		$criteria->with = 'member';
    	//$criteria->join .= ' INNER JOIN m_member AS member ON member.m_id = t.id ';
		$criteria->compare('CONCAT(member.m_firstname_th , " " , member.m_lastname_th , " ", t.identification, " ", t.username," ",member.m_firstname_en , " " , member.m_lastname_en)',$this->name_search,true);
		$poviderArray = array('criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id ASC',
				));
        // Page
		if(isset($this->news_per_page))
		{
			$poviderArray['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		} else {
			$poviderArray['pagination'] = array('pageSize' => intval(20));
		}

		return new CActiveDataProvider($this, $poviderArray);

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function getDistrictList(){
		$model = MtCourseName::model()->findAll();
		$list = CHtml::listData($model,'cnid','course_name');
		return $list;
	}
}
