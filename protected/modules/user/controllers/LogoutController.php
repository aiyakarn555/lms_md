<?php

class LogoutController extends Controller
{
	public $defaultAction = 'logout';
	/**
	 * Logout the current user and redirect to returnLogoutUrl.
	 */
	public function actionLogout()
	{
		$user=Users::model()->findByPk(Yii::app()->user->id);
		$user->online_status=0;
		$user->save();
		Yii::app()->user->logout();
		Yii::app()->session->clear();
		$this->redirect(Yii::app()->homeUrl);
	}

}