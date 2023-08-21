<?php


class UserNew extends CActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	
	public $typeuser;
	public $type_employee;
	public $supper_user_status;
	public $idensearch;

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
		// will receive user inputs.
		return array(
			// The following rule is used by search().
			array('id', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>255),
			array('create_date', 'safe'),
			// Please remove those attributes that should not be searched.
			array('id, username, password, email, group,online_status , avatar, department_id,position_id,branch_id,report_authority,authority_hr,superuser,status,type_register,repass_status,register_status,online_user,del_status,pic_user,identification,activkey,lastactivity,last_ip,lastvisit_at,last_activit,create_at,org_user_status,station_id,company_id,division_id,employee_id,bookkeeper_id,pic_cardid,orgchart_lv2,auditor_id,pic_cardid2,verifyPassword,note,not_passed,org_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	// public function relations()
	// {
	// 	// NOTE: you may need to adjust the relation name and the related
	// 	// class name for the relations automatically generated below.
	// 	return array(
	// 		'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
	// 		'Province' => array(self::HAS_ONE, 'Province', array('pv_id'=>'province')),
	// 		'Generation' => array(self::HAS_ONE, 'Generation', array('id_gen'=>'generation')),
	// 		'ProfilesTitle'=>array(self::BELONGS_TO, 'ProfilesTitle', 'title_id'),
	// 		'Type' => array(self::HAS_ONE, 'TypeUser', array('id' => 'type_user')),
	// 	);
	// }

	/**
	 * @return array customized attribute labels (name=>label)
	 */

	public function relations()
	{	
        $relations = Yii::app()->getModule('user')->relations;
        if (!isset($relations['profile']))
            $relations['profile'] = array(self::HAS_ONE, 'Profile', 'user_id');

        $relations['typeUsers'] = array(
            self::BELONGS_TO, 'TypeUser', array('id'=>'type_register')
        );

        $relations['orgchart'] = array(
            self::BELONGS_TO, 'OrgChart', array('id'=>'department_id')
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
        $relations['EmpClass'] = array(self::HAS_MANY, 'EmpClass', 'employee_id');


        return $relations;
	}

	public function attributeLabels()
	{
		return array(
			'id' => UserModule::t("Id"),
			'username'=>UserModule::t("username"),
			'password'=>UserModule::t("password"),
			'verifyPassword'=>UserModule::t("Retype Password"),
			// 'email'=>UserModule::t("E-mail"),
			'email'=>'อีเมล',
			'verifyCode'=>UserModule::t("Verification Code"),
			'activkey' => UserModule::t("activation key"),
			'createtime' => UserModule::t("Registration date"),
			'create_at' => 'วันที่สร้าง',
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
			'employee_id' => 'รหัสพนักงาน',
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
			'emp_id'=>'รหัสพนักงาน',
			'org_id'=>'Org. Chat ID'
		);
	}
	public function beforeSave() 
    {

		if(null !== Yii::app()->user && isset(Yii::app()->user->id))
		{
			$id = Yii::app()->user->id;
		}
		else
		{
			$id = 1;
		}

		if($this->isNewRecord)
		{
			// $this->create_by = $id;
			$this->create_at = date("Y-m-d H:i:s");
		}
		

        return parent::beforeSave();
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
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function loadModel($id)
	{
		$model=UserNew::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
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
        // $criteria->compare('station_id',$this->station_id);
        // $criteria->compare('position_id',$this->position_id);
        // $criteria->compare('user.department_id',$this->department_id);
        // $criteria->compare('branch_id',$this->branch_id);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('activkey',$this->activkey);
        $criteria->compare('create_at',$this->create_at);
        $criteria->compare('lastvisit_at',$this->lastvisit_at);
        $criteria->compare('lastactivity',$this->lastactivity);
      
        
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

}