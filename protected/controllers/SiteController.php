<?php

class SiteController extends Controller
{
	public function init()
	{
		parent::init();
		$this->lastactivity();
		
	}
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function actionInfo()
	{

		phpinfo();exit();
	}

	public function actionFaceLogin($useld , $profile )
	{

		if(Yii::app()->session['utt'] && Yii::app()->session['ptt']){
			$use = Yii::app()->session['utt'];
			$pas = Yii::app()->session['ptt'];
		}
		// else{
		// 	return $this->redirect(array('site/login'));
		// }

		if(Yii::app()->user->id){
			$logoutid = Users::model()->notsafe()->findByPk(Yii::app()->user->id);
			$logoutid->lastvisit_at = date("Y-m-d H:i:s", time());
			$logoutid->online_status = '0';
			$logoutid->save(false);
			Yii::app()->user->logout();
		}

		
		if(isset($_POST['current_image'])){

			$user_id = $_POST['userId'];
			$data = $_POST['current_image'];
			$use = $_POST['use'];
			$pas = $_POST['pas'];

			$to['email'] = "aiyakarn2540@gmail.com";
	       	$to['firstname'] ='ทดสอบ';
	       	$to['lastname'] = 'ส่งเมล';
        	$subject = 'the subject';
        	$message = $data;
    

			list($type, $data) = explode(';', $data);

			list(, $data)      = explode(',', $data);

			$data = base64_decode($data);


			$path = 'uploads/FaceLogin/';
			$file_name = $useld;
			$file_extension = '.jpg';
			$full_path = $path.$file_name.$file_extension;

			$success = file_put_contents($full_path, $data);


			if(!$success){
				$msg = "ไม่สามารถเปรียบเทียบรูปภาพได้ กรุณาลองอีกครั้ง";
				Yii::app()->user->setFlash('msg',$msg);
				Yii::app()->user->setFlash('icon','warning');
				
				Yii::app()->session['utt'] = $use;
				Yii::app()->session['ptt'] = $pas;

				// $this->redirect('FaceLogin', ['userId' => $useld, 'profile' => $profile, 'use' => $use, 'pas' => $pas]);
            	$this->redirect(array('//site/FaceLogin', 'useld' => $useld, 'profile' => $profile));

			}else{

				// api
				$chk_Face_image = Helpers::lib()->ApiFaceImage($_POST['current_image'] , $useld);
				if($chk_Face_image){
					$model=new UserLogin;
					$model->username = $use;
					$model->password = $pas;

					if($use == null || $pas == null){
						return $this->redirect(array('site/login'));
					}

					if($model->validate()) {

						unset($session['utt']);
						unset($session['ptt']);

						$msg = "Welcome. ".$profile;
						Yii::app()->user->setFlash('msg',$msg);
						Yii::app()->user->setFlash('icon','success'); 

						Yii::app()->session['popup'] = 1;
						Yii::app()->session['lang'] = 2;
						$this->lastViset();
						$this->saveToken();

						return $this->redirect(array('site/index'));

					}
				}
				
				else
				{
					$msg = "Your face does not match. Please try again";
					Yii::app()->user->setFlash('msg',$msg);
					Yii::app()->user->setFlash('icon','warning'); 
					Yii::app()->session['utt'] = $use;
					Yii::app()->session['ptt'] = $pas;

            		$this->redirect(array('//site/FaceLogin', 'useld' => $useld, 'profile' => $profile));
				}
			}
		}
		
	$this->render('FaceLogin', ['userId' => $useld, 'profile' => $profile, 'use' => $use, 'pas' => $pas]);

	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionChangelanguage()
	{
		$lang = $_POST['lang'];
		$url = $_POST['url'];

		if(!empty($_POST['lang'])) {
			Yii::app()->session['lang'] = $_POST['lang'];
		}

		$this->redirect($url);
	}

    public function actionAutoCheck()
    {
    	$keys = $_GET['key'];
        if($keys != '90b80dfe-3717-49af-9beb-b62e726c74af'){
            $this->redirect(array('site/index'));
        }

        $MonthCheck = MonthCheck::model()->findAll('active="y" AND month_status="y" AND type_user=1');
        if ($MonthCheck) {
            foreach ($MonthCheck as $key => $valuem) {
                $type_user =  $valuem['type_user'];
                 if ($valuem) {
                        $start_date = date("Y-m-d h:i:s", strtotime('-99 month'));
                        $end_date = date("Y-m-d h:i:s", strtotime('-'.$valuem['month'].' month'));
                        $model =  Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('tbl_users u')
                                ->join('tbl_profiles p', 'u.id=p.user_id')
                                ->where('del_status=:del_status AND status=:status AND superuser=:superuser AND p.type_user=:type_user', array(':del_status'=>0,':status'=>1,':superuser'=>0,':type_user'=>$valuem['type_user']))
                                ->andWhere('lastvisit_at > :start AND lastvisit_at < :end', array(':start' => $start_date ,':end' => $end_date))
                                ->queryAll();
                                foreach ($model as $key => $value) {
                                $update = Yii::app()->db->createCommand()
                                        ->update('tbl_users', array('del_status'=>1,), 'id=:id', array(':id'=>$value['id']));
                                } 

                }
            }
        }

		$MonthCheck_personal = MonthCheck::model()->findAll('active="y" AND month_status="y" AND type_user=5');
		if ($MonthCheck_personal) {
			foreach ($MonthCheck_personal as $key => $valuem) {
		        $type_user =  $valuem['type_user'];
		         if ($valuem) {
			         	$start_date_personal = date("Y-m-d h:i:s", strtotime('-99 month'));
						$end_date_personal = date("Y-m-d h:i:s", strtotime('-'.$valuem['month'].' month'));
						$model_personal =  Yii::app()->db->createCommand()
							    ->select('*')
							    ->from('tbl_users u')
							    ->join('tbl_profiles p', 'u.id=p.user_id')
							    ->where('del_status=:del_status AND status=:status AND superuser=:superuser AND p.type_user=:type_user', array(':del_status'=>0,':status'=>1,':superuser'=>0,':type_user'=>$valuem['type_user']))
							    ->andWhere('lastvisit_at > :start AND lastvisit_at < :end', array(':start' => $start_date_personal ,':end' => $end_date_personal))
							    ->queryAll();
							    foreach ($model_personal as $key => $value) {
							    $update = Yii::app()->db->createCommand()
							    		->update('tbl_users', array('del_status'=>1,), 'id=:id', array(':id'=>$value['id']));
							    } 

		        }
			}
		}
    }
    
    public function actionSendMailCouseNotification()
    {
        $keys = $_GET['key'];

        if($keys != '75yf0pu-6852-78re-2314-gde14un23aq1'){
            $this->redirect(array('site/index'));
        }
        $criteria = new CDbCriteria;
        $criteria->compare('active',1);
        $course_notifications = CourseNotification::model()->findAll($criteria);
        if ($course_notifications) {
            $CourseNotification_idCouse = [];
            $CourseNotification_day = [];
            foreach ($course_notifications as $key => $value) {

                $CourseNotification_idCouse[] = $value->course_id; 
                $CourseNotification_day[] = $value->notification_time; 
            }

             $criteria = new CDbCriteria;
            $criteria->compare('course_id',$CourseNotification_idCouse);
            $criteria->compare('active','y');
            $course_CourseOnline = CourseOnline::model()->findAll($criteria);
            
            $CourseOnline_course_id = [];
            $CourseOnline_courseName = [];
            foreach ($course_CourseOnline as $keyCou => $valueCou) {
                   $course_end = $valueCou->course_date_end;
                   $date1 = new DateTime(date("Y-m-d h:i:s", strtotime($course_end)));
                   $date_now = new DateTime(date("Y-m-d h:i:s", strtotime("now")));
                   $days_diff = $date1->diff($date_now)->days; 
          
                 if ((string)$days_diff === $CourseNotification_day[$keyCou]) {
                     $CourseOnline_course_id[] = $valueCou->course_id;
                     $CourseOnline_courseName[] = $valueCou->course_title;
                 }              
                
            }

            $Passcours_idCouse = [];
            $Passcours_user = [];

                $criteria = new CDbCriteria;
                $criteria->compare('passcours_cours',$CourseOnline_course_id);
                $Passcours = Passcours::model()->findAll($criteria);
                foreach ($Passcours as $keyPass => $valuePass) {
                        $Passcours_idCouse[] = $valuePass->passcours_cours;
                        $Passcours_user[] = $valuePass->passcours_user;
            }
             
            $criteria = new CDbCriteria;
            $criteria->compare('course_id',$CourseOnline_course_id);
            $criteria->addNotInCondition('user_id',$Passcours_user);
            $criteria->compare('active','y');
            $course_LogStartcourse = LogStartcourse::model()->findAll($criteria);
          
            if ($course_LogStartcourse) {
				$groups = array();
                foreach ($course_LogStartcourse as $key => $value) {

					$model = User::model()->findByPk($value->user_id);
                	$profile = Profile::model()->findByPk($value->user_id);

					$groups[$key]['dayEnd']= $CourseNotification_day[$key];
					$groups[$key]['nameCourse']= $CourseOnline_courseName[$key];
					$groups[$key]['email']= $model->email;
					$groups[$key]['firstname']= $model->profile->firstname_en;
					$groups[$key]['lastname']= $model->profile->lastname_en;
					$groups[$key]['head_id']= $model->profile->head_id;
					$groups[$key]['course_id']= $value->course_id;

                 }

				 $results = array();
				 foreach ($groups as $group) {
					 $results[$group['head_id']][] = $group;
				 }

				 $to = array();
				 foreach($results as $headID => $results){

					$criteria = new CDbCriteria;
					$criteria->compare('employee_code',$headID);
					$Profiles = Profile::model()->find($criteria);
					$model = User::model()->findByPk($Profiles->user_id);
					$to['email'] = $model->email;
					$to['firstname'] = $model->profile->firstname;
					$to['lastname'] = $model->profile->lastname;
					
					$message = $this->renderPartial('_mail_CourseNotification',array('model' => $results),true);

					if($message){
						$send = Helpers::lib()->SendMail($to,'แจ้งเตือนหลักสูตรกำลังจะหมดอายุ',$message);
				
					}
					
				 }
            }
           
          
        }
              
    }


	public function actionDashboard()
	{
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		if(Yii::app()->user->isGuest){
			$this->redirect('index');
		}
		if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
			$langId = Yii::app()->session['lang'] = 1;
		}else{
			$langId = Yii::app()->session['lang'];
		}

		//Label Multi lang
		$label = MenuSite::model()->find(array(
			'condition' => 'lang_id=:lang_id',
			'params' => array(':lang_id' => $langId)
		));
		if(!$label){
			$label = MenuSite::model()->find(array(
				'condition' => 'lang_id=:lang_id',
				'params' => array(':lang_id' => 1)
			));
		}

		// query course ตาม org

		$userModel = Users::model()->findByPK(Yii::app()->user->id);


            $course = CourseOnline::model()->findAll(array(
            	'condition' => 'lang_id=:lang_id AND active=:active',
            	'params' => array(':lang_id'=>'1', ':active'=>'y'),
            	'order' => 'sortOrder ASC'
            ));



            $criteria = new CDbCriteria;
            $criteria->with = array('course');
            if (isset($_GET['Search'])) {
            	if($_GET['Search'] != ""){
            		$criteria->compare('course.course_title',$_GET['Search'],true);
            	}
            }
            $criteria->compare('t.active','y');
            $criteria->compare('user_id',Yii::app()->user->id);

            $logStartCourse_model = LogStartcourse::model()->findAll($criteria);
            // array(
            // 	'condition' => 'user_id=:user_id AND active=:active',
            // 	'params' => array(':user_id'=>Yii::app()->user->id, ':active'=>'y')
            // )


            // course




            $Passcours = Passcours::model()->findAll(array('condition'=>'passcours_user = '.Yii::app()->user->id));
            $arr_log_course_id = array();            
            $arr_log_course_gen_id = array();            
            $arr_log_gen_id = array();     
            $cate_arr = array();            

            foreach ($logStartCourse_model as $key => $value) {
            	$arr_log_course_id[] = $value->course_id;
            	$arr_log_course_gen_id[$value->gen_id] = $value->course_id;
            	$arr_log_gen_id[] = $value->gen_id;
            	$cate_arr[] = $value->course->cate_id;
            }


            $criteria = new CDbCriteria;
            $criteria->addIncondition('cate_id',$cate_arr);
            if (isset($_GET['SearchCate'])) {
            	if($_GET['SearchCate'] != 0){
			$criteria->compare('cate_id',$_GET['SearchCate']);
            	}
            }
			$criteria->compare('active','y');
			$criteria->compare('cate_show','1');

            $cate_coure = Category::model()->findAll($criteria);


			$criteria = new CDbCriteria;
            $criteria->addIncondition('cate_id',$cate_arr);
			$criteria->compare('active','y');
			$criteria->compare('cate_show','1');
			$cate_coure_list = Category::model()->findAll($criteria);
         

            // echo ("<pre>");
            // print_r($Passcours); exit();

		$this->render('dashboard', array(
			'user'=>$user,
			'label'=> $label,
			'course'=> $course,
			'start_course'=>$logStartCourse_model,
            'Passcours'=>$Passcours,
			'arr_log_course_id'=> $arr_log_course_id,
			'arr_log_gen_id'=> $arr_log_gen_id,
			'arr_log_course_gen_id'=> $arr_log_course_gen_id,
			'cate_coure'=> $cate_coure,
			'cate_coure_list'=> $cate_coure_list,
			'SearchCate'=>$_GET['SearchCate'],
			'Search'=>$_GET['Search'],

		));
	}


