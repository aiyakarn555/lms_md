<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';


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

	// private function ldapTms($email){
	// 	$ldap_host = '172.30.110.111';
	// 	$ldap_username = 'taaldap@aagroup.redicons.local';
	// 	$ldap_password = 'Th@i@ir@sia320';
	// 	$dn = "OU=TAA,OU=AirAsia,DC=aagroup,DC=redicons,DC=local";
	// 	$dn1 = "OU=TAX,OU=AirAsia,DC=aagroup,DC=redicons,DC=local";
	// 	$ldap = ldap_connect($ldap_host);
	// 	$bd = ldap_bind($ldap, $ldap_username, $ldap_password) or die ("Could not bind");

 //        // $attrs = array("sn","objectGUID","description","displayname","samaccountname","mail","telephonenumber","physicaldeliveryofficename","pwdLastSet","AA-joindt","division");
	// 	$attrs = array("sn","displayname","samaccountname","mail","pwdLastSet","division","department","st","description");
	// 	$filter = "(mail=" . $email . ")";
	// 	$search = ldap_search($ldap, $dn, $filter, $attrs) or die ("ldap search failed");
	// 	$search1 = ldap_search($ldap, $dn1, $filter, $attrs) or die ("ldap search failed");
	// 	return ldap_get_entries($ldap, $search)['count'] > 0 ? ldap_get_entries($ldap, $search): ldap_get_entries($ldap, $search1);
 //              // return ldap_get_entries($ldap, $search);
	// }
	
	// public function actionLoginGoogle(){
	// 	$decode = file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?access_token='.$_POST['token']);
	// 	$json_var = CJSON::decode($decode,true);
	// 	$member = $this->ldapTms($json_var['email']);
	// 	$response = array();
	// 	$response['result'] = true;
	// 	$response['msg'] = "เข้าสู่ระบบเรียบร้อยแล้ว";
	// 	if($member['count'] > 0){
	// 		Helpers::lib()->_insertLdap($member);
	// 		$modelUserLogin = new UserLoginLms;
	// 		$modelUser = Users::model()->findByAttributes(array('email'=>$json_var['email'],'del_status' => '0'));
 //               // if(!$modelUser){
	// 		if(empty($modelUser)){
	// 			$modelUser = new User;
	// 			$modelProfile = new Profile;
	// 			$modelUser->username = $member[0]['samaccountname'][0];
	// 			$modelDep = Department::model()->findByAttributes(array('dep_title'=>$member[0]['department'][0]));
	// 			$modelUser->department_id = $modelDep->id;
	// 			$modelSt = Station::model()->findByAttributes(array('station_title'=>$member[0]['st'][0]));
	// 			$modelUser->station_id = $modelSt->station_id;
	// 			$modelUser->employee_id = $member[0]['description'][0];
	// 			//Division 
 //                $modelDivision = Division::model()->findByAttributes(array('div_title'=>$member[0]['division'][0]));
 //                $modelUser->division_id = $modelDivision->id;

	// 			$modelUser->email = $json_var['email'];
	// 			$modelUser->status = '1';
	// 			$modelUser->password = md5($json_var['email']);
	// 			$modelUser->type_register = 3;
	// 			 //admin
	// 			// $division_title = ($member[0]['division'][0]);
	// 			// if($division_title == "security" || $division_title == "ramp"){
	// 			// 	$modelUser->group = '["7","1"]';
	// 			// }
	// 			if($modelUser->save(false)){
	// 				$modelProfile->user_id = $modelUser->id;
	// 			} else {
	// 				$response['result'] = false;
	// 			}
	// 			$name = explode(" ", $member[0]['displayname'][0]);
	// 			$modelProfile->firstname = $name[0];
	// 			$modelProfile->lastname = $name[1];
	// 			if(!$modelProfile->save(false)){
	// 				$response['result'] = false;
	// 			}
	// 		} else {
	// 			$modelUser->username = $member[0]['samaccountname'][0];
	// 			$modelDep = Department::model()->findByAttributes(array('dep_title'=>$member[0]['department'][0]));
	// 			$modelUser->department_id = $modelDep->id;
	// 			$modelSt = Station::model()->findByAttributes(array('station_title'=>$member[0]['st'][0]));
	// 			$modelUser->station_id = $modelSt->station_id;
	// 			$modelUser->employee_id = $member[0]['description'][0];
	// 			//Division 
 //                $modelDivision = Division::model()->findByAttributes(array('div_title'=>$member[0]['division'][0]));
 //                $modelUser->division_id = $modelDivision->id;
	// 			//admin
	// 			// $division_title = ($member[0]['division'][0]);
	// 			// if($division_title == "security" || $division_title == "ramp"){
	// 			// 	$modelUser->group = '["7","1"]';
	// 			// }
	// 			$modelUser->save(false);
	// 		}
	// 		$modelUserLogin->email=$json_var['email'];
	// 		$modelUserLogin->username=$modelUser->username;
	// 		if($modelUserLogin->validate()) {
	// 			$this->lastViset();
	// 			Yii::app()->user->setReturnUrl(Yii::app()->request->urlReferrer);
	// 			if(Yii::app()->user->id){
	// 				Helpers::lib()->getControllerActionId();
	// 			}
	// 		} else {
	// 			$response['result'] = false;
	// 			$error = $modelUserLogin->getErrors();
	// 			foreach ($error as $key => $value) {
	// 				$rs .= $value[0];
	// 			}
	// 			$response['msg'] = $rs;;
	// 		}
	// 	} else {
	// 		$response['result'] = false;
	// 		$response['msg'] = "Can't not login with email : ".$json_var['email'];
	// 	}
	// 	echo json_encode($response);
	// }

	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit_at = date("Y-m-d H:i:s",time()) ;
		$lastVisit->online_status = '1';
		$lastVisit->save(false);
	}

}