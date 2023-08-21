<?php

class ApiController extends Controller
{
	Const APPLICATION_ID = 'ASCCPE';

    /**
     * Default response format
     * either 'json' or 'xml'
     */
    private $format = 'json';
    /**
     * @return array action filters
     */
    public function filters()
    {
    	return array();
    }

    // Actions
    public function actionList()
    {
    	switch($_GET['model'])
    	{
    		case 'register':
    		$models = Post::model()->findAll();
    		break;
    		default:
            // Model not implemented error
    		$this->_sendResponse(501, sprintf(
    			'Error: Mode <b>list</b> is not implemented for model <b>%s</b>',
    			$_GET['model']) );
    		Yii::app()->end();
    	}
    	// Did we get some results?
    	if(empty($models)) {
        // No
    		$this->_sendResponse(200, 
    			sprintf('No items where found for model <b>%s</b>', $_GET['model']) );
    	} else {
        // Prepare response
    		$rows = array();
    		foreach($models as $model)
    			$rows[] = $model->attributes;
        // Send the response
    		$this->_sendResponse(200, CJSON::encode($rows));
    	}
    }
    public function actionView()
    {
    	if(!isset($_GET['id']))
    		$this->_sendResponse(500, 'Error: Parameter <b>id</b> is missing' );

    	switch($_GET['model'])
    	{
        // Find respective model    
    		case 'register':
    		$model = Post::model()->findByPk($_GET['id']);
    		break;
    		default:
    		$this->_sendResponse(501, sprintf(
    			'Mode <b>view</b> is not implemented for model <b>%s</b>',
    			$_GET['model']) );
    		Yii::app()->end();
    	}
    	// Did we find the requested model? If not, raise an error
    	if(is_null($model))
    		$this->_sendResponse(404, 'No Item found with id '.$_GET['id']);
    	else
    		$this->_sendResponse(200, CJSON::encode($model));
    }