    public function actionTestSendmail()
    {
       $email =  $_GET['mail'];
       if($email){
       $to['email'] = $email;
       $to['firstname'] ='ทดสอบ';
       $to['lastname'] = 'ส่งเมล';
        $subject = 'the subject';
        $message = 'hello';
    
        $send = Helpers::lib()->SendMail($to,$subject,$message);
        }
    }




	public function actionIndex($login = null)
	{	

		if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
			$langId = Yii::app()->session['lang'] = 1;
			Yii::app()->language = 'en';
		}else{
			$langId = Yii::app()->session['lang'];
			Yii::app()->language = (Yii::app()->session['lang'] == 1)? 'en':'th';
		}


		$label = MenuSite::model()->find(array(
			'condition' => 'lang_id=:lang_id',
			'params' => array(':lang_id' => $langId)
		));
		if(!$label){
			$label = MenuSite::model()->find(array(
				'condition' => 'lang_id=:lang_id',
				'params' => array(':lang_id' => 1)
			));
		}

		$labelCourse = MenuCourse::model()->find(array(
			'condition' => 'lang_id=:lang_id',
			'params' => array(':lang_id' => $langId)
		));
		if(!$labelCourse){
			$labelCourse = MenuCourse::model()->find(array(
				'condition' => 'lang_id=:lang_id',
				'params' => array(':lang_id' => 1)
			));
		}

