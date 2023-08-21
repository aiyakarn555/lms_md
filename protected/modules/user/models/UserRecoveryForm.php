<?php

/**
 * UserRecoveryForm class.
 * UserRecoveryForm is the data structure for keeping
 * user recovery form data. It is used by the 'recovery' action of 'UserController'.
 */
class UserRecoveryForm extends CFormModel {
	//public $login_or_email;
	public $user_id;
	public $usernameiden;
	public $newpassword, $confirmpass;
	// public $login_or_email;
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			// array('login_or_email', 'required'),
			array('usernameiden, newpassword, confirmpass', 'required'),
			array('usernameiden', 'length', 'max'=>13, 'min' => 13,'message' => 'กรอกเลขบัตรประชาชน 13 หลักเท่านั้น'),
			array('usernameiden', 'match', 'pattern' => '/^[0-9_]+$/u','message' => 'กรอกเลขบัตรประชาชน 13 หลักเท่านั้น'),
			array('newpassword', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('confirmpass', 'compare', 'compareAttribute'=>'newpassword', 'message' => UserModule::t("Retype Password is incorrect.")),
			// array('login_or_email', 'match', 'pattern' => '/^[A-Za-z0-9@.-\s,]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			// password needs to be authenticated
			// array('login_or_email', 'checkexists'),
			array('usernameiden', 'checkexistsIden'),
		);
	}
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			//'login_or_email'=>UserModule::t("username or email"),
			'usernameiden' => 'รหัสบัตรประชาชน',
			'newpassword' => 'รหัสผ่านใหม่',
			'confirmpass' => 'ยืนยันรหัสผ่านใหม่',
		);
	}
	
	public function checkexists($attribute,$params) {
		if(!$this->hasErrors())  // we only want to authenticate when no input errors
		{
			if (strpos($this->login_or_email,"@")) {
				$user=User::model()->findByAttributes(array('email'=>$this->login_or_email));
				if ($user)
					$this->user_id=$user->id;
			} else {
				$user=User::model()->findByAttributes(array('username'=>$this->login_or_email));
				if ($user)
					$this->user_id=$user->id;
			}
			
			if($user===null)
				if (strpos($this->login_or_email,"@")) {
					$this->addError("login_or_email",UserModule::t("Email is incorrect."));
				} else {
					$this->addError("login_or_email",UserModule::t("Username is incorrect."));
				}
		}
	}

	public function checkexistsIden($attribute,$params) {
		if(!$this->hasErrors())  // we only want to authenticate when no input errors
		{
			$user=User::model()->findByAttributes(array('username'=>$this->usernameiden));
			if ($user){
				$this->user_id=$user->id;
			}
			
			if($user===null) {
				$this->addError("usernameiden",UserModule::t("Username is incorrect."));
			}
		}
	}
	
}