    public function actionCreate()
    {
    	$json = file_get_contents('php://input'); //$GLOBALS['HTTP_RAW_POST_DATA'] is not preferred: http://www.php.net/manual/en/ini.core.php#ini.always-populate-raw-post-data
    	$_POST = CJSON::decode($json,true);
    	$response['result'] = true;
      $this->_checkKey($_POST['key']);
      $this->saveLogApi($_POST['schedule']['schedule_id'],$this->get_client_ip(),Yii::app()->controller->action->id,$json);
      switch($_GET['model'])
      {
        case 'register':
        $modelSchedule = new Schedule; 
        case 'course':
        $modelCourseOnline = new CourseOnline; 
        break;
        default:
        $response['result'] = false;
        $response['msg'] =  sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var,$_GET['model']);
        $this->_sendResponse(500, CJSON::encode($response));
        Yii::app()->end();
      }
      $modelCourse = CourseOnline::model()->findByAttributes(array('course_number' => $_POST['course_id']));
      if($_GET['model'] == 'course'){
        if(!$modelCourse){
          $modelCourse = new CourseOnline;
          $modelCourse->cate_id = 1;
          $modelCourse->course_number = $_POST['course_id'];
          $modelCourse->course_title = $_POST['course_title'];
          $modelCourse->course_detail = $_POST['course_outline'];
          $modelCourse->update_date = date("Y-m-d H:i:s");
          $modelCourse->create_date = date("Y-m-d H:i:s");
          //Get user
          if(isset($_POST['created_by'])){
            $user_id =  Helpers::lib()->seachUser($_POST['created_by']); //$_POST['create_by'] = email
            $modelCourse->create_by = $user_id;
          }
          $modelCourse->save(false);
        } else {
          $response['result'] = false;
          $response['msg'] =  sprintf('Course ID "%s" is Duplicate', $_POST['course_id']);
        }
      } else if($_GET['model'] == 'register'){
        $modelSchedule = Schedule::model()->findByAttributes(array('schedule_id' => $_POST['schedule']['schedule_id']));
        if(!$modelSchedule){
          $modelSchedule = new Schedule;
          foreach($_POST['schedule'] as $var=>$value) {
           if($modelSchedule->hasAttribute($var))
            $modelSchedule->$var = $value;
          else{
            $response['result'] = false;
            $response['msg'] =  sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var,$_GET['model']);
          }
        }
        $modelSchedule->course_id = $modelCourse->course_id;
        if($modelSchedule->training_date_start == $modelSchedule->training_date_end){
          $modelSchedule->training_date_end = strtotime($modelSchedule->training_date_end.' + 23 hour + 59 minute');
          $modelSchedule->training_date_end = date('Y-m-d H:i:s', $modelSchedule->training_date_end);
        }
        if($modelSchedule->save()){
         foreach($_POST['member'] as $var=>$value) {
          $modelUser = User::model()->findByAttributes(array('email'=>$value['user']['email'],'del_status' => '0'));
          if(!$modelUser){
           $modelUser = new User;
           $modelProfile = new Profile;
           foreach ($value['user'] as $key => $user) {
            if($modelUser->hasAttribute($key))
             $modelUser->$key = $user;
           else{
             $response['result'] = false;
             $response['msg'] =  sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var,$_GET['model']);
           }
         }
         $modelUser->type_register = 3;
         $modelUser->password = md5($value['user']['username']);
         $modelUser->status = 1;
         if($modelUser->save(false)){
          $modelProfile->user_id = $modelUser->id;
        } else {
          $response['result'] = false;
        }
        foreach ($value['profile'] as $key => $profile) {
          if($modelProfile->hasAttribute($key))
           $modelProfile->$key = $profile;
         else{
           $response['result'] = false;
           $response['msg'] =  sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var,$_GET['model']);
         }
       }

       if(!$modelProfile->save(false)){
        $response['result'] = false;
      }
    } else {
      $modelUser->type_register = 3;
      $modelUser->save(false);
    }
    $criteria = new CDbCriteria;
    $criteria->with = array('user');
    $criteria->compare('user.username',$value['user']['username']);
    $criteria->compare('schedule_id',$modelSchedule->id);
    $modelAuthCourse = AuthCourse::model()->find($criteria);
    if(!$modelAuthCourse){
     $modelAuthCourse = new AuthCourse;
     $modelAuthCourse->user_id = $modelUser->id;
     $modelAuthCourse->course_id = $modelCourse->course_id;
     $modelAuthCourse->schedule_id = $modelSchedule->id;
     $modelAuthCourse->register_date = $value['register_date'];
     $modelAuthCourse->created = new CDbExpression('NOW()');
     if(!$modelAuthCourse->save()){
      $response['result'] = false;
    }
  }
}
} else {
 $msg = "<h1>Error</h1>";
 $msg .= sprintf("Couldn't create model <b>%s</b>", $_GET['model']);
 $msg .= "<ul>";
 foreach($modelSchedule->errors as $attribute=>$attr_errors) {
  $msg .= "<li>Attribute: $attribute</li>";
  $msg .= "<ul>";
  foreach($attr_errors as $attr_error)
   $msg .= "<li>$attr_error</li>";
 $msg .= "</ul>";
}
$msg .= "</ul>";
$response['msg'] = $msg;
$response['result'] = false;
}
} else {
  if($modelSchedule && $modelCourse){
    $modelCourse->course_number = $_POST['course_id'];
    $modelCourse->course_title = $_POST['course_title'];
    $modelCourse->save(false);
    AuthCourse::model()->deleteAll(array('condition' => 'schedule_id='.$modelSchedule->id));
    // AuthCourse::model()->deleteAll(array('condition' => 'schedule_id='.$_POST['schedule']['schedule_id']));
  }
  foreach($_POST['schedule'] as $var=>$value) {
    if($modelSchedule->hasAttribute($var))
      $modelSchedule->$var = $value;
    else{
      $response['result'] = false;
      $response['msg'] =  sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var,$_GET['model']);
    }
  }
  if($modelSchedule->training_date_start == $modelSchedule->training_date_end){
          $modelSchedule->training_date_end = strtotime($modelSchedule->training_date_end.' + 23 hour + 59 minute');
          $modelSchedule->training_date_end = date('Y-m-d H:i:s', $modelSchedule->training_date_end);
    }
  if($modelSchedule->save()){
    foreach($_POST['member'] as $var=>$value) {
      $modelUser = User::model()->findByAttributes(array('email'=>$value['user']['email'],'del_status' => '0'));
      if(!$modelUser){
        $modelUser = new User;
        $modelProfile = new Profile;
        foreach ($value['user'] as $key => $user) {
          if($modelUser->hasAttribute($key))
            $modelUser->$key = $user;
          else{
            $response['result'] = false;
            $response['msg'] =  sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var,$_GET['model']);
          }
        }
        $modelUser->password = md5($value['user']['username']);
        if($modelUser->save(false)){
          $modelProfile->user_id = $modelUser->id;
        } else {
          $response['result'] = false;
        }
        foreach ($value['profile'] as $key => $profile) {
          if($modelProfile->hasAttribute($key))
            $modelProfile->$key = $profile;
          else{
            $response['result'] = false;
            $response['msg'] =  sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var,$_GET['model']);
          }
        }

        if(!$modelProfile->save(false)){
          $response['result'] = false;
          $response['msg'] = "Error: Can't not insert Profile";
        }
      } else {
        $modelUser->type_register = 3;
        $modelUser->save(false);
      }
      $criteria = new CDbCriteria;
      $criteria->with = array('user');
      $criteria->compare('user.username',$value['user']['username']);
      $criteria->compare('schedule_id',$modelSchedule->id);
      $modelAuthCourse = AuthCourse::model()->find($criteria);
      if(!$modelAuthCourse){
        $modelAuthCourse = new AuthCourse;
        $modelAuthCourse->user_id = $modelUser->id;
        $modelAuthCourse->course_id = $modelCourse->course_id;
        $modelAuthCourse->schedule_id = $modelSchedule->id;
        $modelAuthCourse->register_date = $value['register_date'];
        $modelAuthCourse->created = new CDbExpression('NOW()');
        if(!$modelAuthCourse->save()){
          $response['result'] = false;
          $response['msg'] = "Error: Can't not insert AuthCourse";
        }
      }
    }
  }
}

  // $response['result'] = false;
  // $response['msg'] = 'Error:Duplicate Schedule';
}

