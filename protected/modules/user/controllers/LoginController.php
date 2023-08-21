<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$status = false;
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
            $this->performAjaxValidation($model);
			// collect user input data
			// exit();
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {

			        // (email) Calculator time course notification // start
			        $user = User::model()->findByPk(Yii::app()->user->id);
			        $profile = $user->profile;
			        if($profile->generation != '' && is_numeric($profile->generation)){
			        	$course_notifications = CourseNotification::model()->findAll(array('condition'=>'generation_id='.$profile->generation,'order'=>'end_date DESC'));
				        $data = '';
				        $i = 0;
				        foreach ($course_notifications as $key => $course_notification) {
			                $checkNotification = Helpers::lib()->emailNotificationCourse($course_notification);
			                if($checkNotification != false){
			                	$i++;
			                	$name = CourseOnline::model()->findByPk($checkNotification[0]);
			                	$data .= '<br>'.$i.'. '.$name->course_title.' เหลือเวลาเรียน '.$checkNotification[1].' วัน ';
			                	$status = true;
			                }
				        }
				        if($status){
							$check = UserModule::sendMail($user->email,'ระบบแจ้งเตือนการเรียนหลักสูตร',UserModule::t("รายชื่อหลักสูตรที่ใกล้หมดเวลาเรียน มีดังนี้ {name} <br>กรุณาเข้าสู่ระบบเพื่อเข้าเรียนหลักสูตร",array('{name}'=>$data)));
							if (!$check) {
							    Yii::app()->user->setFlash('error',' Error while sending email: '.$mail->getError());
							}
				        }
			        }
			        // (email) Calculator time course notification // end

					//$this->lastVisit();
					$DateOfRequest = date("Y-m-d H:i:s", time());
					if (Yii::app()->user->returnUrl=='/index.php'){
						// Yii::app()->session['id']=Yii::app()->user->id();
						Yii::app()->session['ID']=Yii::app()->user->id;
						$user->online_status=1;
						$user->lastvisit_at = $DateOfRequest;
						$user->save(false);
						$this->getPlatform($user);
                        Yii::app()->user->setFlash('login','เข้าสู่ระบบสำเร็จ');
                        Yii::app()->user->setFlash('messages','ยินดีต้อนรับ คุณ :'.$user->profile->firstname.' '.$user->profile->lastname);
						$this->redirect(Yii::app()->controller->module->returnUrl);
					}else{
						Yii::app()->session['ID']=Yii::app()->user->id;
						$user->online_status=1;
						$user->lastvisit_at = $DateOfRequest;
						$user->save(false);
						$this->getPlatform($user);
                        Yii::app()->user->setFlash('login','เข้าสู่ระบบสำเร็จ');
                        Yii::app()->user->setFlash('messages','ยินดีต้อนรับ คุณ :'.$user->profile->firstname.' '.$user->profile->lastname);
						$this->redirect(Yii::app()->user->returnUrl);
					}
				}
			}
			// display the login form
			$this->render('/user/login',array('model'=>$model));
		} else{
			// (email) Calculator time course notification // start
	        $user = User::model()->findByPk(Yii::app()->user->id);
	        $profile = $user->profile;
	        $course_notifications = CourseNotification::model()->findAll(array('condition'=>'generation_id='.$profile->generation,'order'=>'end_date DESC'));
	        $data = '';
			$i = 0;
	        foreach ($course_notifications as $key => $course_notification) {
                $checkNotification = Helpers::lib()->emailNotificationCourse($course_notification);
                if($checkNotification != false){
                	$i++;
                	$name = CourseOnline::model()->findByPk($checkNotification[0]);
                	$data .= '<br>'.$i.'. '.$name->course_title.' เหลือเวลาเรียน '.$checkNotification[1].' วัน ';
                	$status = true;
                }
	        }
	        if($status){
				$check = UserModule::sendMail($user->email,'ระบบแจ้งเตือนการเรียนหลักสูตร',UserModule::t("รายชื่อหลักสูตรที่ใกล้หมดเวลาเรียน มีดังนี้ {name} <br>กรุณาเข้าสู่ระบบเพื่อเข้าเรียนหลักสูตร",array('{name}'=>$data)));
				if (!$check) {
				    Yii::app()->user->setFlash('error',' Error while sending email: '.$mail->getError());
				}
	        }
	        $DateOfRequest = date("Y-m-d H:i:s", time());
	        // (email) Calculator time course notification // end
	        $user->online_status=1;
			$user->lastvisit_at = $DateOfRequest;
			$user->save(false);
			$this->getPlatform($user);
            Yii::app()->user->setFlash('login','เข้าสู่ระบบสำเร็จ');
            Yii::app()->user->setFlash('messages','ยินดีต้อนรับ คุณ :'.$user->profile->firstname.' '.$user->profile->lastname);
            $this->redirect(Yii::app()->controller->module->returnUrl);
        }
	}

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo UActiveForm::validate($model);
            Yii::app()->end();
        }
    }

	private function lastVisit() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit_at = time();
		$lastVisit->save();
	}

	private function getPlatform($userArray) {
		if($userArray) {
			$curBrowser = get_browser(null, true);

			$platform = new Platform;
			$platform->user_id = $userArray['id'];
			$platform->user_agent = $curBrowser['browser_name_pattern'];
			$platform->user_device = $curBrowser['device_type'];
			$platform->user_browser = $curBrowser['browser'];
			$platform->create_date = date("Y-m-d H:i:s");
			$platform->save(false);

		}
	}

}