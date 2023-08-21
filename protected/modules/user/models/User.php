<?php

class User extends CActiveRecord
{
	const STATUS_NOACTIVE = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_BANNED = -1;

	//TODO: Delete for next version (backward compatibility)
	const STATUS_BANED = -1;

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
	 */
	public $position_name;
	public $verifyPassword;
	public $verifyCode;
	public $pic_user;
	public $newpassword;
	public $confirmpass;
	public $captcha;
	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->getModule('user')->tableUsers;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.CConsoleApplication

		return ((get_class(Yii::app()) == 'CConsoleApplication' || (get_class(Yii::app()) != 'CConsoleApplication' && Yii::app()->getModule('user')->isAdmin())) ? array(
			// array('username', 'length', 'max'=>13, 'min' => 13,'message' => 'กรอกเลข E-mail เท่านั้น'),
			array('password', 'length', 'max' => 128, 'min' => 4, 'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
			array('auditor_id', 'length', 'max' => 5, 'min' => 5, 'message' => 'กรุณาป้อนเลขผู้สอบ 5 หลัก'),
			array(
				'email', 'unique',
				'criteria' => array(
					'condition' => 'del_status= :del_status',
					'params' => array(':del_status' => 0)
				), 'message' => UserModule::t("This user's email address already exists.")
			),
			// array('username', 'match', 'pattern' => '/^[0-9_]+$/u','message' => 'กรอกเลขบัตรประชาชน 13 หลักเท่านั้น'),
			array('status', 'in', 'range' => array(self::STATUS_NOACTIVE, self::STATUS_ACTIVE, self::STATUS_BANNED)),
			array('superuser', 'in', 'range' => array(0, 1)),
			array('register_status', 'in', 'range' => array(0, 1)),
			array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
			array('lastvisit_at', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
			//array('username, email, superuser, status,password', 'required'),
			// array('username, email, status,password,company_id,division_id,department_id,position_id,position_name', 'required'),
			// array('username, email, status,password,identification', 'required'), //Jae Fix
			array('username, status,password,identification', 'required'),
			// array('username, email', 'unique'),
			array('superuser, status, online_status,online_user,register_status', 'numerical', 'integerOnly' => true),
			array('pic_user', 'file', 'types' => 'jpg, png, gif, jpeg', 'allowEmpty' => true, 'on' => 'insert'),
			array('pic_user', 'file', 'types' => 'jpg, png, gif, jpeg', 'allowEmpty' => true, 'on' => 'update'),
			array('id, username, active, password, department_id, pic_user, email, activkey, create_at, lastvisit_at, superuser, status, online_status,online_user,station_id,company_id, division_id,position_id,lastactivity,orgchart_lv2,del_status,avatar,pic_cardid2,employee_id,branch_id,register_status, report_authority', 'safe', 'on' => 'search'),

			array('newpassword', 'length', 'max' => 128, 'min' => 6, 'message' => UserModule::t("Incorrect password (minimal length 6 symbols).")),

		) : ((Yii::app()->user->id == null) ? array(
			array('verifyPassword', 'compare', 'compareAttribute' => 'password', 'message' => UserModule::t("Retype Password is incorrect.")),

			array('password', 'length', 'max' => 128, 'min' => 6, 'message' => "รหัสผ่านควรมีอย่างน้อย 6 หลัก"),

			// array('username,email,password,verifyPassword', 'required', 'message' => UserModule::t("{attribute} ไม่ควรเป็นค่าว่าง")),
			array('username,password,verifyPassword', 'required', 'message' => UserModule::t("{attribute} ไม่ควรเป็นค่าว่าง")),

			array('username', 'length', 'max' => 255),
			array('superuser, status, online_status,online_user,register_status', 'numerical', 'integerOnly' => true),

			// array('email', 'email', 'message' => "รูปแบบอีเมลไม่ถูกต้อง"),

			array(
				'email', 'unique',
				'criteria' => array(
					'condition' => 'del_status= :del_status',
					'params' => array(':del_status' => 0)
				), 'message' => "อีเมลนี้ มีในระบบอยู่แล้ว"
			),
			array(
				'username', 'unique',
				'criteria' => array(
					'condition' => 'del_status= :del_status',
					'params' => array(':del_status' => 0)
				), 'message' => "ชื่อบัญชีผู้ใช้งานนี้ มีในระบบอยู่แล้ว"
			),

		) : ((Yii::app()->user->id == $this->id) ? array(
			array('verifyPassword', 'compare', 'compareAttribute' => 'password', 'message' => UserModule::t("Retype Password is incorrect.")),

			array('password', 'length', 'max' => 128, 'min' => 6, 'message' => "รหัสผ่านควรมีอย่างน้อย 6 หลัก"),

			// array('username,email,password,verifyPassword', 'required', 'message' => UserModule::t("{attribute} ไม่ควรเป็นค่าว่าง")),
			array('username,password,verifyPassword', 'required', 'message' => UserModule::t("{attribute} ไม่ควรเป็นค่าว่าง")),

			array('username', 'length', 'max' => 255),
			array('superuser, status, online_status,online_user,register_status', 'numerical', 'integerOnly' => true),

			// array('email', 'email', 'message' => "รูปแบบอีเมลไม่ถูกต้อง"),

			array(
				'email', 'unique',
				'criteria' => array(
					'condition' => 'del_status= :del_status ',
					'params' => array(':del_status' => 0)
				), 'message' => "อีเมลนี้ มีในระบบอยู่แล้ว"
			),
			array(
				'username', 'unique',
				'criteria' => array(
					'condition' => 'del_status= :del_status',
					'params' => array(':del_status' => 0)
				), 'message' => "ชื่อบัญชีผู้ใช้งานนี้ มีในระบบอยู่แล้ว"
			),

		) : array())));
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

		$relations['profileEdu'] = array(self::HAS_ONE, 'profileEdu', 'user_id');

		$relations['orgchart'] = array(
			self::BELONGS_TO, 'Orgchart', array('id' => 'department_id')
		);

		$relations['station'] = array(
			self::BELONGS_TO, 'Station', array('station_id' => 'station_id')
		);


		$relations['company'] = array(
			self::BELONGS_TO, 'Company', array('company_id' => 'company_id')
		);

		$relations['branch'] = array(
			self::BELONGS_TO, 'Branch', 'branch_id'
		);

		$relations['position'] = array(
			self::BELONGS_TO, 'Position', 'position_id'
		);

		$relations['department'] = array(
			self::BELONGS_TO, 'Department', 'department_id'
		);

		$relations['orgcourses'] = array(
			self::HAS_MANY, 'OrgCourse', array('id' => 'orgchart_id'), 'through' => 'orgchart'
		);

		$relations['orders'] = array(
			self::HAS_MANY, 'Orderonline', 'user_id'
		);

		$relations['orderDetails'] = array(
			self::HAS_MANY, 'OrderDetailonline', array('order_id' => 'order_id'), 'through' => 'orders'
		);

		$relations['ownerCourseOnline'] = array(
			self::HAS_MANY, 'CourseOnline', array('shop_id' => 'course_id'), 'through' => 'orderDetails'
		);

		$relations['learns'] = array(self::HAS_MANY, 'Learn', 'user_id');

		$relations['learnFiles'] = array(
			self::HAS_MANY, 'LearnFile', array('learn_id' => 'learn_id'), 'through' => 'learns'
		);

		$relations['learnVdos'] = array(
			self::HAS_MANY, 'File', array('file_id' => 'id'), 'through' => 'learnFiles'
		);

		$relations['learnLessons'] = array(
			self::HAS_MANY, 'Lesson', array('lesson_id' => 'id'), 'through' => 'learns'
		);

		$relations['sess'] = array(
			self::HAS_ONE, 'Sess', 'user_id'
		);

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

		$relations['countLearnCompareTrueScorm'] = array(
			self::STAT,
			'Learn',
			'user_id',
			'select' => 'COUNT(tbl_lesson.id)',
			'join' => 'INNER JOIN tbl_lesson ON tbl_lesson.id = t.lesson_id
                INNER JOIN tbl_file_scorm ON tbl_file_scorm.lesson_id = tbl_lesson.id
                INNER JOIN tbl_learn_file ON tbl_file_scorm.id = tbl_learn_file.file_id
                AND t.learn_id = tbl_learn_file.learn_id',
		);

		$relations['countLearnCompareTrueEbook'] = array(
			self::STAT,
			'Learn',
			'user_id',
			'select' => 'COUNT(tbl_lesson.id)',
			'join' => 'INNER JOIN tbl_lesson ON tbl_lesson.id = t.lesson_id
                INNER JOIN tbl_file_ebook ON tbl_file_ebook.lesson_id = tbl_lesson.id
                INNER JOIN tbl_learn_file ON tbl_file_ebook.id = tbl_learn_file.file_id
                AND t.learn_id = tbl_learn_file.learn_id',
		);


		$relations['countLearnCompareTruePdf'] = array(
			self::STAT,
			'Learn',
			'user_id',
			'select' => 'COUNT(tbl_lesson.id)',
			'join' => 'INNER JOIN tbl_lesson ON tbl_lesson.id = t.lesson_id
                INNER JOIN tbl_file_pdf ON tbl_file_pdf.lesson_id = tbl_lesson.id
                INNER JOIN tbl_learn_file ON tbl_file_pdf.id = tbl_learn_file.file_id
                AND t.learn_id = tbl_learn_file.learn_id',
		);

		$relations['countLearnCompareTrueAudio'] = array(
			self::STAT,
			'Learn',
			'user_id',
			'select' => 'COUNT(tbl_lesson.id)',
			'join' => 'INNER JOIN tbl_lesson ON tbl_lesson.id = t.lesson_id
                INNER JOIN tbl_file_audio ON tbl_file_audio.lesson_id = tbl_lesson.id
                INNER JOIN tbl_learn_file ON tbl_file_audio.id = tbl_learn_file.file_id
                AND t.learn_id = tbl_learn_file.learn_id',
		);

		return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => UserModule::t("Id"),
			'username' => UserModule::t("username"),
			'password' => UserModule::t("password"),
			'verifyPassword' => UserModule::t("Retype Password"),
			'email' => UserModule::t("E-mail"),
			'verifyCode' => UserModule::t("Verification Code"),
			'activkey' => UserModule::t("activation key"),
			'createtime' => UserModule::t("Registration date"),
			'create_at' => UserModule::t("Registration date"),
			'pic_user' => UserModule::t("Pic User"),
			'orgchart_lv2' => UserModule::t("orgchart_lv2"),
			'lastvisit_at' => UserModule::t("Last visit"),
			'lastactivity' => 'lastactivity',
			'superuser' => UserModule::t("Superuser"),
			'status' => UserModule::t("Status"),
			'station_id' => UserModule::t("สถานี"),
			'company_id' => UserModule::t("ฝ่าย"),
			'division_id' => UserModule::t("กอง"),
			'department_id' => UserModule::t("แผนก"),
			'position_id' => UserModule::t("ตำแหน่ง"),
			'newpassword' => 'รหัสผ่านใหม่',
			'confirmpass' => 'ยืนยันรหัสผ่านใหม่',
			'position_name' => UserModule::t("ตำแหน่ง"),
			'captcha' => 'Captcha',
			'employee_id' => 'เลขประจำตัวพนักงาน',
			'repass_status' => 'สถานะการเปลี่ยนรหัสผ่าน',
			'branch_id' => UserModule::t("สาขา"),
			'register_status' => 'สถานะการสมัคร',
			'report_authority' => 'สิทธิ์ Report',
			'face_time_last' => 'ยืนยันใบหน้าล่าสุด',
			// 'passport' => UserModule::t("passport"),
		);
	}