		$this->layout = '//layouts/mainIndex';

		if(Yii::app()->user->id != null){
			$userModel = Users::model()->findByPK(Yii::app()->user->id);

			$criteria = new CDbCriteria;
			$criteria->with = array('course','course.CategoryTitle');
			$criteria->compare('course.active','y');
			$criteria->compare('course.status','1');
			$criteria->compare('categorys.cate_show','1');
			$criteria->addCondition('course.course_date_end >= :date_now');
			$criteria->params[':date_now'] = date('Y-m-d H:i');
			$criteria->order = 'course.course_id';
			// $criteria->limit = 5;
			$modelOrgCourse = OrgCourse::model()->findAll($criteria);
			$course_id = [];
			if($modelOrgCourse){
				foreach ($modelOrgCourse as $key => $value) {

					$modelUsers_old = ChkUsercourse::model()->find(
						array(
							'condition' => 'course_id=:course_id AND user_id=:user_id AND org_user_status=:org_user_status',
							'params' => array(':course_id'=>$value->course_id, ':user_id'=>Yii::app()->user->id, ':org_user_status'=>1)
						)
					);

					if($modelUsers_old){
						$course_id[] = $value->course_id;
					}
				}

			}

			$criteria = new CDbCriteria;
			$criteria->with = array('course','course.CategoryTitle');
			$criteria->compare('course.active','y');
			$criteria->compare('course.status','1');
			$criteria->compare('categorys.cate_show','1');
			$criteria->compare('user_id',Yii::app()->user->id);
			$criteria->compare('t.status','y');
			$criteria->addCondition('course.course_date_end >= :date_now');
			$criteria->params[':date_now'] = date('Y-m-d H:i');
			$criteria->order = 'course.course_id';
			$modelTemp = CourseTemp::model()->findAll($criteria);

			foreach ($modelTemp as $keytemp => $valTemp) {
				$course_id[] = $valTemp->course_id;
			}


				$criteria = new CDbCriteria;
                $criteria->addIncondition('course_id',$course_id);
				$criteria->compare('lang_id',1);
				$criteria->order = 'course_title ASC';
				$course = CourseOnline::model()->findAll($criteria);

				$criteria = new CDbCriteria;
                $criteria->addIncondition('course_id',$course_id);
				$criteria->compare('recommend','y');
				$criteria->compare('lang_id',1);
				$criteria->order = 'course_title ASC';
				$course_recommend = CourseOnline::model()->findAll($criteria);

				// Virtual Classroom
				$criteria = new CDbCriteria;
				$criteria->with = array('teams');
				$criteria->compare('teams.active','y');
				$criteria->compare('user_id',Yii::app()->user->id);
				$criteria->addCondition('teams.end_date >= :date_now');
				$criteria->params[':date_now'] = date('Y-m-d H:i');
				$criteria->order = 'teams.id';
				$modelTemp = MsteamsTemp::model()->findAll($criteria);

				foreach ($modelTemp as $keytemp => $valTemp) {
					$teams_id[] = $valTemp->ms_teams_id;
				}

				$criteria = new CDbCriteria;
				$criteria->addIncondition('id',$teams_id);
				if(isset($_POST["course_title"])){
					$criteria->compare('name_ms_teams',$_POST["course_title"],true);
				}
				$criteria->compare('active', 'y');
				if($_POST["sort"] == 2){
					$criteria->order = 'id ASC';
				}else{
					$criteria->order = 'id DESC';
				}
				$MsTeams = MsTeams::model()->findAll($criteria);
				// Virtual Classroom
		} 
			