if($response['result']){
  $this->_sendResponse(200, CJSON::encode($response));
} else {
  $response['result'] = false;
  $this->_sendResponse(500, CJSON::encode($response));
}
}

public function actionUpdate()
{

    	// Parse the PUT parameters. This didn't work: parse_str(file_get_contents('php://input'), $put_vars);
    $json = file_get_contents('php://input'); //$GLOBALS['HTTP_RAW_POST_DATA'] is not preferred: http://www.php.net/manual/en/ini.core.php#ini.always-populate-raw-post-data
    $put_vars = CJSON::decode($json,true);	//true means use associative array
    $response['result'] = true;
    $this->_checkKey($put_vars['key']);
    switch($_GET['model'])
    {
        // Find respective model
    	case 'register':
    	$modelSchedule = Schedule::model()->findByAttributes(array('schedule_id' => $put_vars['schedule']['schedule_id']));
      $modelCourse = CourseOnline::model()->findByPk($modelSchedule->course->course_id);                  
      break;
      case 'course':
      $modelCourse = CourseOnline::model()->findByAttributes(array('course_number' => $put_vars['course_id']));
      break;
      default:
      $this->_sendResponse(501, 
        sprintf( 'Error: Mode <b>update</b> is not implemented for model <b>%s</b>',
         $_GET['model']) );
      Yii::app()->end();
    }
    $this->saveLogApi($put_vars['schedule']['schedule_id'],$this->get_client_ip(),Yii::app()->controller->action->id,$json);
    // Did we find the requested model? If not, raise an error
    
    if($_GET['model'] == 'course'){
      if($modelCourse === null)
      $this->_sendResponse(400, 
        sprintf("Error: Didn't find any model '%s' with ID '%s'.",
          'Course', $put_vars['course_id']) );

      $modelCourse->cate_id = 1;
      $modelCourse->course_number = $put_vars['course_id'];
      $modelCourse->course_title = $put_vars['course_title'];
      $modelCourse->course_detail = $put_vars['course_outline'];
      $modelCourse->create_date = date("Y-m-d H:i:s");
      $modelCourse->update_date = date("Y-m-d H:i:s");
      $modelCourse->save(false);
    } else if($_GET['model'] == 'register'){
      if($modelSchedule === null)
       $this->_sendResponse(400, 
        sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.",
         'Schedule', $put_vars['schedule']['schedule_id']) );

     if($modelCourse === null)
      $this->_sendResponse(400, 
        sprintf("Error: Didn't find any model '%s' with ID '%s'.",
          'Course', $put_vars['course_id']) );

     if($modelSchedule && $modelCourse){
      $modelCourse->course_number = $put_vars['course_id'];
      $modelCourse->course_title = $put_vars['course_title'];
      $modelCourse->save(false);
      AuthCourse::model()->deleteAll(array('condition' => 'schedule_id='.$modelSchedule->id));
      // AuthCourse::model()->deleteAll(array('condition' => 'schedule_id='.$put_vars['schedule']['schedule_id']));
    }
    foreach($put_vars['schedule'] as $var=>$value) {
      if($modelSchedule->hasAttribute($var))
        $modelSchedule->$var = $value;
      else{
        $response['result'] = false;
        $response['msg'] =  sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var,$_GET['model']);
      }
    }
    if($modelSchedule->training_date_start == $modelSchedule->training_date_end){
          $modelSchedule->training_date_end = strtotime($modelSchedule->training_date_end.' + 23 hour + 59 minute');
          $modelSchedule->training_date_end = date('Y-m-d H:i:s', $modelSchedule->training_date_end);
        }
    if($modelSchedule->save()){
      foreach($put_vars['member'] as $var=>$value) {
        $modelUser = User::model()->findByAttributes(array('email'=>$value['user']['email'],'del_status' => '0'));
        if(!$modelUser){
          $modelUser = new User;
          $modelProfile = new Profile;
          foreach ($value['user'] as $key => $user) {
            if($modelUser->hasAttribute($key))
              $modelUser->$key = $user;
            else{
              $response['result'] = false;
              $response['msg'] =  sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var,$_GET['model']);
            }
          }
          $modelUser->password = md5($value['user']['username']);
          $modelUser->type_register = 3;
          if($modelUser->save(false)){
            $modelProfile->user_id = $modelUser->id;
          } else {
            $response['result'] = false;
          }
          foreach ($value['profile'] as $key => $profile) {
            if($modelProfile->hasAttribute($key))
              $modelProfile->$key = $profile;
            else{
              $response['result'] = false;
              $response['msg'] =  sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var,$_GET['model']);
            }
          }

          if(!$modelProfile->save(false)){
            $response['result'] = false;
          }
        } else {
          $modelUser->type_register = 3;
          $modelUser->save(false);
        }
        $criteria = new CDbCriteria;
        $criteria->with = array('user');
        $criteria->compare('user.email',$value['user']['email']);
        $criteria->compare('schedule_id',$modelSchedule->id);
        $modelAuthCourse = AuthCourse::model()->find($criteria);
        if(!$modelAuthCourse){
          $modelAuthCourse = new AuthCourse;
          $modelAuthCourse->user_id = $modelUser->id;
          $modelAuthCourse->course_id = $modelCourse->course_id;
          $modelAuthCourse->schedule_id = $modelSchedule->id;
          $modelAuthCourse->register_date = $value['register_date'];
          $modelAuthCourse->created = new CDbExpression('NOW()');
          if(!$modelAuthCourse->save()){
            $response['result'] = false;
          }
        }
      }
    }
  }
  if($response['result'] == 'true'){
    $this->_sendResponse(200, CJSON::encode($response));
  } else {
    $response['result'] = false;
    $this->_sendResponse(500, CJSON::encode($response));
  }
}
public function actionDelete()
{
    $json = file_get_contents('php://input'); //$GLOBALS['HTTP_RAW_POST_DATA'] is not preferred: http://www.php.net/manual/en/ini.core.php#ini.always-populate-raw-post-data
    $del_vars = CJSON::decode($json,true);
    $this->_checkKey($del_vars['key']);
    $this->saveLogApi($del_vars['schedule_id'],$this->get_client_ip(),Yii::app()->controller->action->id,$json);
    switch($_GET['model'])
    {
        // Load the respective model
      case 'register':
      $model = Schedule::model()->findByAttributes(array('schedule_id'=>$del_vars['schedule_id']));                    
      break;
      default:
      $this->_sendResponse(501, 
       sprintf('Error: Mode <b>delete</b> is not implemented for model <b>%s</b>',
        $_GET['model']) );
      Yii::app()->end();
    }
    // Was a model found? If not, raise an error
    if($model === null)
      $this->_sendResponse(400, 
       sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.",
        $_GET['model'], $_GET['id']) );

    // Delete the model
    $num = $model->delete();
    if($num>0){
      $response['result'] = true;
      $this->_sendResponse(200, CJSON::encode($response));
    }
    else
     $this->_sendResponse(500, 
      sprintf("Error: Couldn't delete model <b>%s</b> with ID <b>%s</b>.",
       $_GET['model'], $_GET['id']) );
 }

 protected function get_client_ip() {
  $ipaddress = '';
  if (getenv('HTTP_CLIENT_IP'))
    $ipaddress = getenv('HTTP_CLIENT_IP');
  else if(getenv('HTTP_X_FORWARDED_FOR'))
    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
  else if(getenv('HTTP_X_FORWARDED'))
    $ipaddress = getenv('HTTP_X_FORWARDED');
  else if(getenv('HTTP_FORWARDED_FOR'))
    $ipaddress = getenv('HTTP_FORWARDED_FOR');
  else if(getenv('HTTP_FORWARDED'))
   $ipaddress = getenv('HTTP_FORWARDED');
 else if(getenv('REMOTE_ADDR'))
  $ipaddress = getenv('REMOTE_ADDR');
else
  $ipaddress = 'UNKNOWN';
return $ipaddress;
}

