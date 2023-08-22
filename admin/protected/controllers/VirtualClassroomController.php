<?php

class VirtualClassroomController extends Controller
{
	public function init()
	{
		// parent::init();
		// $this->lastactivity();
		if(Yii::app()->user->id == null){
				$this->redirect(array('site/index'));
			}
		
	}
	private function RandomPassword(){

			$number="abcdefghijklmnopqrstuvwxyz0123456789";
			$i = '';
			$result = '';
		for($i==1;$i<8;$i++){ // จำนวนหลักที่ต้องการสามารถเปลี่ยนได้ตามใจชอบนะครับ จาก 5 เป็น 3 หรือ 6 หรือ 10 เป็นต้น
			$random=rand(0,strlen($number)-1); //สุ่มตัวเลข
			$cut_txt=substr($number,$random,1); //ตัดตัวเลข หรือ ตัวอักษรจากตำแหน่งที่สุ่มได้มา 1 ตัว
			$result.=substr($number,$random,1); // เก็บค่าที่ตัดมาแล้วใส่ตัวแปร
			$number=str_replace($cut_txt,'',$number); // ลบ หรือ แทนที่ตัวอักษร หรือ ตัวเลขนั้นด้วยค่า ว่าง
		}

		return $result;

	}

	public function actionCreate()
	{
		$model = new VRoom;

		if(isset($_POST['VRoom']))
		{
			$model->attributes=$_POST['VRoom'];
			$model->attendeePw=md5('attendeePw'.date('YmdHis'));
			$model->moderatorPw=md5('moderatorPw'.date('YmdHis'));
            $model->number_learn = $_POST['VRoom']['number_learn'];
			$model->status_key = 1;
			if($model->status_key == '1'){
			$gen_key = $this->RandomPassword();
			$model->show_key = $gen_key;
			$model->ckeck_key = UserModule::encrypting($gen_key);
			}

			if($_POST['optradio'] == 1){
			$model->user_learn = 'all';
			}

			if($_POST['optradio'] == 2){

			$User_learn_arr = array();
			foreach (json_decode($_POST['datasetdirector']) as $key => $value) {
				array_push($User_learn_arr, [
					'ul' => $value[3],
				]);
			}

			$json_UserLearn = json_encode($User_learn_arr);
			$model->user_learn = $json_UserLearn;
			}

			$model->save();
			$time = date("dmYHis");
			$pic_vroom = CUploadedFile::getInstance($model, 'pic_vroom');
        
			if(!empty($pic_vroom)){
				$fileNamePicture = $time."_Picture.".$pic_vroom->getExtensionName();
				$model->pic_vroom = $fileNamePicture;
			}

			if(!empty($pic_vroom))
					{
						/////////// SAVE IMAGE //////////
						Yush::init($model);

						$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->pic_vroom);
						$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->pic_vroom);
						$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->pic_vroom);
			           // Save the original resource to disk
						$pic_vroom->saveAs($originalPath);
						$size = getimagesize($originalPath);
						if (isset($size)) {
			             	// Create a small image
							$smallImage = Yii::app()->phpThumb->create($originalPath);
							$smallImage->resize(358,300);
							$smallImage->save($smallPath);

			            // Create a thumbnail
							$thumbImage = Yii::app()->phpThumb->create($originalPath);
							$thumbImage->resize(900);
							$thumbImage->save($thumbPath);
						} else {
							unlink($originalPath);
							$model->delete();
							$notsave = 1;
							$this->render('create',array(
								'model'=>$model,'notsave'=>$notsave));
						}
					}
			if($model->save() == true){

			$model_log = new Vroomlogmail;
			if($_POST['optradio'] == 2){

			$user_learn_select = [];
            foreach (json_decode($_POST['datasetdirector']) as $key => $value) {
                array_push($user_learn_select, [
                    'user_id' => $value[3]
                ]);
            }
			$json_user = json_encode($user_learn_select);
			
			$model_log->vroom__id = $model->id;
			$model_log->key_mail = $model->show_key;
			$model_log->logmail_user = $json_user;
			$model_log->save();

						// foreach (json_decode($_POST['datasetdirector']) as $key => $value) {

						// 	$criteria = new CDbCriteria;
						// 	$criteria->compare('id',$value[3]);
						// 	$user = User::model()->find($criteria);
						// 	$email = $user->email;
						// 	$user_id = $user->id;

						// 	$to = array(
						// 		'email'=>$email,
						// 		'firstname'=>$user->profile->firstname,
						// 		'lastname'=>$user->profile->lastname,
						// 	);
						// 	$nameshow = $user->profile->firstname." ".$user->profile->lastname;
						// 	$message = $this->renderPartial('mail_key',array('key'=>$gen_key,'name_vroom'=>$model->name,'nameshow'=>$nameshow),true);
						// 	$typemail = 'vroom';
						// 	$mail = Helpers::lib()->SendMail($to,'รหัสเข้าห้องเรียน',$message,$typemail);   
						// }

            }
              $this->redirect(array('index'));      
            }
			$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
	
		if(isset($_POST['VRoom']))	
		{   
			$model->attributes=$_POST['VRoom'];
			$model->status_key = 1;
			$model->number_learn = $_POST['VRoom']['number_learn'];

			if($model->status_key == '0'){
			$model->ckeck_key = null;
			}
			if ($model->ckeck_key == null) {
			$gen_key = $this->RandomPassword();
			$model->show_key = $gen_key;
			$model->ckeck_key = UserModule::encrypting($gen_key);
			} 

			if($_POST['optradio'] == 1){
			$model->user_learn = 'all';
			}
			if($_POST['optradio'] == 2){

			$User_learn_arr = array();

			foreach (json_decode($_POST['datasetdirector']) as $key => $value) {
				array_push($User_learn_arr, [
					'ul' => $value[3],
				]);
			}
			$json_UserLearn = json_encode($User_learn_arr);
			$model->user_learn = $json_UserLearn;
			}	
 
			$time = date("dmYHis");
			$pic_vroom = CUploadedFile::getInstance($model, 'pic_vroom');
  
			if(!empty($pic_vroom) || $pic_vroom != null){
				$fileNamePicture = $time."_Picture.".$pic_vroom->getExtensionName();
				if ($fileNamePicture) {
					$model->pic_vroom = $fileNamePicture;
				}
				
			}
			else{
				$vroom = VRoom::model()->findByPk($model->id);
				$model->pic_vroom = $vroom->pic_vroom;
			}

			if(!empty($pic_vroom))
					{
						
						if (is_file($webroot.$model->id)) {
							 unlink($webroot.$model->id);
						}						
						/////////// SAVE IMAGE //////////
						Yush::init($model);

						$originalPath = Yush::getPath($model, Yush::SIZE_ORIGINAL, $model->pic_vroom);
						$thumbPath = Yush::getPath($model, Yush::SIZE_THUMB, $model->pic_vroom);
						$smallPath = Yush::getPath($model, Yush::SIZE_SMALL, $model->pic_vroom);
			           // Save the original resource to disk
						$pic_vroom->saveAs($originalPath);
						$size = getimagesize($originalPath);
						if (isset($size)) {
			             	// Create a small image
							$smallImage = Yii::app()->phpThumb->create($originalPath);
							$smallImage->resize(358,300);
							$smallImage->save($smallPath);

			            // Create a thumbnail
							$thumbImage = Yii::app()->phpThumb->create($originalPath);
							$thumbImage->resize(900);
							$thumbImage->save($thumbPath);
						} 
						// else {
						// 	unlink($originalPath);
						// 	$model->delete();
						// 	$notsave = 1;
						// 	$this->render('update',array(
						// 		'model'=>$model,'notsave'=>$notsave));
						// }
					}
					
			$model->save();
			if($model->save() == true){
			$model_log = Vroomlogmail::model()->findByAttributes(array('vroom__id'=>$model->id));
			if ($model_log != NULL) {
			if($_POST['optradio'] == 2){

			$user_learn_select = [];
            foreach (json_decode($_POST['datasetdirector']) as $key => $value) {
                array_push($user_learn_select, [
                    'user_id' => $value[3]
                ]);
            }
			$json_user = json_encode($user_learn_select);
			$model_log->vroom__id = $model->id;
			$model_log->key_mail = $model->show_key;
			$model_log->logmail_user = $json_user;
			
			$model_log->save();
            }
              $this->redirect(array('index'));      
            }else{

            $model_log = new Vroomlogmail;
			if($_POST['optradio'] == 2){

			$user_learn_select = [];
            foreach (json_decode($_POST['datasetdirector']) as $key => $value) {
                array_push($user_learn_select, [
                    'user_id' => $value[3]
                ]);
            }
			$json_user = json_encode($user_learn_select);
			
			$model_log->vroom__id = $model->id;
			$model_log->key_mail = $model->show_key;
			$model_log->logmail_user = $json_user;
			$model_log->save();
            }
              $this->redirect(array('index'));
            }
            }

			$this->redirect(array('index'));
		    }

		$this->render('update',array(
			'model'=>$model
		));
	    }
   


	public function actionDelete($id)
	{
		//$this->loadModel($id)->delete();

	    $model = $this->loadModel($id);
	    $model->active = 'n';
 		$model->save(false);
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	public function actionMultiDelete()
	{	
		//header('Content-type: application/json');
		if(isset($_POST['chk'])) {
	        foreach($_POST['chk'] as $val) {
	            $this->actionDelete($val);
	        }
	    }
	}

	public function actionIndex()
	{
		
		/*$bbb=Yii::app()->bigbluebutton;
		try 
		{
		    $url=$bbb->createApiQuery("getMeetings");
		    $data=$bbb->getApiResponse($url);
		    CVarDumper::dump($data, 10, 1);
		} catch (BigBlueButtonException $ex)
		{
		    //remember to properly handle exception if something goes wrong
		    throw $ex;
		}*/
		
		$model=new VRoom('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['VRoom']))
			$model->attributes=$_GET['VRoom'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionRoomStatus($id)
	{
		require_once Yii::app()->basePath . '/extensions/virtualclassroomapi/includes/bbb-api.php';
		$bbb = new BigBlueButton();

		$room = Vroom::model()->findByPk($id);
		$meetingId = $room->id;
		$password = $room->moderatorPw;
		// Get the URL to join meeting:
		$itsAllGood = true;

		$infoParams = array(
			'meetingId' => $meetingId,		
			'password' => $password		
		);

		try {$result = $bbb->getMeetingInfoUrl($infoParams);}
			catch (Exception $e) {
				echo 'Caught exception: ', $e->getMessage(), "\n";
				$itsAllGood = false;
			}

		if ($itsAllGood == true) {
			//Output results to see what we're getting:
			print_r($result);
		}
			
		return $model;
	}

	public function actionCreateRoom($id)
	{
		require_once Yii::app()->basePath . '/extensions/virtualclassroomapi/includes/bbb-api.php';
		$bbb = new BigBlueButton();

		$room = Vroom::model()->findByPk($id);
		if($room && !Yii::app()->user->isGuest){
			$creationParams = array(
				'meetingId' => $room->id, 					// REQUIRED
				'meetingName' => $room->name, 	// REQUIRED
				'attendeePw' => $room->attendeePw, 					// Match this value in getJoinMeetingURL() to join as attendee.
				'moderatorPw' => $room->moderatorPw, 					// Match this value in getJoinMeetingURL() to join as moderator.
				'welcomeMsg' => $room->welcomeMsg,
				'logoutUrl' => 'http://thorconn.com/index.php/VirtualClassroom/logoutroom/?vroom_id='.$room->id.''
				/*'dialNumber' => '', 					// The main number to call into. Optional.
				'voiceBridge' => '12345', 				// 5 digit PIN to join voice conference.  Required.
				'webVoice' => '', 						// Alphanumeric to join voice. Optional.
				'logoutUrl' => '', 						// Default in bigbluebutton.properties. Optional.
				'maxParticipants' => '-1', 				// Optional. -1 = unlimitted. Not supported in BBB. [number]
				'record' => 'false', 					// New. 'true' will tell BBB to record the meeting.
				'duration' => '0', 						// Default = 0 which means no set duration in minutes. [number]
				//'meta_category' => '', 				// Use to pass additional info to BBB server. See API docs.*/
				'record' => 'true'
			);

			// preupload doc 
			// http://203.154.140.77/lms_thoresen/uploads/vc/test.pdf

			if(count($room->docs) > 0){
				
				$xml = "<?xml version='1.0' encoding ='UTF-8'?> 
				<modules><module name='presentation'> ";
				foreach ($room->docs as $key => $doc) {

					$xml .= "<document url='".str_replace("/admin/../", "/", Yii::app()->getUploadUrl('vc')).$doc->file_name."' />";

				}

				$xml .= " </module></modules>";
			}else{
				$xml = '';
			}
			//echo htmlspecialchars($xml);
			// Create the meeting and get back a response:
			$itsAllGood = true;
			try {$result = $bbb->createMeetingWithXmlResponseArray($creationParams,$xml);}
				catch (Exception $e) {
					echo 'Caught exception: ', $e->getMessage(), "\n";
					$itsAllGood = false;
				}

			if ($itsAllGood == true) {
				// If it's all good, then we've interfaced with our BBB php api OK:
				if ($result == null) {
					// If we get a null response, then we're not getting any XML back from BBB.
					echo "Failed to get any response. Maybe we can't contact the BBB server.";
					$this->redirect(array('VirtualClassroom/Index'));
				}	
				else { 
				// We got an XML response, so let's see what it says:
				//print_r($result);
					if ($result['returncode'] == 'SUCCESS') {
						// Then do stuff ...
						echo "<p>Meeting succesfullly created.</p>";
						$this->redirect(array('VirtualClassroom/Index'));
					}
					else {
						echo "<p>Meeting creation failed.</p>";
						$this->redirect(array('VirtualClassroom/Index'));
					}
				}
			}
		}else{
			echo "<p>Meeting creation failed.</p>";
			$this->redirect(array('VirtualClassroom/Index'));
			// error
		}

	}

	public function actionEndRoom($id)
	{
		require_once Yii::app()->basePath . '/extensions/virtualclassroomapi/includes/bbb-api.php';
		$bbb = new BigBlueButton();

		$room = Vroom::model()->findByPk($id);
		if($room && !Yii::app()->user->isGuest){

			$endParams = array(
				'meetingId' => $room->id, 			// REQUIRED - We have to know which meeting to end.
				'password' => $room->moderatorPw,				// REQUIRED - Must match moderator pass for meeting.
			);


			// Create the meeting and get back a response:
			$itsAllGood = true;
			try {$result = $bbb->endMeetingWithXmlResponseArray($endParams);}
				catch (Exception $e) {
					echo 'Caught exception: ', $e->getMessage(), "\n";
					$itsAllGood = false;
				}

			if ($itsAllGood == true) {
				// If it's all good, then we've interfaced with our BBB php api OK:
				if ($result == null) {
					// If we get a null response, then we're not getting any XML back from BBB.
					echo "Failed to get any response. Maybe we can't contact the BBB server.";
					$this->redirect(array('VirtualClassroom/Index'));
				}	
				else { 
				// We got an XML response, so let's see what it says:
				//print_r($result);
					if ($result['returncode'] == 'SUCCESS') {
						// Then do stuff ...
						echo "<p>Meeting succesfullly ended.</p>";
						$this->redirect(array('VirtualClassroom/Index'));
					}
					else {
						echo "<p>Failed to end meeting.</p>";
						$this->redirect(array('VirtualClassroom/Index'));
					}
				}
			}
		}else{
			echo "<p>Failed to end meeting.</p>";
			$this->redirect(array('VirtualClassroom/Index'));
			// error
		}
	}

	public function actionSendmailuser()
	{
		$id = $_POST['id'];
		$model = Vroomlogmail::model()->findByAttributes(array('vroom__id'=>$id));
		$model_vroom = Vroom::model()->findByAttributes(array('id'=>$id));
		$user_decode = json_decode($model->logmail_user); 
		$model->update_date =  date("Y-m-d H:i:s");
		$model->save();

		require dirname(__FILE__)."/../extensions/mailer/phpmailer/src/Exception.php";
	    require dirname(__FILE__)."/../extensions/mailer/phpmailer/src/PHPMailer.php";
	    require dirname(__FILE__)."/../extensions/mailer/phpmailer/src/SMTP.php";

	    $SettingAll = Helpers::lib()->SetUpSetting();

	    $adminEmail = 'thoresen.elearning@gmail.com';
        $adminEmailPass = 'lms@2020';

		foreach ($user_decode as $key_decode => $value) {

			$criteria = new CDbCriteria;
			$criteria->compare('id',$value->user_id);
			$user = User::model()->find($criteria);
			$email = $user->email;
			$user_id = $user->id;

			$to = array(
				'email'=>$email,
				'firstname'=>$user->profile->firstname,
				'lastname'=>$user->profile->lastname,
			);
			$nameshow = $user->profile->firstname." ".$user->profile->lastname;
			$message = $this->renderPartial('mail_key',array('key'=>$model->key_mail,'name_vroom'=>$model_vroom->name,'nameshow'=>$nameshow,'Classroom_name'=>$model_vroom->name_EN),true);
			$typemail = 'vroom';

			$mail =  new PHPMailer(true);
	        $mail->SMTPOptions = array(
	            'ssl' => array(
	                'verify_peer' => false,
	                'verify_peer_name' => false,
	                'allow_self_signed' => true
	                )
	            );
	        $mail->ClearAttachments();
	        $mail->ClearAddresses();
	        $mail->CharSet = 'utf-8';
	        $mail->Host = 'smtp.gmail.com';
	        $mail->Port = '587'; // port number
	        $mail->SMTPSecure = "tls";
	        $mail->SMTPKeepAlive = true;
	        $mail->Mailer = "smtp";
	        $mail->SMTPAuth = true;
	        $mail->SMTPDebug = false;
	        $mail->Username = $adminEmail;
	        $mail->Password = $adminEmailPass;
	        $mail->SetFrom($adminEmail, $typemail);
			//$mail = Helpers::lib()->SendMailVroom($value->user_id,'รหัสเข้าห้องเรียน',$message,$typemail);
	        $mail->AddAddress($email, 'คุณ' . $user->profile->firstname . ' ' . $user->profile->lastname);
	        $mail->Subject = 'รหัสเข้าห้องเรียน';
			$mail->Body = $message;
			$mail->IsHTML(true);
	        $mail->SMTPSecure = 'tls';
			$mail->Send();
	    	
			// $mail = Helpers::lib()->SendMail($to,'รหัสเข้าห้องเรียน',$message,$typemail);   
		}
		$type = 'datetime';
		$date_update = Helpers::lib()->changeFormatDate($model->update_date,$type);
		$cou_user = count($user_decode);
		$table .=  '<span class="noti-date"><i class="fa fa-calendar" aria-hidden="true"></i> '.$date_update.'</span> <span class="noti-date"><i class="fa fa-users" aria-hidden="true"></i> จำนวน  <b>'.$cou_user.'</b> คน</span>';

	echo $table;

	}

	public function actionGetuser()
	{
	$id = $_POST['id'];
    $model = Vroomlogmail::model()->findByAttributes(array('vroom__id'=>$id));
   	$user = json_decode($model->logmail_user); 

   	$user_arr=[];
   	foreach ($user as $key => $val) {
   		$user_arr[] = $val->user_id;
   	}

   	$criteria = new CDbCriteria;
    $criteria->addInCondition("id",$user_arr);
    $modeluser = User::model()->findAll($criteria);

    $data = array();
    foreach ($modeluser as $key => $value) {
      $name = $value->profile->firstname_en.' '.$value->profile->lastname_en;
	  $id = $value->id;

      $data[$key][0] = 0;
      $data[$key][1] = $name;
      $data[$key][2] = '<a class="btn-action glyphicons pencil btn-danger remove_2" title="ลบ"><i></i></a>';
      $data[$key][3] = $id;
      $data[$key][4] = $value->profile->firstname_en;
      $data[$key][5] = $value->profile->lastname_en;
      $data[$key][6] = 'คุณ';

    }
    echo json_encode($data);
	}


	public function loadModel($id)
	{
		$model=VRoom::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='course-online-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSequence() {
		if (isset($_POST['items']) && is_array($_POST['items'])) {
			// Get all current target items to retrieve available sortOrders
			$cur_items = CourseOnline::model()->findAllByPk($_POST['items'], array('order'=>'sortOrder'));
			// Check 1 by 1 and update if neccessary
			for ($i = 0; $i < count($_POST['items']); $i++) {
				$item = CourseOnline::model()->findByPk($_POST['items'][$i]);
				if ($item->sortOrder != $cur_items[$i]->sortOrder) {
					$item->sortOrder = $cur_items[$i]->sortOrder ;
					$item->save();
				}
			}
		}
	}

	public function actionCheckExists()
    {
        $webroot = Yii::app()->getUploadPath('vc');
        $targetFolder = $webroot; // Relative to the root and should match the upload folder in the uploader script
  
        if (file_exists($targetFolder . $_POST['filename'])) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function actionUploadifive()
    {
        // Set the uplaod directory
       
        $uploadDirs = Yii::app()->getUploadPath(null);
		$path1 = "vc";

	    if (!is_dir($uploadDirs."../".$path1."/")) {
		    mkdir($uploadDirs."../".$path1."/", 0777, true);
			}

		$webroot = Yii::app()->getUploadPath("vc");
        $uploadDir = $webroot;
        // Set the allowed file extensions
        $fileTypes = array('jpg','pdf','ppt','pptx','doc'); // Allowed file extensions

        if (!empty($_FILES)) {

            $rnd = rand(0,9999999999);
            $tempFile   = $_FILES['Filedata']['tmp_name'];
            $uploadedFile = CUploadedFile::getInstanceByName('Filedata');
            $fileName = $uploadedFile->getName();
            $file_Name = "{$rnd}.".strtolower($uploadedFile->getExtensionName());

            $targetFile = $uploadDir . $file_Name;

            // Validate the filetype
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

                // Save the file
                move_uploaded_file($tempFile, $targetFile);
                $roomDoc = new VRoomDoc();
                $roomDoc->room_id = $_POST['room_id'];
                $roomDoc->name = $fileName;
                $roomDoc->file_name = $file_Name;

                $roomDoc->save();
                echo 1;

            } else {

                // The file type wasn't allowed
                echo 'Invalid file type.';

            }
        }
    }

    	public function actionDeletevdo($id,$vdo_id)
    {
    	if(null !== Yii::app()->user && isset(Yii::app()->user->id)){
	    	if ($id !== null && $vdo_id !== null) {
	    		$VRoomDeletevdo = new VRoomDeletevdo;
	    		$VRoomDeletevdo->room_id = $id;
	    		$VRoomDeletevdo->vdo_id = $vdo_id;
	    		$VRoomDeletevdo->create_date = date("Y-m-d H:i:s");
	    		$VRoomDeletevdo->create_by = Yii::app()->user->id;
	    		$VRoomDeletevdo->active = 'y';
	    		if ($VRoomDeletevdo->save()) {
	    				require_once Yii::app()->basePath . '/extensions/virtualclassroomapi/includes/bbb-api.php';
	    				$bbb = new BigBlueButton();

						$recordingParams = array(
					
								'recordId' => $vdo_id, 		

							);

							$itsAllGood = true;
							try {$result = $bbb->deleteRecordingsWithXmlResponseArray($recordingParams);}
								catch (Exception $e) {
									echo 'Caught exception: ', $e->getMessage(), "\n";
									$itsAllGood = false;
								}

							if ($itsAllGood == true) {
								$response = [ 
									'success' => true,
									'message' => 'Delete Successful'
									];
									echo json_encode($response); 
								//print_r($result);
						}			
	    		}else{
	    			$response = [ 
						'success' => false,
						'message' => 'Delete Unsuccessful'
						];
						echo json_encode($response); 
	    		}
	    	}else{
	    		$response = [ 
					'success' => false,
					'message' => 'No data found'
				];
				echo json_encode($response); 
	    	}
    	}else{
    		$response = [ 
				'success' => false,
				'message' => 'User not found'
			];
			echo json_encode($response); 
    	}
    }

    public function actionDeletefile($id)
    {
    	if(null !== Yii::app()->user && isset(Yii::app()->user->id)){
	    	if ($id !== null) {
	    		$VRoomDoc = VRoomDoc::model()->findByPk($id);
	    		$VRoomDoc->active = 'n';
	  
	    		if(is_file(Yii::app()->getUploadPath('vc').$VRoomDoc->name))
                        {
                            unlink(Yii::app()->getUploadPath('vc').$VRoomDoc->name);        
                        }
	    		
	    		if ($VRoomDoc->save()) {
	    				$response = [ 
						'success' => true,
						'message' => 'Delete successful'
						];
						echo json_encode($response); 
	    		}else{
	    			$response = [ 
						'success' => false,
						'message' => 'Delete Unsuccessful'
						];
						echo json_encode($response); 
	    		}
	    	}else{
	    		$response = [ 
					'success' => false,
					'message' => 'No data found'
				];
				echo json_encode($response); 
	    	}
    	}else{
    		$response = [ 
				'success' => false,
				'message' => 'User not found'
			];
			echo json_encode($response); 
    	}
    }



       public function actionChecklearn()
    {	
    	$id = json_decode($_POST['learn_num']);

    	$table = '<table id="exampledirector" class="display" style="width:100%">
    	<thead>
    	<tr>
    	<th class="th-fullname">ชื่อ-นามสกุล</th>
    	</tr>
    	</thead>
    	<tbody class="table-importlearn">';
    	foreach ($id as $key => $value) {
    		$criteria = new CDbCriteria;
    		$criteria->compare('id',$value[3]);
    		$user = User::model()->find($criteria);
    		$table .= '<tr>
    		<td class="fullname-learn" colspan="1">'.'คุณ'.' '.$user->profile->firstname.' '.$user->profile->lastname.'</td>
    		</tr>';
    	}

    	$table .=' </tbody>
    	</table>';

    	echo $table;
    }

         public function actionLogmeeting()
    {	
    	   $model=new VRoomLogmeeting('search');
        $model->unsetAttributes();  // clear any default values
        
        if(isset($_GET['VRoomLogmeeting']))
            $model->attributes=$_GET['VRoomLogmeeting'];

        $this->render('logmeeting',array(
            'model'=>$model,
        ));

    }




}
