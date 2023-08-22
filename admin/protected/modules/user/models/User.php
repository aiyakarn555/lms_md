<?php

class User extends CActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANNED=-1;

	//TODO: Delete for next version (backward compatibility)
	const STATUS_BANED=-1;

	/**
	 * The followings are the available columns in table 'users':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $activkey
	 * @var integer $createtime
	 * @var integer $lastvisit
	 * @var integer $superuser
	 * @var integer $status
     * @var timestamp $create_at
     * @var timestamp $lastvisit_at
     * @var string $group

	 */
	public $position_name;
	public $verifyPassword;
	public $verifyCode;
	public $pic_user;
	// public $orgchart_lv2;
	public $newpassword;
	public $confirmpass;
	public $idensearch;
	public $excel_file = null;
	public $supper_user_status;
	public $typeuser;
	public $type_employee;
	public $dateRang;
	public $user_id;
	public $nameSearch;
	public $month;
	public $fullname;
	public $news_per_page;
	public $passport;
	public $group_bu_id;
	public $bu_id;
	public $department_id;
	public $division_id;
	public $section_id;
	public $sub_section_id;
	public $country_id;
	public $company_id;
	public $department_country_id;
	public $division_country_id;
	public $section_country_id;
	public $team_id;
	public $employee_code;
	public $face_time_last;
	public $search_value;
	public $searchname;


	//public $register_status;

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
		// return '{{users}}';
		return Yii::app()->getModule('user')->tableUsers;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.CConsoleApplication
			


		return ((get_class(Yii::app())=='CConsoleApplication' || (get_class(Yii::app())!='CConsoleApplication' && Yii::app()->getModule('user')->isAdmin()))?array(
			// array('username', 'length', 'max'=>13, 'min' => 13,'message' => 'กรอกเลข E-mail เท่านั้น'),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'unique',
				'criteria' => array(
					'condition' => 'del_status= :del_status',
					'params' => array(':del_status' => 0))
				, 'message' => UserModule::t("E-mail นี้มีในระบบแล้ว")),

			array('username', 'unique',
				'criteria' => array(
					'condition' => 'del_status= :del_status',
					'params' => array(':del_status' => 0))
				, 'message' => UserModule::t("username นี้มีในระบบแล้ว")),
			// array('email', 'email'),
			//array('email', 'email','on' => 'test'),
			// array('auditor_id', 'length', 'max'=>5, 'min' => 5,'message' => 'กรุณาป้อนเลขผู้สอบ 5 หลัก'),
			// array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			//array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			// array('username', 'match', 'pattern' => '/^[0-9_]+$/u','message' => 'กรอกเลขบัตรประชาชน 13 หลักเท่านั้น'),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANNED)),
			array('superuser', 'in', 'range'=>array(0,1,2)),
            array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('lastvisit_at', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
			// array('username, email, superuser, status,password,company_id,division_id,department_id,position_id,position_name', 'required'),
			// array('username, email, superuser, status,password', 'required'),
			// array('superuser, status', 'required'),
			// array('identification', 'required','on' => 'general'),
			array('username, email, password', 'required'),
			
			array('password', 'required', 'on' => 'reset_password'),
			array('superuser, status, online_status,online_user,register_status', 'numerical', 'integerOnly'=>true),
			array('pic_user', 'file', 'types'=>'jpg, png, gif','allowEmpty' => true, 'on'=>'insert'),
			array('pic_user', 'file', 'types'=>'jpg, png, gif','allowEmpty' => true, 'on'=>'update'),
			array('news_per_page', 'safe'),
			array('id, username, active, password, department_id,institution_id, pic_user, email, activkey, create_at, lastvisit_at, superuser, status, online_status,online_user,company_id,position_id,lastactivity,orgchart_lv2, group,idensearch,identification,station_id,supper_user_status,pic_cardid2,employee_id,typeuser,register_status,dateRang,user_id,nameSearch,note,not_passed, avatar, month,type_employee, report_authority, branch_id, fullname, passport', 'safe', 'on'=>'search'),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")),
			array('newpassword', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			//array('confirmpass', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")),
			array('username','checkEmail'),
			array('password','checkPassword'),
		):((Yii::app()->user->id==$this->id)?array(
			// array('username, email,password,verifyPassword,company_id,division_id,department_id,position_id,position_name', 'required'),
			array('username,password', 'required'),
			array('username,note,not_passed', 'length', 'max'=>255),
			array('superuser, status, online_status,online_user,register_status', 'numerical', 'integerOnly'=>true),
			// array('username', 'length', 'max'=>13, 'min' => 13,'message' => 'กรอกเลขบัตรประชาชน 13 หลักเท่านั้น'),
			// array('email', 'email'),
			// array('email', 'email','on' => 'test'),
			array('auditor_id', 'length', 'max'=>5, 'min' => 5,'message' => 'กรุณาป้อนเลขผู้สอบ 5 หลัก'),
			// array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			// array('username', 'match', 'pattern' => '/^[0-9_]+$/u','message' => 'กรอกเลขบัตรประชาชน 13 หลักเท่านั้น'),
			//array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			array('idensearch', 'length', 'max'=>13),
			array('username','checkEmail'),
			array('password','checkPassword'),
			array('excel_file', 'required', 'on'=>'import'),
            array('excel_file', 'file', 'allowEmpty'=>false, 'types'=>'xls', 'on'=>'import'),
		):array()));
	}

	public function checkEmail(){
		if(Yii::app()->controller->action->id == 'update') return true;
		$email = User::model()->find(array(
			'condition' => 'del_status=:del_status AND email=:email',
			'params' => array('del_status'=>'0','email'=>$this->username)));
		!empty($email) ? $this->addError("username",UserModule::t("This user's email address already exists.")) : '';
	}

	public function checkPassword() {
	
		if (strlen($this->password) < 8) {
			 $this->addError("password","Password too short!");
		}
	
		if (!preg_match("#[0-9]+#", $this->password)) {
			$this->addError("password","Password must include at least one number!");
		}
	
		if (!preg_match("#[a-zA-Z]+#", $this->password)) {
			$this->addError("password","Password must include at least one letter!");
		}     

	}

	public static function getOnlineUsers()
	{
		$sql = "SELECT session.user_id, tbl_users.username FROM session LEFT JOIN tbl_users ON tbl_users.id=session.user_id";
		$command = Yii::app()->db->createCommand($sql);

		return $command->queryAll();
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        $relations = Yii::app()->getModule('user')->relations;
        if (!isset($relations['profile']))
			$relations['profile'] = array(self::HAS_ONE, 'Profile', 'user_id');

		$relations['orgchart'] = array(
			self::HAS_ONE,'OrgChart',array('id'=>'orgchart_lv2')
		);

        $relations['typeUsers'] = array(
            self::BELONGS_TO, 'TypeUser', array('id'=>'type_register')
        );

        $relations['branch'] = array(
			self::BELONGS_TO, 'Branch', 'branch_id'
		);

		$relations['department'] = array(
			self::BELONGS_TO, 'Department', array('department_id'=>'id')
		);

		$relations['company'] = array(
			self::BELONGS_TO, 'Company', array('company_id'=>'company_id')
		);

		$relations['station'] = array(
			self::BELONGS_TO, 'Station', array('station_id'=>'station_id')
		);

		$relations['division'] = array(
			self::BELONGS_TO, 'Division', array('division_id'=>'id')
		);

		$relations['position'] = array(
			self::BELONGS_TO, 'Position', array('position_id')
		);

        $relations['orgcourses'] = array(
            self::HAS_MANY,'OrgCourse',array('id'=>'orgchart_id'),'through'=>'orgchart'
        );

				$relations['orders'] = array(
        	self::HAS_MANY, 'Orderonline', 'user_id'
        );

				$relations['orderDetails'] = array(
                self::HAS_MANY,'OrderDetailonline',array('order_id'=>'order_id'),'through'=>'orders'
        );

				$relations['ownerCourseOnline'] = array(
                self::HAS_MANY,'CourseOnline',array('shop_id'=>'course_id'),'through'=>'orderDetails'
        );

        $relations['learns'] = array(self::HAS_MANY, 'Learn', 'user_id');

        $relations['learnFiles'] = array(
            self::HAS_MANY,'LearnFile',array('learn_id'=>'learn_id'),'through'=>'learns'
        );

        $relations['learnVdos'] = array(
            self::HAS_MANY,'File',array('file_id'=>'id'),'through'=>'learnFiles'
        );

        $relations['learnLessons'] = array(
            self::HAS_MANY,'Lesson',array('lesson_id'=>'id'),'through'=>'learns'
        );

        $relations['group'] = array(
            self::HAS_MANY,'PGroup',array('id'=>'group')
        );

        $relations['institution'] = array(
        	self::BELONGS_TO, 'Institution', 'institution_id','foreignKey' => array('institution_id'=>'code')
        );

		$relations['sess'] = array(
            self::HAS_ONE,'Sess','user_id');

        $relations['countLearnCompareTrueVdos'] = array(
            self::STAT,
            'Learn',
            'user_id',
            'select' => 'COUNT(tbl_lesson.id)',
            'join' => 'INNER JOIN tbl_lesson ON tbl_lesson.id = t.lesson_id
                INNER JOIN tbl_file ON tbl_file.lesson_id = tbl_lesson.id
                INNER JOIN tbl_learn_file ON tbl_file.id = tbl_learn_file.file_id
                AND t.learn_id = tbl_learn_file.learn_id',
        );

		$relations['courseScore'] = array(self::HAS_MANY, 'coursescore', 'user_id');
		$relations['score'] = array(self::HAS_MANY, 'score', 'user_id');



        return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => UserModule::t("Id"),
			'username'=>UserModule::t("username"),
			'password'=>UserModule::t("password"),
			'verifyPassword'=>UserModule::t("Retype Password"),
			'email'=>UserModule::t("E-mail"),
			'verifyCode'=>UserModule::t("Verification Code"),
			'activkey' => UserModule::t("activation key"),
			'createtime' => UserModule::t("Registration date"),
			'create_at' => UserModule::t("Registration date"),
			'pic_user' => UserModule::t("Pic User"),
			'orgchart_lv2' => UserModule::t("orgchart_lv2"),
			'lastvisit_at' => UserModule::t("Last visit"),
			'lastactivity' => 'lastactivity',
			'superuser' => UserModule::t("Superuser"),
			'status' => UserModule::t("Status"),
			'station_id' => 'สถานี',
			'company_id' => UserModule::t("ฝ่าย"),
			'division_id' => UserModule::t("กอง"),
			'department_id' => UserModule::t("แผนก"),
			'position_id' => UserModule::t("ตำแหน่ง"),
			'newpassword' => 'รหัสผ่านใหม่',
			'confirmpass' => 'ยืนยันรหัสผ่านใหม่',
			'group' => 'กลุ่มผู้ใช้งาน',
			'idensearch' => 'รหัสบัตรประชาชน',
			'position_name' => UserModule::t("ตำแหน่ง"),
			'identification' => 'รหัสบัตรประชาชน',
			'excel_file' => 'ไฟล์ Excel Import',
			'supper_user_status' => 'สถานะ',
			'pic_cardid2' => 'เลขประจำตัวพนักงาน', //ใช้ฟิลนี้ชั่วคราว
			'employee_id' => 'เลขประจำตัวพนักงาน',
			'typeuser' =>'ประเภทผู้ใช้งาน',
			'type_employee'=> 'ประเภทพนักงาน',
		    'passport'=> 'รหัสหนังสือเดินทาง',
			'register_status' => 'สถานะการสมัครสมาชิก',
			'dateRang' => 'เลือกระยะเวลา',
			'note' => 'หมายเหตุ',
			'not_passed' => 'สาเหตุที่ไม่ผ่าน',
			'month'=>'เดือน',
			'report_authority'=>'สิทธิ์ Report',
			'branch_id'=>'เลเวล',
			'fullname'=>'ชื่อ-นามสกุล',
			'fullnamee'=>'ชื่อ-นามสกุล',
			'employee_code'=>'รหัสพนักงาน',
			'face_time_last' => 'ยืนยันใบหน้าล่าสุด'
		);
	}

	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactive'=>array(
                'condition'=>'status='.self::STATUS_NOACTIVE,
            ),