	public function scopes()
	{
		return array(
			'active' => array(
				'condition' => 'status=' . self::STATUS_ACTIVE,
			),
			'notactive' => array(
				'condition' => 'status=' . self::STATUS_NOACTIVE,
			),
			//            'banned'=>array(
			//                'condition'=>'status='.self::STATUS_BANNED,
			//            ),
			'superuser' => array(
				'condition' => 'superuser=1',
			),
			'notsafe' => array(
				'select' => 'id, username, password, department_id, pic_user, email, activkey, create_at, superuser, status, report_authority, online_status,online_user,station_id,company_id, division_id,position_id,orgchart_lv2,pic_cardid2,employee_id,repass_status,branch_id, register_status, face_time_last',
			),
		);
	}

	public function defaultScope()
	{
		// return CMap::mergeArray(Yii::app()->getModule('user')->defaultScope,array(
		//     'alias'=>'user',
		//     'select' => 'user.id, user.username, user.pic_user, user.department_id,user.station_id,user.company_id, user.division_id,user.position_id,user.auditor_id,user.bookkeeper_id, user.email, user.create_at, user.lastvisit_at, user.superuser, user.status, user.online_status, user.online_user, user.pic_cardid,lastactivity,user.passport',
		// ));

		return CMap::mergeArray(Yii::app()->getModule('user')->defaultScope, array(
			'alias' => 'user',
			'select' => 'user.id, user.username, user.pic_user, user.department_id,user.station_id,user.company_id, user.division_id,user.position_id, user.branch_id,user.auditor_id,user.bookkeeper_id, user.email, user.create_at, user.lastvisit_at, user.superuser, user.status, user.online_status, user.online_user, user.pic_cardid,lastactivity,user.avatar,user.employee_id,user.repass_status, register_status, report_authority',
		));
	}

