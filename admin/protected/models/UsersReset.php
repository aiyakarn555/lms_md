<?php

/**
 * This is the model class for table "{{users}}".
 *
 * The followings are the available columns in table '{{users}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $otp
 * @property string $group
 * @property integer $online_status
 * @property string $avatar
 * @property string $department_id
 * @property string $position_id
 * @property integer $branch_id
 * @property integer $report_authority
 * @property integer $superuser
 * @property integer $status
 * @property integer $type_register
 * @property integer $repass_status
 * @property integer $register_status
 * @property integer $online_user
 * @property integer $del_status
 * @property string $pic_user
 * @property string $identification
 * @property string $activkey
 * @property integer $lastactivity
 * @property string $last_ip
 * @property string $lastvisit_at
 * @property string $last_activity
 * @property string $create_at
 * @property integer $org_user_status
 * @property string $station_id
 * @property string $company_id
 * @property string $division_id
 * @property string $employee_id
 * @property string $bookkeeper_id
 * @property string $pic_cardid
 * @property string $orgchart_lv2
 * @property string $auditor_id
 * @property string $pic_cardid2
 * @property string $verifyPassword
 * @property string $note
 * @property string $not_passed
 * @property string $exprie_date
 * @property integer $face_regis
 * @property integer $institution_id
 *
 * The followings are the available model relations:
 * @property Profiles $profiles
 */
class UsersReset extends CActiveRecord
{
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
			array('otp, online_status, branch_id, report_authority, superuser, status, type_register, repass_status, register_status, online_user, del_status, lastactivity, org_user_status, face_regis, institution_id', 'numerical', 'integerOnly'=>true),
			array('username, group, avatar, department_id, position_id, pic_user, identification, station_id, company_id, division_id, pic_cardid, orgchart_lv2, pic_cardid2, verifyPassword, note, not_passed', 'length', 'max'=>255),
			array('password, email, activkey', 'length', 'max'=>128),
			array('last_ip', 'length', 'max'=>100),
			array('employee_id', 'length', 'max'=>11),
			array('bookkeeper_id', 'length', 'max'=>13),
			array('auditor_id', 'length', 'max'=>5),
			array('lastvisit_at, last_activity, create_at, exprie_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, email, otp, group, online_status, avatar, department_id, position_id, branch_id, report_authority, superuser, status, type_register, repass_status, register_status, online_user, del_status, pic_user, identification, activkey, lastactivity, last_ip, lastvisit_at, last_activity, create_at, org_user_status, station_id, company_id, division_id, employee_id, bookkeeper_id, pic_cardid, orgchart_lv2, auditor_id, pic_cardid2, verifyPassword, note, not_passed, exprie_date, face_regis, institution_id', 'safe', 'on'=>'search'),
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
			'otp' => 'Otp',
			'group' => 'Group',
			'online_status' => 'Online Status',
			'avatar' => 'Avatar',
			'department_id' => 'Department',
			'position_id' => 'Position',
			'branch_id' => 'Branch',
			'report_authority' => 'Report Authority',
			'superuser' => 'Superuser',
			'status' => 'Status',
			'type_register' => 'Type Register',
			'repass_status' => 'Repass Status',
			'register_status' => 'Register Status',
			'online_user' => 'Online User',
			'del_status' => 'Del Status',
			'pic_user' => 'Pic User',
			'identification' => 'Identification',
			'activkey' => 'Activkey',
			'lastactivity' => 'Lastactivity',
			'last_ip' => 'Last Ip',
			'lastvisit_at' => 'Lastvisit At',
			'last_activity' => 'Last Activity',
			'create_at' => 'Create At',
			'org_user_status' => 'Org User Status',
			'station_id' => 'Station',
			'company_id' => 'Company',
			'division_id' => 'Division',
			'employee_id' => 'Employee',
			'bookkeeper_id' => 'Bookkeeper',
			'pic_cardid' => 'Pic Cardid',
			'orgchart_lv2' => 'Orgchart Lv2',
			'auditor_id' => 'Auditor',
			'pic_cardid2' => 'Pic Cardid2',
			'verifyPassword' => 'Verify Password',
			'note' => 'Note',
			'not_passed' => 'Not Passed',
			'exprie_date' => 'Exprie Date',
			'face_regis' => 'Face Regis',
			'institution_id' => 'Institution',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('otp',$this->otp);
		$criteria->compare('group',$this->group,true);
		$criteria->compare('online_status',$this->online_status);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('department_id',$this->department_id,true);
		$criteria->compare('position_id',$this->position_id,true);
		$criteria->compare('branch_id',$this->branch_id);
		$criteria->compare('report_authority',$this->report_authority);
		$criteria->compare('superuser',$this->superuser);
		$criteria->compare('status',$this->status);
		$criteria->compare('type_register',$this->type_register);
		$criteria->compare('repass_status',$this->repass_status);
		$criteria->compare('register_status',$this->register_status);
		$criteria->compare('online_user',$this->online_user);
		$criteria->compare('del_status',$this->del_status);
		$criteria->compare('pic_user',$this->pic_user,true);
		$criteria->compare('identification',$this->identification,true);
		$criteria->compare('activkey',$this->activkey,true);
		$criteria->compare('lastactivity',$this->lastactivity);
		$criteria->compare('last_ip',$this->last_ip,true);
		$criteria->compare('lastvisit_at',$this->lastvisit_at,true);
		$criteria->compare('last_activity',$this->last_activity,true);
		$criteria->compare('create_at',$this->create_at,true);
		$criteria->compare('org_user_status',$this->org_user_status);
		$criteria->compare('station_id',$this->station_id,true);
		$criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('division_id',$this->division_id,true);
		$criteria->compare('employee_id',$this->employee_id,true);
		$criteria->compare('bookkeeper_id',$this->bookkeeper_id,true);
		$criteria->compare('pic_cardid',$this->pic_cardid,true);
		$criteria->compare('orgchart_lv2',$this->orgchart_lv2,true);
		$criteria->compare('auditor_id',$this->auditor_id,true);
		$criteria->compare('pic_cardid2',$this->pic_cardid2,true);
		$criteria->compare('verifyPassword',$this->verifyPassword,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('not_passed',$this->not_passed,true);
		$criteria->compare('exprie_date',$this->exprie_date,true);
		$criteria->compare('face_regis',$this->face_regis);
		$criteria->compare('institution_id',$this->institution_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UsersReset the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