//            'banned'=>array(
//                'condition'=>'status='.self::STATUS_BANNED,
//            ),
            'superuser'=>array(
                'condition'=>'superuser=1',
            ),
            'notsafe'=>array(
            	'select' => 'id, username, password, department_id, branch_id, pic_user, email, activkey, create_at, superuser, status, online_status,online_user,company_id, division_id,position_id,orgchart_lv2,group,employee_id,institution_id',
            ),
        );
    }

	public function defaultScope()
    {
        return CMap::mergeArray(Yii::app()->getModule('user')->defaultScope,array(
            'alias'=>'user',
            'select' => 'user.id, user.username, user.pic_user,user.station_id, user.department_id, user.branch_id,user.company_id, user.division_id,user.position_id,user.auditor_id,user.bookkeeper_id, user.email, user.create_at, user.lastvisit_at, user.superuser, user.status, user.online_status, user.online_user, user.pic_cardid,lastactivity,group,user.identification,user.pic_cardid2,user.employee_id,user.avatar,user.register_status,user.note,user.not_passed,user.orgchart_lv2,user.institution_id',
        ));
    }

	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => UserModule::t('ระงับการใช้งาน'),
				self::STATUS_ACTIVE => UserModule::t('เปิดการใช้งาน'),
//				self::STATUS_BANNED => UserModule::t('Banned'),
			),
			'AdminStatus' => array(
				'0' => UserModule::t('ผู้ใช้งาน'),
				'1' => UserModule::t('ผู้ดูแลระบบ'),
			),
			'Online' => array(
				'1' => UserModule::t('ออนไลน์'),
				'0' => UserModule::t('ออฟไลน์'),
			)
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}


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
	public static function chk_online($id,$lastactivity,$online_status)
	{	
		if ($id!='' && $online_status == '0') {
			echo "<span style='color: #c6c6c6'>ออฟไลน์</span>";
		} else {
			$id_chk = User::model()->findByPk($id);
			$lasttime = time();
			$time = $lasttime - $lastactivity;
			$chktime = date("i:s",$time);
			if($id!='' && $chktime > '30.00' && $online_status == '1'){
				$id_chk->online_status = '0';
				$id_chk->save(false);
				echo "<span style='color: #c6c6c6'>ออฟไลน์</span>";
			}else{
				echo "<span style='color: #00A000;'>ออนไลน์</span>";
			}
		}
		
	}

	public function getFullnamee(){
		$profile = Profile::model()->findByPk($this->id);
		$text = $profile->firstname_en.' '.$profile->lastname_en;
		if($text == " "){
			$text = "";
		}
		return $text;
	}