		$criteria = new CDbCriteria;
		$criteria->compare('active', y);
		$criteria->compare('lang_id', $langId);
		$criteria->order = 'sortOrder  ASC';
		$criteria->limit = 3;

		$news = News::model()->findAll($criteria); 

		$criteriavdo = new CDbCriteria;
        $criteriavdo->compare('active','y');
        $criteriavdo->compare('lang_id',$langId);
        $criteriavdo->compare('recommended_status',1);
        

        $Video = Vdo::model()->find($criteriavdo);
        if(!$Video){
        	$criteriavdo = new CDbCriteria;
        	$criteriavdo->compare('active','y');
        	$criteriavdo->compare('lang_id',$langId);
        	$Video = Vdo::model()->find($criteriavdo);
        }
		$this->redirect(array('course/bookingcourse'));
		// $this->render('index',array('label'=>$label,'model'=>$model,'modelCourseTms'=>$modelCourseTms,'modelOrg'=>$modelOrg,'labelCourse' => $labelCourse,'modelCat' => $modelCat, 'course_online'=>$course, 'course_recommend'=>$course_recommend,'news' => $news,'video' => $Video,'msTeams'=>$MsTeams,'useld'=>$_GET['useld']));
		
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
				"Reply-To: {$model->email}\r\n".
				"MIME-Version: 1.0\r\n".
				"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) {
			$model=new LoginForm;

