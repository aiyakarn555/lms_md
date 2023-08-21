<?php

/**
 * This is the model class for table "tbl_users".
 *
 * The followings are the available columns in table 'tbl_users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $activkey
 * @property integer $superuser
 * @property integer $status
 * @property string $create_at
 * @property string $lastvisit_at
 * @property string $student_house
 * @property string $student_id
 * @property string $student_board
 * @property string $student_branch
 * @property string $operator_degree
 * @property string $operator_business_type
 * @property string $operator_name
 * @property string $authitem_name
 * @property integer $point_user
 *
 * The followings are the available model relations:
 * @property TblProfiles $tblProfiles
 */
class Users extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('superuser, status, point_user', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>20),
			array('password, email, activkey', 'length', 'max'=>128),
			array('student_house, student_id, student_board, student_branch, operator_degree, operator_business_type, operator_name, authitem_name', 'length', 'max'=>255),
			array('create_at, lastvisit_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, email, activkey, superuser, status, create_at, lastvisit_at, student_house, student_id, student_board, student_branch, operator_degree, operator_business_type, operator_name, authitem_name, point_user', 'safe', 'on'=>'search'),
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
			'tblProfiles' => array(self::HAS_ONE, 'TblProfiles', 'user_id'),
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
			'activkey' => 'Activkey',
			'superuser' => 'Superuser',
			'status' => 'Status',
			'create_at' => 'Create At',
			'lastvisit_at' => 'Lastvisit At',
			'student_house' => 'Student House',
			'student_id' => 'Student',
			'student_board' => 'Student Board',
			'student_branch' => 'Student Branch',
			'operator_degree' => 'Operator Degree',
			'operator_business_type' => 'Operator Business Type',
			'operator_name' => 'Operator Name',
			'authitem_name' => 'Authitem Name',
			'point_user' => 'Point User',
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
		$criteria->compare('activkey',$this->activkey,true);
		$criteria->compare('superuser',$this->superuser);
		$criteria->compare('status',$this->status);
		$criteria->compare('create_at',$this->create_at,true);
		$criteria->compare('lastvisit_at',$this->lastvisit_at,true);
		$criteria->compare('student_house',$this->student_house,true);
		$criteria->compare('student_id',$this->student_id,true);
		$criteria->compare('student_board',$this->student_board,true);
		$criteria->compare('student_branch',$this->student_branch,true);
		$criteria->compare('operator_degree',$this->operator_degree,true);
		$criteria->compare('operator_business_type',$this->operator_business_type,true);
		$criteria->compare('operator_name',$this->operator_name,true);
		$criteria->compare('authitem_name',$this->authitem_name,true);
		$criteria->compare('point_user',$this->point_user);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
}
