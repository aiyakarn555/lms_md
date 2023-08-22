<?php

class LogoutController extends Controller
{
	public function init()
	{
		parent::init();
		$this->lastactivity();
		
	}
	public $defaultAction = 'logout';
	
	/**
	 * Logout the current user and redirect to returnLogoutUrl.
	 */
	public function actionLogout()
	{
		$logoutid = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		if($logoutid != ""){
			$logoutid->lastvisit_at = date("Y-m-d H:i:s",time()) ;
			$logoutid->online_status = '0';
			$logoutid->save(false);
			Yii::app()->user->logout();
		}
		$this->redirect(Yii::app()->controller->module->returnLogoutUrl);
	}

}