	public static function itemAlias($type, $code = NULL)
	{
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

	public static function chk_online($id, $lastactivity, $online_status)
	{
		if ($id != '' && $online_status == '0') {
			echo "<span style='color: #c6c6c6'>ออฟไลน์</span>";
		} else {
			$id_chk = User::model()->findByPk($id);
			$lasttime = time();
			$time = $lasttime - $lastactivity;
			$chktime = date("i:s", $time);
			if ($id != '' && $chktime > '30.00' && $online_status == '1') {
				$id_chk->online_status = '0';
				$id_chk->save(false);
				echo "<span style='color: #c6c6c6'>ออฟไลน์</span>";
			} else {
				echo "<span style='color: #00A000;'>ออนไลน์</span>";
			}
		}
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('password', $this->password);
		$criteria->compare('pic_user', $this->pic_user);
		$criteria->compare('department_id', $this->department_id);
		$criteria->compare('branch_id', $this->branch_id);
		$criteria->compare('report_authority', $this->report_authority);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('activkey', $this->activkey);
		$criteria->compare('create_at', $this->create_at);
		$criteria->compare('lastvisit_at', $this->lastvisit_at);
		$criteria->compare('lastactivity', $this->lastactivity);
		$criteria->compare('superuser', $this->superuser);
		$criteria->compare('status', $this->status);
		$criteria->compare('online_status', $this->online_status);
		$criteria->compare('online_user', $this->online_user);
		$criteria->compare('register_status', $this->register_status);
		$criteria->compare('face_time_last', $this->face_time_last);
		// $criteria->compare('passport',$this->passport);

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => Yii::app()->getModule('user')->user_page_size,
			),
		));
	}

	public function getCreatetime()
	{
		return strtotime($this->create_at);
	}

	public function setCreatetime($value)
	{
		$this->create_at = date('Y-m-d H:i:s', $value);
	}

	public function getLastvisit()
	{
		return strtotime($this->lastvisit_at);
	}

	public function setLastvisit($value)
	{
		$this->lastvisit_at = date('Y-m-d H:i:s', $value);
	}
}