protected function saveLogApi($schedule_id,$log_api,$log_event,$log_data){
  $logApi = new LogApi;
  $logApi->schedule_id = $schedule_id;
  $logApi->log_ip = $log_api;
  $logApi->log_event = $log_event;
  $logApi->log_data = $log_data;
  $logApi->log_date = date("Y-m-d H:i:s");
  if(!$logApi->save())var_dump($logApi->getErrors());
}

public function actionLoginLms(){
  // $mm = '{
  //   "username":"e53",
  //   "email":"ทดสอบ",
  //   "firstname":"1",
  //   "lastname":"2018-02-1",
  //   "key":"de7e13f6-02ec-4ddf-bace-009a53289d7f"
  // }';

  // $str = 'username/admin/email/parichat1@1bangkokwebsolution.com/firstname/aaa/lastname/bbb/key/de7e13f6-02ec-4ddf-bace-009a53289d7f';
  // $encode = base64_encode($mm);
  $decode = base64_decode($_GET['title']);
  $json_var = CJSON::decode($decode,true);
    // var_dump($decode);
  $this->_checkKeyLogin($json_var['key']);
  switch($_GET['model'])
  {
        // Load the respective model
    case 'loginlms':
    $modelUser = User::model()->notsafe()->findByAttributes(array('username'=>$json_var['username']));             
    break;
    default:
    $this->_sendResponse(501, 
     sprintf('Error: Mode <b>delete</b> is not implemented for model <b>%s</b>',
      $_GET['model']) );
    Yii::app()->end();
  }

  $modelUserLogin = new UserLoginLms;
  if(!$modelUser){
    $modelUser = new User;
    $modelProfile = new Profile;
    $modelUser->username = $json_var['username'];
    $modelUser->email = $json_var['email'];
    $modelUser->status = 1;
    $modelUser->password = md5($_GET['username']);
    $modelUser->type_register = 3;
    if($modelUser->save(false)){
      $modelProfile->user_id = $modelUser->id;
    } else {
      $response['result'] = false;
    }
    $modelProfile->firstname = $json_var['firstname'];
    $modelProfile->lastname = $json_var['lastname'];
    if(!$modelProfile->save(false)){
      $response['result'] = false;
    }
  }
  $modelUserLogin->email=$json_var['email'];
  $modelUserLogin->username=$modelUser->username;
  if($modelUserLogin->validate()) {
    $this->lastViset();
    Yii::app()->user->setReturnUrl(Yii::app()->request->urlReferrer);
    if(Yii::app()->user->id){
      Helpers::lib()->getControllerActionId();
    }
    $rs = "เข้าสู่ระบบสำเร็จ";
    $modelCourse = Schedule::model()->findByAttributes(array("schedule_id" => $json_var['schedule_id']));
    if($modelCourse){
      $this->redirect(array('course/detail',"id"=>$modelCourse->course->course_id,"msg" => $rs));
    }
    // $this->redirect(Yii::app()->user->returnUrl);
  } else {
    $error = $modelUserLogin->getErrors();
    foreach ($error as $key => $value) {
      $rs .= $value[0];
    }
  }
  $this->redirect(array('site/index','msg'=>$rs));
}

