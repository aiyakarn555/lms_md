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
 * @property string $auditor_id
 * @property string $pic_cardid2
 * @property integer $del_status
 * @property string $group
 * @property string $identification
 *
 * The followings are the available model relations:
 * @property Profiles $profiles
 */
class Reset extends CActiveRecord
{
	public $searchValue;
	public $news_per_page;
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
			array('username, password, email, create_at', 'required'),
			array('superuser, status, online_status, online_user, lastactivity, del_status', 'numerical', 'integerOnly'=>true),
			array('username, pic_user, orgchart_lv2, department_id, avatar, company_id, division_id, position_id, pic_cardid, pic_cardid2, group, identification', 'length', 'max'=>255),
			array('password, email, activkey', 'length', 'max'=>128),
			array('last_ip', 'length', 'max'=>100),
			array('bookkeeper_id', 'length', 'max'=>13),
			array('auditor_id', 'length', 'max'=>5),
			array('lastvisit_at, last_activity', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, email, pic_user, orgchart_lv2, department_id, activkey, create_at, lastvisit_at, superuser, status, online_status, online_user, last_ip, last_activity, lastactivity, avatar, company_id, division_id, position_id, bookkeeper_id, pic_cardid, auditor_id, pic_cardid2, del_status, group, identification', 'safe', 'on'=>'search'),
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
			'pic_user' => 'Pic User',
			'orgchart_lv2' => 'Orgchart Lv2',
			'department_id' => 'Department',
			'activkey' => 'Activkey',
			'create_at' => 'Create At',
			'lastvisit_at' => 'Lastvisit At',
			'superuser' => 'Superuser',
			'status' => 'Status',
			'online_status' => 'Online Status',
			'online_user' => 'Online User',
			'last_ip' => 'Last Ip',
			'last_activity' => 'Last Activity',
			'lastactivity' => 'Lastactivity',
			'avatar' => 'Avatar',
			'company_id' => 'Company',
			'division_id' => 'Division',
			'position_id' => 'Position',
			'bookkeeper_id' => 'Bookkeeper',
			'pic_cardid' => 'Pic Cardid',
			'auditor_id' => 'Auditor',
			'pic_cardid2' => 'Pic Cardid2',
			'del_status' => 'Del Status',
			'group' => '3=admin สูงสุด 2=adminดูแลระบบ',
			'identification' => 'เลขบัตรประชาชน',
			// 'searchValue' => 'ชื่อ นามสกุล/บัตรประชาชน'
			'searchValue' => 'ชื่อ นามสกุล'
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
		$criteria = new CDbCriteria;
		$criteria->select ='id,profiles.firstname,profiles.lastname';
		$criteria->join = "INNER JOIN tbl_profiles AS profiles ON(t.id=profiles.user_id) 
						   LEFT JOIN tbl_learn AS learn ON(t.id=learn.user_id)";
		// $criteria->join = "INNER JOIN tbl_learn AS learn ON(t.id=learn.user_id)";
		if($this->searchValue != null){
			$criteria->compare('profiles.firstname',$this->searchValue,true);
			$criteria->compare('profiles.lastname',$this->searchValue,true,'OR');
		}
		$criteria->group = 't.id';

		//$criteria->with = array('profiles');
		//$criteria->compare('id',$this->id);
		$poviderArray = array('criteria' => $criteria);
        // Page
		if (isset($this->news_per_page)) {
			$poviderArray['pagination'] = array('pageSize' => intval($this->news_per_page));
		} else {
			$poviderArray['pagination'] = array('pageSize' => intval(20));
		}

		return new CActiveDataProvider($this, $poviderArray);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reset the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