/**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria=new CDbCriteria;
        $criteria->with = array('profile','position','department');

        if(isset($_GET['User']['fullname'])){
        	$ex_fullname = explode(" ", $_GET['User']['fullname']);

        	if(isset($ex_fullname[0])){
        		$pro_fname = $ex_fullname[0];
        		$criteria->compare('profile.firstname_en', $pro_fname, true);
        		$criteria->compare('profile.lastname_en', $pro_fname, true, 'OR');
        	}
        	
        	if(isset($ex_fullname[1])){
        		$pro_lname = $ex_fullname[1];
        		$criteria->compare('profile.lastname_en',$pro_lname,true);
        	}
        }

        $criteria->compare('id',$this->id);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password);
        $criteria->compare('pic_user',$this->pic_user);
        $criteria->compare('station_id',$this->station_id);
        $criteria->compare('position_id',$this->position_id);
        $criteria->compare('user.department_id',$this->department_id);
        $criteria->compare('branch_id',$this->branch_id);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('activkey',$this->activkey);
        $criteria->compare('create_at',$this->create_at);
        $criteria->compare('lastvisit_at',$this->lastvisit_at);
        $criteria->compare('lastactivity',$this->lastactivity);
        $criteria->compare('report_authority',$this->report_authority);
        // $criteria->compare('superuser',$this->superuser);
        if(empty($this->supper_user_status)){
        	$criteria->compare('superuser',1);
        }else{
        	$criteria->compare('superuser',0);
        }     
        $criteria->compare('status',$this->status);
        $criteria->compare('del_status',0);
 		$criteria->compare('online_status',$this->online_status);
 		$criteria->compare('online_user',$this->online_user);
 		$criteria->compare('group',$this->group);
 		$criteria->compare('identification',$this->identification);
 		$criteria->compare('pic_cardid2',$this->pic_cardid2);
 		$criteria->compare('register_status',$this->register_status);
 		$criteria->compare('profile.type_employee',$this->type_employee);
 		$criteria->compare('profile.passport',$this->passport);
		$criteria->compare('profile.kind',$_GET['kind']);
 		$criteria->order = 'user.id DESC';
 	   

 		// $criteria->compare('profile.identification',$this->idensearch,true);

      $dataProvider = array('criteria'=>$criteria);
		// Page
		if(isset($this->news_per_page))
		{
			$dataProvider['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
		
		return new CActiveDataProvider($this, $dataProvider);
    }

    public function searchapprove()
{
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
    
	$criteria=new CDbCriteria;

	$criteria->with = array('profile');
	$criteria->with = array('position');
	$criteria->compare('id',$this->id);
	$criteria->compare('username',$this->username,true);
	$criteria->compare('password',$this->password);
	$criteria->compare('pic_user',$this->pic_user);
	$criteria->compare('department_id',$this->department_id);
	$criteria->compare('branch_id',$this->branch_id);
	$criteria->compare('position_id',$this->position_id);
	$criteria->compare('email',$this->email,true);
	$criteria->compare('activkey',$this->activkey);
	$criteria->compare('lastvisit_at',$this->lastvisit_at);
	$criteria->compare('lastactivity',$this->lastactivity);
	$criteria->compare('report_authority',$this->report_authority);
	$criteria->compare('superuser',$this->superuser);
	$criteria->compare('not_passed',$this->not_passed);
	$criteria->compare('status',$this->status);
	$criteria->compare('del_status',0); 
	$criteria->compare('register_status',0);
	$criteria->order = 'user.id DESC';

	//$criteria->compare('register_status',$this->register_status);
	if(empty($this->create_at)) {
		$criteria->compare('create_at',$this->create_at,true);
	}else {
		$start_date = substr($this->create_at,0,11);
		$end_date = substr($this->create_at,13);
	
		$date_start = date('Y-m-d 00:00:00', strtotime($start_date));
		$date_end = date('Y-m-d 23:59:59', strtotime($end_date));
			
		$criteria->addBetweenCondition('create_at', $date_start, $date_end, 'AND');
	}
	
	$criteria->compare('online_status',$this->online_status);
	$criteria->compare('online_user',$this->online_user);
	$criteria->compare('group',$this->group);
	$criteria->compare('profile.identification',$this->idensearch,true);
	$criteria->compare('CONCAT(profile.firstname , " " , profile.lastname , " ", " ", username," ",profile.firstname_en , " " , profile.lastname_en)',$this->fullname,true);
     
	//$org = !empty($this->orgchart_lv2) ? '"'.$this->orgchart_lv2.'"' : '';
	// $criteria->compare('orgchart_lv2',$org,true);
	// $dataProvider = new CActiveDataProvider(get_class($this), array(
	// 	'criteria'=>$criteria,
	// 	'pagination'=>array(
	// 		'pageSize'=>Yii::app()->getModule('user')->user_page_size,
	// 	),
	// ));
	// return $dataProvider;
	 $dataProvider = array('criteria'=>$criteria);
		// Page
		if(isset($this->news_per_page))
		{
			$dataProvider['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
		
		return new CActiveDataProvider($this, $dataProvider);
}
// public function searchmembership()
// {
//   $criteria=new CDbCriteria;
//         $criteria->with = array('profile','position','department');

//         if(isset($_GET['User']['fullname'])){
//         	$ex_fullname = explode(" ", $_GET['User']['fullname']);

//         	if(isset($ex_fullname[0])){
//         		$pro_fname = $ex_fullname[0];
//         		$criteria->compare('profile.firstname_en', $pro_fname, true);
//         		$criteria->compare('profile.lastname_en', $pro_fname, true, 'OR');
//         	}
        	
//         	if(isset($ex_fullname[1])){
//         		$pro_lname = $ex_fullname[1];
//         		$criteria->compare('profile.lastname_en',$pro_lname,true);
//         	}
//         }

//         $criteria->compare('id',$this->id);
//         $criteria->compare('username',$this->username,true);
//         $criteria->compare('password',$this->password);
//         $criteria->compare('pic_user',$this->pic_user);
//         $criteria->compare('station_id',$this->station_id);
//         $criteria->compare('position_id',$this->position_id);
//         $criteria->compare('user.department_id',$this->department_id);
//         $criteria->compare('branch_id',$this->branch_id);
//         $criteria->compare('email',$this->email,true);
//         $criteria->compare('activkey',$this->activkey);
//         $criteria->compare('create_at',$this->create_at);
//         $criteria->compare('lastvisit_at',$this->lastvisit_at);
//         $criteria->compare('lastactivity',$this->lastactivity);
//         $criteria->compare('report_authority',$this->report_authority);
//         // $criteria->compare('superuser',$this->superuser);
//         if(empty($this->supper_user_status)){
//         	$criteria->compare('superuser',1);
//         }else{
//         	$criteria->compare('superuser',0);
//         }     
//         $criteria->compare('status',$this->status);
//         $criteria->compare('del_status',0);
//  		$criteria->compare('online_status',$this->online_status);
//  		$criteria->compare('online_user',$this->online_user);
//  		$criteria->compare('group',$this->group);
//  		$criteria->compare('identification',$this->identification);
//  		$criteria->compare('pic_cardid2',$this->pic_cardid2);
//  		$criteria->compare('register_status',$this->register_status);
//  		$criteria->compare('profile.type_employee',$this->type_employee);
//  		$criteria->compare('profile.passport',$this->passport);
//  		$criteria->order = 'user.id DESC';
 	   

//  		// $criteria->compare('profile.identification',$this->idensearch,true);

//       $dataProvider = array('criteria'=>$criteria);
// 		// Page
// 		if(isset($this->news_per_page))
// 		{
// 			$dataProvider['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
// 		}
		
// 		return new CActiveDataProvider($this, $dataProvider);
//     }

public function searchmembership()
{
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
	$criteria=new CDbCriteria;

	$criteria->with = array('profile');
	$criteria->with = array('position');
	$criteria->compare('id',$this->id);
	$criteria->compare('username',$this->username,true);
	$criteria->compare('password',$this->password);
	$criteria->compare('pic_user',$this->pic_user);
	$criteria->compare('department_id',$this->department_id);
	$criteria->compare('branch_id',$this->branch_id);
	$criteria->compare('position_id',$this->position_id);
	$criteria->compare('email',$this->email,true);
	$criteria->compare('activkey',$this->activkey);
	//$criteria->compare('create_at',$this->create_at);
	$criteria->compare('lastvisit_at',$this->lastvisit_at);
	$criteria->compare('lastactivity',$this->lastactivity);
	$criteria->compare('report_authority',$this->report_authority);
	$criteria->compare('superuser',$this->superuser);
	$criteria->compare('note',$this->note);
	$criteria->compare('status',0);
	$criteria->compare('del_status',0);
	$criteria->compare('online_status',$this->online_status);
	$criteria->compare('online_user',$this->online_user);
	//$criteria->compare('register_status',$this->register_status);		
	if (isset($this->register_status)) {
		if($this->register_status == null){
        $criteria->addIncondition('register_status',array(0,2));
		}else if($this->register_status == 2){
		    $criteria->compare('register_status', 2);
        }else if($this->register_status == 1){
        	$criteria->compare('register_status',0);
        }
        $criteria->addIncondition('register_status',array(0,2));
	}else{
         $criteria->addIncondition('register_status',array(0,2));
	}
	$criteria->compare('group',$this->group);
	$criteria->compare('profile.identification',$this->idensearch,true);
	$criteria->order = 'user.id DESC';
	if(empty($this->create_at)) {
		$criteria->compare('create_at',$this->create_at,true);
	}else {
		$start_date = substr($this->create_at,0,11);
		$end_date = substr($this->create_at,13);
	
		$date_start = date('Y-m-d 00:00:00', strtotime($start_date));
		$date_end = date('Y-m-d 23:59:59', strtotime($end_date));
			
		$criteria->addBetweenCondition('create_at', $date_start, $date_end, 'AND');
	}
	$criteria->compare('CONCAT(profile.firstname , " " , profile.lastname , " ", " ", username," ",profile.firstname_en , " " , profile.lastname_en)',$this->fullname,true);
	//var_dump($_REQUEST);exit();
	//$org = !empty($this->orgchart_lv2) ? '"'.$this->orgchart_lv2.'"' : '';
	//$criteria->compare('orgchart_lv2',$org,true);
	// $dataProvider = new CActiveDataProvider(get_class($this), array(
	// 	'criteria'=>$criteria,
	// 	'pagination'=>array(
	// 		'pageSize'=>Yii::app()->getModule('user')->user_page_size,
	// 	),
	// ));
	// return  $dataProvider;
	  $dataProvider = array('criteria'=>$criteria);
		// Page
		if(isset($this->news_per_page))
		{
			$dataProvider['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
		
		return new CActiveDataProvider($this, $dataProvider);
}

public function searchmembership_personal()
{
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
	$criteria=new CDbCriteria;

	$criteria->with = array('profile');
	$criteria->with = array('position');
	$criteria->compare('id',$this->id);
	$criteria->compare('username',$this->username,true);
	$criteria->compare('password',$this->password);
	$criteria->compare('pic_user',$this->pic_user);
	$criteria->compare('department_id',$this->department_id);
	$criteria->compare('branch_id',$this->branch_id);
	$criteria->compare('position_id',$this->position_id);
	$criteria->compare('email',$this->email,true);
	$criteria->compare('activkey',$this->activkey);
	//$criteria->compare('create_at',$this->create_at);
	$criteria->compare('lastvisit_at',$this->lastvisit_at);
	$criteria->compare('lastactivity',$this->lastactivity);
	$criteria->compare('report_authority',$this->report_authority);
	$criteria->compare('superuser',$this->superuser);
	$criteria->compare('note',$this->note);
	$criteria->compare('status',0);
	$criteria->compare('del_status',0);
	$criteria->compare('online_status',$this->online_status);
	$criteria->compare('online_user',$this->online_user);
	//$criteria->compare('register_status',$this->register_status);		
	if (isset($this->register_status)) {
		if($this->register_status == null){
        $criteria->addIncondition('register_status',array(0,2));
		}else if($this->register_status == 2){
		    $criteria->compare('register_status', 2);
        }else if($this->register_status == 1){
        	$criteria->compare('register_status',0);
        }
        $criteria->addIncondition('register_status',array(0,2));
	}else{
         $criteria->addIncondition('register_status',array(0,2));
	}
	$criteria->compare('group',$this->group);
	$criteria->compare('profile.identification',$this->idensearch,true);
	$criteria->order = 'user.id DESC';
	if(empty($this->create_at)) {
		$criteria->compare('create_at',$this->create_at,true);
	}else {
		$start_date = substr($this->create_at,0,11);
		$end_date = substr($this->create_at,13);
	
		$date_start = date('Y-m-d 00:00:00', strtotime($start_date));
		$date_end = date('Y-m-d 23:59:59', strtotime($end_date));
			
		$criteria->addBetweenCondition('create_at', $date_start, $date_end, 'AND');
	}
	$criteria->compare('CONCAT(profile.firstname , " " , profile.lastname , " ", " ", username," ",profile.firstname_en , " " , profile.lastname_en)',$this->fullname,true);
	//var_dump($_REQUEST);exit();
	//$org = !empty($this->orgchart_lv2) ? '"'.$this->orgchart_lv2.'"' : '';
	//$criteria->compare('orgchart_lv2',$org,true);
	$dataProvider = new CActiveDataProvider(get_class($this), array(
		'criteria'=>$criteria,
		'pagination'=>array(
			'pageSize'=>Yii::app()->getModule('user')->user_page_size,
		),
	));
	return  $dataProvider;
}

 public function searchaccess()
{
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
    
	$criteria=new CDbCriteria;

	$criteria->with = array('profile');
	$criteria->with = array('position');
	$criteria->compare('id',$this->id);
	$criteria->compare('username',$this->username,true);
	$criteria->compare('password',$this->password);
	$criteria->compare('pic_user',$this->pic_user);
	$criteria->compare('department_id',$this->department_id);
	$criteria->compare('branch_id',$this->branch_id);
	$criteria->compare('position_id',$this->position_id);
	$criteria->compare('email',$this->email,true);
	$criteria->compare('activkey',$this->activkey);
	$criteria->compare('create_at',$this->create_at,true);
	$criteria->compare('lastvisit_at',$this->lastvisit_at);
	$criteria->compare('lastactivity',$this->lastactivity);
	$criteria->compare('report_authority',$this->report_authority);
	$criteria->compare('superuser',$this->superuser);
	$criteria->compare('not_passed',$this->not_passed);
	$criteria->compare('status',$this->status);
	$criteria->compare('del_status',1); 
	$criteria->compare('register_status',$this->register_status);
	$criteria->order = 'lastvisit_at ASC';
	// if(empty($this->create_at)) {
	// 	$criteria->compare('create_at',$this->create_at,true);
	// }else {
	// 	$start_date = substr($this->create_at,0,11);
	// 	$end_date = substr($this->create_at,13);
	
	// 	$date_start = date('Y-m-d 00:00:00', strtotime($start_date));
	// 	$date_end = date('Y-m-d 23:59:59', strtotime($end_date));
			
	// 	$criteria->addBetweenCondition('create_at', $date_start, $date_end, 'AND');
	// }
	
	$criteria->compare('online_status',$this->online_status);
	$criteria->compare('online_user',$this->online_user);
	$criteria->compare('group',$this->group);
	$criteria->compare('profile.identification',$this->idensearch,true);
	// $date_s = date('Y-m-d h:i:s', strtotime('-90 month'));
	// //$date_e = date('Y-m-d h:i:s', strtotime('-'.$this->month.' month'));
	// $date_e = date('Y-m-d h:i:s', strtotime('-1 day'));
	// $criteria->addBetweenCondition('lastvisit_at', $date_s, $date_e, 'AND');

	// return new CActiveDataProvider(get_class($this), array(
	// 	'criteria'=>$criteria,
	// 	'pagination'=>array(
	// 		'pageSize'=>Yii::app()->getModule('user')->user_page_size,
	// 	),
	// ));
		  $dataProvider = array('criteria'=>$criteria);
		// Page
		if(isset($this->news_per_page))
		{
			$dataProvider['pagination'] = array( 'pageSize'=> intval($this->news_per_page) );
		}
		
		return new CActiveDataProvider($this, $dataProvider);
}
public function searchaccessPersonal()
{
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
    
	$criteria=new CDbCriteria;

	$criteria->with = array('profile');
	$criteria->with = array('position');
	$criteria->compare('id',$this->id);
	$criteria->compare('username',$this->username,true);
	$criteria->compare('password',$this->password);
	$criteria->compare('pic_user',$this->pic_user);
	$criteria->compare('department_id',$this->department_id);
	$criteria->compare('branch_id',$this->branch_id);
	$criteria->compare('position_id',$this->position_id);
	$criteria->compare('create_at',$this->create_at,true);
	$criteria->compare('email',$this->email,true);
	$criteria->compare('activkey',$this->activkey);
	$criteria->compare('lastvisit_at',$this->lastvisit_at);
	$criteria->compare('lastactivity',$this->lastactivity);
	$criteria->compare('report_authority',$this->report_authority);
	$criteria->compare('superuser',$this->superuser);
	$criteria->compare('not_passed',$this->not_passed);
	$criteria->compare('status',$this->status);
	$criteria->compare('del_status',1); 
	$criteria->compare('register_status',$this->register_status);
	$criteria->order = 'lastvisit_at ASC';
	// if(empty($this->create_at)) {
	// 	$criteria->compare('create_at',$this->create_at,true);
	// }else {
	// 	$start_date = substr($this->create_at,0,11);
	// 	$end_date = substr($this->create_at,13);
	
	// 	$date_start = date('Y-m-d 00:00:00', strtotime($start_date));
	// 	$date_end = date('Y-m-d 23:59:59', strtotime($end_date));
			
	// 	$criteria->addBetweenCondition('create_at', $date_start, $date_end, 'AND');
	// }
	
	$criteria->compare('online_status',$this->online_status);
	$criteria->compare('online_user',$this->online_user);
	$criteria->compare('group',$this->group);
	$criteria->compare('profile.identification',$this->idensearch,true);
	// $date_s = date('Y-m-d h:i:s', strtotime('-90 month'));
	// //$date_e = date('Y-m-d h:i:s', strtotime('-'.$this->month.' month'));
	// $date_e = date('Y-m-d h:i:s', strtotime('-1 day'));
	// $criteria->addBetweenCondition('lastvisit_at', $date_s, $date_e, 'AND');
	return new CActiveDataProvider(get_class($this), array(
		'criteria'=>$criteria,
		'pagination'=>array(
			'pageSize'=>Yii::app()->getModule('user')->user_page_size,
		),
	));
}

// public function searchmember()
//     {
//         $sql = " SELECT * FROM tbl_users ";
//         $sql .= ' left join tbl_profiles on tbl_profiles.user_id = tbl_users.id';
//         $sql .= ' left join tbl_position on tbl_position.id = tbl_users.position_id';
//         $sql .= " where tbl_users.status = '0' and tbl_users.del_status ='0'";

//         if($this->user_id != null) {
//             $sql .= ' and tbl_users.id = "' . $this->user_id . '"';
//         }
//         // if($this->nameSearch != null) {
//         //     $sql .= ' and (tbl_profiles.firstname like "%' . $this->nameSearch . '%" or tbl_profiles.lastname = "%' . $this->nameSearch . '%")';
//         // }
//         // if($this->dateRang != null) {
//         //     $sql .= ' and (tbl_users.create_at like "%' . $this->dateRang . '%" or tbl_users.create_at = "%' . $this->dateRang . '%")';
//         // }
//         // if($this->register_status != null) {
//         //     $sql .= ' and tbl_users.register_status = "' . $this->register_status . '"';
//         // }
//         // if($this->typeuser != null) {
//         // }
    
//         $sql .= ' group by tbl_users.id';

//         $rawData = Yii::app()->db->createCommand($sql)->queryAll();
//         return new CArrayDataProvider($rawData, $poviderArray);
//     }

    public function getCreatetime() {
        return strtotime($this->create_at);
    }

    public function setCreatetime($value) {
        $this->create_at=date('Y-m-d H:i:s',$value);
    }

    public function getLastvisit() {
        return strtotime($this->lastvisit_at);
    }

    public function setLastvisit($value) {
        $this->lastvisit_at=date('Y-m-d H:i:s',$value);
    }



      public function getregisstatusList()
    {
        $getregisstatusList = array(
            '1'=>'รอการตรวจสอบ',
            '2'=>'ไม่อนุมัติ'
        );
        return $getregisstatusList;
    }
     public function getapproveList()
    {
        $getregisstatusList = array(
            '1'=>'รออนุมัติ ',
            '0'=>'ไม่ผ่านอนุมัติ '
        );
        return $getregisstatusList;
    }


	public function searchReset(){

		$criteria = new CDbCriteria;
        $criteria->with = array('courseScore','score');
		$criteria->addCondition("courseScore.active = 'y' OR score.active = 'y'");
        $criteria->group = 'courseScore.user_id , score.user_id';
        $userAll = User::model()->findAll($criteria);
        $arrScore = array();
        $arrCourseScore = array();
        foreach($userAll as $value){

            foreach($value->courseScore as $cs){
                $arrCourseScore[] = $cs->user_id;
            }

            foreach($value->score as $s){
                $arrScore[] = $s->user_id;
            }
        }
        $arrUser =  array_unique( array_merge($arrCourseScore, $arrScore) );

        $criteria = new CDbCriteria;
        $criteria->with = array('profile');
        $criteria->addInCondition('id', $arrUser);    
		$criteria->addCondition('user.del_status = "0"');
		$criteria->compare('CONCAT(user.username)',$this->search_value,true);
		$criteria->compare('concat(profile.firstname_en," ",profile.lastname_en)',$this->searchname,true);
		$poviderArray = array('criteria' => $criteria);
		// Page
		if (isset($this->news_per_page)) {
			$poviderArray['pagination'] = array('pageSize' => intval($this->news_per_page));
		} else {
			$poviderArray['pagination'] = array('pageSize' => intval(20));
		}
		return new CActiveDataProvider($this, $poviderArray);
	}
}