private function lastViset() {
  $lastVisit = Users::model()->notsafe()->findByPk(Yii::app()->user->id);
  $lastVisit->lastvisit_at = date("Y-m-d H:i:s",time()) ;
  $lastVisit->online_status = '1';
  $lastVisit->save(false);
}

protected function beforeSave()
{
    // author_id may have been posted via API POST
	if(is_null($this->author_id) or $this->author_id=='')
		$this->author_id=Yii::app()->user->id;
}

private function _sendResponse($status = 200, $body = '', $content_type = 'text/html')
{
    // set the status
	$status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
	header($status_header);
    // and the content type
	header('Content-type: ' . $content_type);

    // pages with body are easy
	if($body != '')
	{
        // send the body
		echo $body;
	}
    // we need to create the body if none is passed
	else
	{
        // create some body messages
		$message = '';

        // this is purely optional, but makes the pages a little nicer to read
        // for your users.  Since you won't likely send a lot of different status codes,
        // this also shouldn't be too ponderous to maintain
		switch($status)
		{
			case 401:
			$message = 'You must be authorized to view this page.';
			break;
			case 404:
			$message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
			break;
			case 500:
			$message = 'The server encountered an error processing your request.';
			break;
			case 501:
			$message = 'The requested method is not implemented.';
			break;
		}

        // servers don't always have a signature turned on 
        // (this is an apache directive "ServerSignature On")
		$signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

        // this should be templated in a real-world solution
		$body = '
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
		</head>
		<body>
		<h1>' . $this->_getStatusCodeMessage($status) . '</h1>
		<p>' . $message . '</p>
		<hr />
		<address>' . $signature . '</address>
		</body>
		</html>';

		echo $body;
	}
	Yii::app()->end();
}

