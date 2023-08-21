<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class RegistrationForm extends User {
	public $id;
	public $verifyPassword;
	public $verifyCode;
	public $orgchart_lv2;
	public $card_id;

	public function rules() {
		$rules = array(
			array('username, password, verifyPassword, email', 'required'),
			array('username', 'length', 'max'=>13, 'min' => 13,'message' => 'กรอกเลขบัตรประชาชน 13 หลักเท่านั้น'),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('auditor_id', 'length', 'max'=>5, 'min' => 5,'message' => 'กรุณาป้อนเลขผู้สอบ 5 หลัก'),
			array('auditor_id', 'match', 'pattern' => '/^[0-9_]+$/u','message' => 'กรอกเลขทะเบียนผู้สอบบัญชี 5 หลักเท่านั้น'),
			array('email', 'email'),
			array('username', 'match', 'pattern' => '/^[0-9_]+$/u','message' => 'กรอกเลขบัตรประชาชน 13 หลักเท่านั้น'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			array('pic_user', 'file', 'types'=>'jpg, png, gif','allowEmpty' => true, 'on'=>'insert'),
			array('pic_user', 'file', 'types'=>'jpg, png, gif','allowEmpty' => true, 'on'=>'update'),
			array('card_id', 'file', 'types'=>'jpg, png, gif','allowEmpty' => true, 'on'=>'insert'),
			array('card_id', 'file', 'types'=>'jpg, png, gif','allowEmpty' => true, 'on'=>'update'),
			//array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")),
			// array('username', 'match', 'pattern' => '/^[0-9_]+$/u','message' => 'กรอกเลขบัตรประชาชน 13 หลักเท่านั้น'),
			// array(
			// 	    'validation',
			// 	    'application.extensions.recaptcha.EReCaptchaValidator',
			// 	    'privateKey'=> Yii::app()->params['recaptcha']['privateKey'],
			// 	),
		);
		// if (!(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')) {
		// 	array_push($rules,array('verifyCode', 'captcha', 'allowEmpty'=>!UserModule::doCaptcha('registration')));
		// }

		array_push($rules,array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")));
		return $rules;
	}

}
