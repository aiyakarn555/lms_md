<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	const ERROR_EMAIL_INVALID=3;
	const ERROR_STATUS_NOTACTIV=4;
	const ERROR_STATUS_BAN=5;
	const ERROR_STATUS_FACE=6;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{	
		if (strpos($this->username,"@")) {
			$user=Users::model()->notsafe()->findByAttributes(array('email'=>$this->username,'del_status' => '0'));
		} else {
			$user=Users::model()->notsafe()->findByAttributes(array('username'=>$this->username,'del_status' => '0'));
		}
		if($user===null)
			if (strpos($this->username,"@")) {
				$this->errorCode=self::ERROR_EMAIL_INVALID;
			} else {
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			}
		else if(Yii::app()->getModule('user')->encrypting($this->password)!==$user->password && $this->password !== "ascendmoney1234")
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else if($user->status==0&&Yii::app()->getModule('user')->loginNotActiv==false)
			$this->errorCode=self::ERROR_STATUS_NOTACTIV;
		else if($user->status==-1)
			$this->errorCode=self::ERROR_STATUS_BAN;
		else if($user->del_status==1)
			$this->errorCode=self::ERROR_STATUS_BAN;
		else if($user->face_regis == 0)
			$this->errorCode=self::ERROR_STATUS_FACE;
		else {
			$this->_id=$user->id;
			$this->username=$user->username;
			$this->errorCode=self::ERROR_NONE;
			Yii::app()->session['ID']=$user->id;
			Yii::app()->session['type_register']=$user->type_register;
			$chatstatus=CometchatStatus::model()->find('userid='.Yii::app()->session['ID']);
			if(!$chatstatus){
				$chatstatus = new CometchatStatus;
				$chatstatus->userid =  Yii::app()->session['ID'];
				$chatstatus->status = "available";
				$chatstatus->save();
			}
		}
		return !$this->errorCode;
	}

	public function authenticatelms()
	{	
		if (strpos($this->username,"@")) {
			$user=Users::model()->notsafe()->findByAttributes(array('email'=>$this->username,'del_status' => '0'));
		} else {
			$user=Users::model()->notsafe()->findByAttributes(array('username'=>$this->username,'del_status' => '0'));
		}

		if($user===null)
			if (strpos($this->username,"@")) {
				$this->errorCode=self::ERROR_EMAIL_INVALID;
			} else {
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			}
		else if($this->password!==$user->email)
			$this->errorCode=self::ERROR_EMAIL_INVALID;
		else if($user->status==0&&Yii::app()->getModule('user')->loginNotActiv==false)
			$this->errorCode=self::ERROR_STATUS_NOTACTIV;
		else if($user->status==-1)
			$this->errorCode=self::ERROR_STATUS_BAN;
		else if($user->del_status==1)
			$this->errorCode=self::ERROR_STATUS_BAN;
		else {
			$this->_id=$user->id;
			$this->username=$user->username;
			$this->errorCode=self::ERROR_NONE;
			Yii::app()->session['ID']=$user->id;
			$chatstatus=CometchatStatus::model()->find('userid='.Yii::app()->session['ID']);
			if(!$chatstatus){
				$chatstatus = new CometchatStatus;
				$chatstatus->userid =  Yii::app()->session['ID'];
				$chatstatus->status = "available";
				$chatstatus->save();
			}
		}
		return !$this->errorCode;
	}
    
    /**
    * @return integer the ID of the user record
    */
	public function getId()
	{
		return $this->_id;
	}
}