private function _getStatusCodeMessage($status)
{
    // these could be stored in a .ini file and loaded
    // via parse_ini_file()... however, this will suffice
    // for an example
	$codes = Array(
		200 => 'OK',
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
	);
	return (isset($codes[$status])) ? $codes[$status] : '';
}

private function _checkKey($key){
  $response = array();
  if($key != '09082174-6a9b-45b7-bc8d-090e07bc91b6'){
    $response['result'] = false;
    $response['msg'] = 'Error: Incorrect keys';
    $this->_sendResponse(401, CJSON::encode($response));
  }
}

private function _checkKeyLogin($key){
  $response = array();
  if($key != 'de7e13f6-02ec-4ddf-bace-009a53289d7f'){
    $response['result'] = false;
    $response['msg'] = 'Error: Incorrect keys';
    $this->_sendResponse(401, CJSON::encode($response));
  }
}

private function _checkAuth()
{
    // Check if we have the USERNAME and PASSWORD HTTP headers set?
	if(!(isset($_SERVER['HTTP_X_USERNAME']) and isset($_SERVER['HTTP_X_PASSWORD']))) {
        // Error: Unauthorized
		$this->_sendResponse(401);
	}
	$username = $_SERVER['HTTP_X_USERNAME'];
	$password = $_SERVER['HTTP_X_PASSWORD'];
    // Find the user
	$user=User::model()->find('LOWER(username)=?',array(strtolower($username)));
	if($user===null) {
        // Error: Unauthorized
		$this->_sendResponse(401, 'Error: User Name is invalid');
	} else if(!$user->validatePassword($password)) {
        // Error: Unauthorized
		$this->_sendResponse(401, 'Error: User Password is invalid');
	}
}
}