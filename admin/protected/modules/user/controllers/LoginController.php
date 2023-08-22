<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';
	public $rememberMe;


	public function init()
	{
		parent::init();
		$this->lastactivity();
		// Clear main layout
		$this->layout = false;//$this->module->layout;
		
	}
	
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
			
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {

					$this->lastViset();
					$this->saveToken();
					$this->redirect(array('/site/index'));
					// if (Yii::app()->user->returnUrl=='/index.php'){
					// 	$this->redirect(Yii::app()->controller->module->returnUrl);
					// }
					// else{
					// 	$this->redirect(Yii::app()->user->returnUrl);
					// }
				}
			}
			// display the login form
			$this->render('/user/login',array('model'=>$model));
		} else
		$this->redirect(Yii::app()->controller->module->returnUrl);
	}

	private function saveToken() {
        $lastVisit = Users::model()->findByPk(Yii::app()->user->id);
        $token = UserModule::encrypting(time());
        $lastVisit->avatar = $token;
        //Set cookie token for login
        $time = time()+7200; //2 hr.
        $cookie = new CHttpCookie('token_login', $token); //set value
        $cookie->expire = $time; 
        Yii::app()->request->cookies['token_login'] = $cookie;
        $lastVisit->save(false);
      }


	
	  private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit_at = date("Y-m-d H:i:s",time()) ;
		$lastVisit->online_status = '1';
		$lastVisit->save(false);
	}

	private function otp($id, $email) {

		$otp = rand(100000, 999999);
		$to = array();
		$to['email'] = $email;
		$User = User::model()->notsafe()->findByPk($id);
		$User->otp = $otp;
		$User->save(false);

		$logotp = new Logotp;
		$logotp->user_id = $id;
		$logotp->code = $otp;
		$logotp->save();

		$send = Helpers::lib()->SendMailOTP($to, $otp);
	}

	public function actionLogoutNoredirect()
        {
          if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
          }
          //$logoutid = Users::model()->notsafe()->findByPk(Yii::app()->user->id);
          $logoutid = User::model()->notsafe()->findByPk(Yii::app()->user->id);
          $logoutid->lastvisit_at = date("Y-m-d H:i:s",time()) ;
          $logoutid->online_status = '0';
          $logoutid->save(false);
          Yii::app()->user->logout();
          //$this->redirect(array('site/index'));
        // $this->render('/site/index');
        }

}