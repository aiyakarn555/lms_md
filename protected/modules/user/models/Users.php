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
 * @property integer $department_id
 * @property string $activkey
 * @property string $create_at
 * @property string $lastvisit_at
 * @property integer $superuser
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Profiles $profiles
 */
class Users extends CActiveRecord {
    const STATUS_NOACTIVE=0;
    const STATUS_ACTIVE=1;
    const STATUS_BANNED=-1;

    //TODO: Delete for next version (backward compatibility)
    const STATUS_BANED=-1;
    public $verifyPassword;
    public $pic_user;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{users}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('password , email', 'required'),
            array('department_id, superuser, status', 'numerical', 'integerOnly' => true),
            // array('username', 'length', 'max' => 20),
            array('email','email'),
            array('password, email, activkey', 'length', 'max' => 128),
            array('pic_user', 'length', 'max' => 255),
            array('lastvisit_at ,last_activity, employee_id','safe'),
            array('pic_user', 'file', 'types'=>'jpg, png, gif','allowEmpty' => true, 'on'=>'insert'),
            array('verifyPassword', 'compare', 'compareAttribute' => 'password', 'message' => UserModule::t("Retype Password is incorrect.")),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, password, email, pic_user, department_id, activkey, create_at, lastvisit_at, last_activity,lastactivity, superuser, status, employee_id', 'safe', 'on' => 'search'),
        );
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
            self::BELONGS_TO, 'Orgchart', array('id'=>'department_id')
        );
        $relations['department'] = array(
            self::BELONGS_TO, 'Department', array('department_id'=>'id')
        );

        $relations['company'] = array(
            self::BELONGS_TO, 'Company', array('company_id'=>'company_id')
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



        return $relations;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
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
            'last_activity' => 'last_activity',
            'lastactivity' => 'lastactivity',
            'superuser' => 'Superuser',
            'status' => 'Status',
            'employee_id' => 'เลขประจำตัวพนักงาน',
			'face_time_last' => 'ยืนยันใบหน้าล่าสุด',
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
                'select' => 'id, username, password, department_id, pic_user, email, activkey, create_at, superuser, status, online_status,online_user,company_id, division_id,position_id,employee_id,type_register,face_regis,face_time_last',
            ),
        );
    }
    public function defaultScope()
    {
        return CMap::mergeArray(Yii::app()->getModule('user')->defaultScope,array(
            'alias'=>'user',
            'select' => 'user.id, user.username, user.pic_user, user.department_id,user.company_id, user.division_id,user.position_id,user.auditor_id,user.bookkeeper_id, user.email, user.create_at, user.lastvisit_at, user.superuser, user.status, user.online_status, user.online_user, user.pic_cardid,user.orgchart_lv2,user.employee_id,user.type_register,user.face_regis,user.face_time_last',
        ));
    }

    public static function itemAlias($type,$code=NULL) {
        $_items = array(
            'UserStatus' => array(
                self::STATUS_NOACTIVE => UserModule::t('ระงับการใช้งาน'),
                self::STATUS_ACTIVE => UserModule::t('เปิดการใช้งาน'),
//              self::STATUS_BANNED => UserModule::t('Banned'),
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
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('pic_user', $this->pic_user, true);
        $criteria->compare('department_id', $this->department_id);
        $criteria->compare('activkey', $this->activkey, true);
        $criteria->compare('create_at', $this->create_at, true);
        $criteria->compare('lastvisit_at', $this->lastvisit_at, true);
        $criteria->compare('superuser', $this->superuser);
        $criteria->compare('status', $this->status);
        $criteria->compare('last_activity', $this->last_activity, true);
        $criteria->compare('lastactivity', $this->lastactivity, true);
        $criteria->compare('face_time_last', $this->face_time_last, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