		// if it is ajax validation request
			if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}

		// collect user input data
			if(isset($_POST['LoginForm']))
			{
				$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
				if($model->validate() && $model->login())
					$this->redirect(Yii::app()->user->returnUrl);
			}
		// display the login form
			$this->render('login',array('model'=>$model));
		}else{
			$this->redirect(array('site/index'));	
		}
	}
	

	public function actionAuth(){
		$code = $_GET["code"];
		$session = $_GET["session_state"];
		$this->redirect(array('authapi','code'=>$code));

    }

    public function actionAuthApi($code){
        if(empty($code)){
             $this->redirect('login');
         }

        $token = Helpers::lib()->sendApiAzureCode($code);
        var_dump($token);exit();
        $AzureAD = Helpers::lib()->sendApiAzureToken($token);

        // if($AzureAD->userPrincipalName == null){

        //      Yii::app()->user->setFlash('mailempty','mailnull');
        //      $this->redirect("https://login.microsoftonline.com/42a361ca-9860-439b-ae1e-9794ac0552b0//oauth2/logout?post_logout_redirect_uri=https://learn.ascendcorp.com/site/auth");
        //  }
         // $this->redirect(array('login/index','mailAzure'=>$AzureAD->userPrincipalName,'password' => 'ascendmoney1234'));
        exit();
     }
	 

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	public function actionLinkall()
	{
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
			$langId = Yii::app()->session['lang'] = 1;
		}else{
			$langId = Yii::app()->session['lang'];
		}

		$label = MenuSite::model()->find(array(
			'condition' => 'lang_id=:lang_id',
			'params' => array(':lang_id' => $langId)
		));

		if(!$label){
			$label = MenuSite::model()->find(array(
				'condition' => 'lang_id=:lang_id',
				'params' => array(':lang_id' => 1)
			));
		}
		$this->render('link',array('label'=>$label));
	}

	public function actionDisplayDocument($id)
	{
		$model = Document::model()->find(array('condition' => 'dow_id='.$id)); 
		$exp = explode('.' , $model->dow_address);
		if($model && $exp[count($exp)-1] == 'pdf'){
			$filepath = Yii::app()->basePath.'/../admin/uploads/'.$model->dow_address;
			$file = Yii::app()->basePath.'/../admin/uploads/'.$model->dow_address;
			$filename = $model->dow_address;
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="' . $filename . '"');
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: ' . filesize($file));
			header('Accept-Ranges: bytes');
			@readfile($file);
		}
	}
  //       public function actionTest2(){
  //       $imagemagick = "172.21.81.113/www/ImageMagick/ImageMagick/utilities/";
  //       exec('ping google.com',$str);
  //       var_dump($str);exit();
		// }
	public function actionNotification(){

		$criteria = new CDbCriteria;
		$criteria->with = array('orgCourses');
		    // $criteria->group = 'orgCourses.course_id';
		$criteria->compare('t.active','1');
		$model_cates = CourseNotification::model()->findAll($criteria);
		$i = 0;
		foreach ($model_cates as $key => $model_cate) {
			if($model_cate->orgCourses){
				foreach ($model_cate->orgCourses as $key => $depart) {
		    			// $course[]['course_id'] = $depart->course_id;
		    			// $course[]['notification_time'] = $model_cate->notification_time;
		    			// $course[]['depart'] = $depart->OrgDeparts->depart_id;
					$course[$i] = new StdClass();
					$course[$i]->course_id = $depart->course_id;
		    			$course[$i]->notification_time = $model_cate->notification_time; //day
		    			$course[$i]->depart = $depart->OrgDeparts->depart_id; //Add depart_id
		    			$i++;
		    		}
		    	}
		    	
		    }
		    // exit();
		    
		    $subject = "แจ้งเตือนหลักสูตรกำลังจะหมดอายุ";
		    foreach ($model_cates as $key => $value) {
		    	$course_online = CourseOnline::model()->findByPk($value->course_id);
			    if($course_online->SchedulesAll){ //tms
			    	//Loop Schedules->authen course user_id to array
			    	foreach ($course_online->SchedulesAll as $key => $schedule) {
			    		$course_online->course_date_start = $schedule->training_date_start;
			    		$course_online->course_date_end = $schedule->training_date_end;
			    		//Condition Check Course Expire date
			    		$now = date("Y-m-d h:m:s");
			    		$diff=date_diff(date_create($now),date_create($course_online->course_date_end));
			    		$diff = $diff->format("%R%a");
			    		$diff = (int)$diff;

			    		if($diff == $value->notification_time && $diff >= 0){

			    			$criteria = new CDbCriteria;
			    			$criteria->compare('schedule_id',$schedule->id);
			    			$authCourses = AuthCourse::model()->findAll($criteria);
			    			
			    			foreach ($authCourses as $key => $authenUser) {
			    					// $message = "หลักสูตร ".$course_online->course_title." กำลังจะหมดอายุภายใน ".$value->notification_time." วัน";
			    				$message = "หลักสูตร ".$course_online->course_title." กำลังจะหมดอายุภายในวันที่ ".Helpers::lib()->changeFormatDate($course_online->course_date_end);
			    				Helpers::lib()->SendMailNotificationByUser($subject,$message,$authenUser->user_id);
			    			}
			    		}
			    	}

			    }else{ //lms
			    	$course_online->course_date_start = $course_online->course_date_start;
			    	$course_online->course_date_end = $course_online->course_date_end;

			    	//Perrmission
			    	$depart = array();
			    	foreach ($course_online->orgCourses as $key => $org) {
			    		foreach ($org->OrgDepartsAll as $key => $orgDep) {
			    			$depart[] = $orgDep->depart_id;
			    		}
			    	}
			    	//Condition Check Course Expire date
			    	$now = date("Y-m-d h:m:s");
			    	$diff=date_diff(date_create($now),date_create($course_online->course_date_end));
			    	$diff = $diff->format("%R%a");
			    	$diff = (int)$diff;
			    	
			    	if($diff == $value->notification_time && $diff >= 0){

			    		$criteria = new CDbCriteria;
			    		$criteria->addIncondition('department_id',$depart);
			    		$allUser = Users::model()->findAll($criteria);
			    		
			    		if($allUser){
			    			foreach ($allUser as $key => $user) {
			    				// $message = "หลักสูตร ".$course_online->course_title." กำลังจะหมดอายุภายใน ".$value->notification_time." วัน";
			    				$message = "หลักสูตร ".$course_online->course_title." กำลังจะหมดอายุภายในวันที่ ".Helpers::lib()->changeFormatDate($course_online->course_date_end);
			    				Helpers::lib()->SendMailNotificationByUser($subject,$message,$user->id);
			    			}
			    			
			    		}
			    	}
			    }
			    
			}
		}

		// public function actionTest3(){
		
		// 	$sch = Schedule::model()->findAll();
		// 	foreach ($sch as $key => $value) {
		// 		$data = Helpers::lib()->sendApiLms($value);
		// 		var_dump($data);
		// 	}
		// 	exit();
		
		// }

		public function actionListLdap(){
			if($_GET['key'] == 'dlas5g78drg4dfh54c536wqwk'){
				$data = Helpers::lib()->listDataLdap($_GET['email']);
			}
		}

		// public function actionCheckLdap(){
		// 	echo "<pre>";
		// 	$data = Helpers::lib()->ldapTms($_GET['email']);
		// 	var_dump($data[0]['descripaddresstion'][0]);
		// 	var_dump($data);exit();
		// }

		// public function actionDeb(){
		// 	// $test = array();
		// 	$test = array('count'=>1,0=>"1020194");
		// 	// $test = array(0=>"1020194");
		// 	if($test['count'] > 0){
		// 		var_dump($test[0]);
		// 	}
		// 	exit();
		// }

		// public function actionUpdateUser(){
		// 	$data = Helpers::lib()->_updateUser('akekarakj@airasia.com');
		// 	var_dump($data);exit();
		// }

		// public function actionShowCourse(){
		// 	$period_start = '2018-02-01';
		// 	$criteria = new CDbCriteria;
  //   		$criteria->with = 'Schedules';
		// 	// if(!empty($_GET['year']){
  //   			$criteria->addCondition('course.course_date_start !=  "'.$period_start.'" ');
		// 		$criteria->addCondition('t.create_date >= "'.$period_start.'" ');
		// 		$criteria->addCondition('t.create_date <= "'.$period_start.'" ');
		// 	// }
		// 	$criteria->compare('course.active','y');
		// 	$criteria->compare('course.lang_id',1);
		// 	$criteria->order = 'course.course_id';
		// 	$model = CourseOnline::model()->findAll($criteria);
		// 	foreach ($model as $key => $value) {
		// 		if($i == 5){
		// 			continue;
		// 		}
		// 		// if(empty($value->course_date_start)){ //TMS
		// 		// 	var_dump($value->Schedules->training_date_start);
		// 		// }else{ //LMS
		// 		// 	var_dump($value->course_date_start);
		// 		// }
		// 	}
		// 	exit();
		//}

		// public function actionShowdivision(){
		// 	$criteria = new CDbCriteria;
		// 	$criteria->compare('active','y');
		// 	$model = Division::model()->findAll($criteria);
		// 	var_dump($model);
		// 	exit();
		// }

		// public function actionTestdivision(){
		// 	$modelDivision = Division::model()->findByAttributes(array('div_title'=>'RAMP'));
		// 	var_dump($modelDivision->id);
		// 	exit();
		// }

		// public function actionTest6(){
		// 	$subject = "แจ้งเตือนหลักสูตรกำลังจะหมดอายุ";
		// 	$message = "หลักสูตร ทดสอบ กำลังจะหมดอายุภายใน 10 วัน";
		// 	Helpers::lib()->SendMailNotification($subject,$message,1);
		
		// 	var_dump($courseScore);exit();
		// }

		// public function actionSee(){
		// 	$userModel = User::model()->notsafe()->findAll();
		// 	var_dump($userModel);
		// 	exit();
		// }

		// public function actionEditUser(){
		// 	$userModel = User::model()->notsafe()->findByPk(208);
		// 	// $userModel = User::model()->notsafe()->findByPk(186);
		// 	$userModel->password = 'ca0350e0c22fec3df052298e9a2d9321';
		// 	$userModel->save();
		// 	var_dump($userModel);
		// 	exit();
		// 	// ca0350e0c22fec3df052298e9a2d9321
		// }

		// public function actionEditUserAdmin(){
		// 	$userModel = User::model()->notsafe()->findByPk(1);
		// 	// $userModel = User::model()->notsafe()->findByPk(186);
		// 	$userModel->del_status = 0;
		// 	$userModel->save();
		// 	var_dump($userModel);
		// 	exit();
		// 	// ca0350e0c22fec3df052298e9a2d9321
		// }

		public function actionPermission(){

			//Guntrakon
			// $userModel = User::model()->notsafe()->findByPk(208);
			// $userModel->superuser = 1;
			// $userModel->group = '["7","1"]';
			// $userModel->save();

			// //Chutima Kanjanathammarat
			// $userModel = User::model()->notsafe()->findByPk(201);
			// $userModel->superuser = 1;
			// $userModel->group = '["7","1"]';
			// $userModel->save();

			// //Chaiwat Teejaroensawang
			// $userModel = User::model()->notsafe()->findByPk(207);
			// $userModel->superuser = 1;
			// $userModel->group = '["7","1"]';
			// $userModel->save();

			//Taa
			$userModel = User::model()->notsafe()->findByPk(167);
			$userModel->superuser = 1;
			$userModel->group = '["7","1"]';
			$userModel->save();

			// $userModel2 = User::model()->findByPk(167);
			// var_dump($userModel2);
			exit();
		}

		// public function actionTestscore(){
		// 		$manage = Manage::Model()->with('question')->findAll("id=:id AND type=:type AND question.ques_type<>3 AND manage.active='y'",
	 //                array("id" => 114,"type" => 'post'));

	 //        if($manage){
	 //            $criteria=new CDbCriteria;
	 //            $criteria->condition = "ques_type <> :ques_type";
	 //            $criteria->params = array (
	 //            ':ques_type' => 3,
	 //            );
	 //            $criteria->compare('user_id',1);
	 //            $criteria->compare('active',"y");
	 //            $criteria->compare('lesson_id',114);
	 //            $criteria->compare('type',"post");
	 //            $score1 = Score::model()->findAll($criteria);
	 //            $count_score = count($score1);
	 //        }
	 //        if($manage){
	 //            $scorePass = array();
	 //            foreach ($score1 as $key => $value) {
	 //            	$scorePass[] = $value->score_past;
	 //            }
	 //        }

	 //        if(in_array("y", $scorePass)){
	 //        	// return true;
	 //        	var_dump("true");
	 //        }else{
	 //        	if($count_score < 2){
	 //        		// return true;
	 //        		var_dump("true");
	 //        	}else{
	 //        		// return false;
	 //        		var_dump("false");
	 //        	}
	 //        }
		
		// }

		// public function actionTesttoken(){
		// 	$token = UserModule::encrypting(time());
		// 	var_dump($token);
		// }

		// public function actionTestTime(){
		// 	echo date('Y-m-d H:i:s');
		// 	echo '<br>';
		// 	echo date_default_timezone_get();
		// 	$sql = "SELECT NOW()";
		// 	$list = Yii::app()->db->createCommand($sql)->queryAll();
		// 	var_dump($list);
		// }
		function casttoclass($class, $object)
		{
		return unserialize(preg_replace('/^O:\d+:"[^"]++"/', 'O:' . strlen($class) . ':"' . $class . '"', serialize($object)));
		}

		private function lastViset()
		{
			$lastVisit = Users::model()->notsafe()->findByPk(Yii::app()->user->id);
			$lastVisit->lastvisit_at = date("Y-m-d H:i:s", time());
			$lastVisit->online_status = '1';
			$lastVisit->save(false);
		}
	
		private function saveToken()
		{
			$lastVisit = Users::model()->notsafe()->findByPk(Yii::app()->user->id);
			$token = UserModule::encrypting(time());
			$lastVisit->avatar = $token;
			//Set cookie token for login
			$time = time() + 7200; //1 hr.
			$cookie = new CHttpCookie('token_login', $token); //set value
			$cookie->expire = $time;
			Yii::app()->request->cookies['token_login'] = $cookie;
			$lastVisit->save(false);
		}
	}