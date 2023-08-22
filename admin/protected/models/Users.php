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
class Users extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
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
			// array('username, password, email, department_id, create_at', 'required'),//old
			array('username, password, email, create_at', 'required'),//new
			array('department_id, branch_id, position_id, superuser, status', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>20),
			array('password, email, activkey', 'length', 'max'=>128),
			array('pic_user, group', 'length', 'max'=>255),
			array('lastvisit_at,employee_id', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, email, pic_user, department_id, position_id, branch_id, activkey, create_at, lastvisit_at, superuser, status, org_user_status, group', 'safe', 'on'=>'search'),
			array('password', 'compare', 'compareAttribute'=>'verifyPassword'),
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
			'profiles' => array(self::HAS_ONE, 'Profiles', 'user_id'),
			// 'orgchart' => array(self::BELONGS_TO, 'OrgChart', 'user_id'),
			'orgchart' => array(self::BELONGS_TO, 'OrgChart', 'department_id','foreignKey' => array('department_id'=>'id')),
			'divisions' => array(self::HAS_ONE, 'Division', array('id' => 'department_id')),
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'chk_usercourse' => array(self::HAS_ONE, 'ChkUsercourse', 'user_id'),

			'department' => array(self::BELONGS_TO, 'Department', 'department_id'),
			'position' => array(self::BELONGS_TO, 'Position', 'position_id'),
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
			
			// 'orgchartDivision' => array(self::BELONGS_TO, 'OrgChart', array('division_id' => 'id')),
			// 'orgchartCompany' => array(self::BELONGS_TO, 'OrgChart', array('company_id' => 'id')),
			'orgchartDepartment' => array(self::BELONGS_TO, 'OrgChart', array('department_id' => 'department_id')),
			'orgchartPosition' => array(self::BELONGS_TO, 'OrgChart', array('position_id' => 'position_id')),


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
			'group'=>'Group',
			'employee_id' => 'เลขประจำตัวพนักงาน'
		);
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

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('pic_user',$this->pic_user,true);
		$criteria->compare('department_id',$this->department_id);
		$criteria->compare('activkey',$this->activkey,true);
		$criteria->compare('create_at',$this->create_at,true);
		$criteria->compare('lastvisit_at',$this->lastvisit_at,true);
		$criteria->compare('position_id',$this->position_id,true);
		$criteria->compare('branch_id',$this->branch_id,true);
	    $criteria->compare('org_user_status',$this->org_user_status,true);
		$criteria->compare('superuser',$this->superuser);
		$criteria->compare('status',$this->status);
		$criteria->compare('group',$this->group);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getCreateList(){
		$model = Users::model()->findAll();
		$list = CHtml::listData($model,'create_at','create_at');
		return $list;
	}

	public function getLastvisitList(){
		$model = Users::model()->findAll();
		$list = CHtml::listData($model,'lastvisit_at','lastvisit_at');
		return $list;
	}

	// public function getFullName()
 //   	{
 //      return $this->firstname . " " . $this->lastname;
 //   	}
}