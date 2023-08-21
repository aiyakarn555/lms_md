<?php

class PrivatemessageController extends Controller
{
	public function init()
	{
		parent::init();
		if (Yii::app()->user->id == null) {
			if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
				$langId = Yii::app()->session['lang'] = 1;
			}else{
				$langId = Yii::app()->session['lang'];
			}

			$label = MenuCourse::model()->find(array(
				'condition' => 'lang_id=:lang_id',
				'params' => array(':lang_id' => $langId)
			));
			if(!$label){
				$label = MenuCourse::model()->find(array(
					'condition' => 'lang_id=:lang_id',
					'params' => array(':lang_id' => 1)
				));
			}

			$msg = $label->label_alert_msg_plsLogin;
			Yii::app()->user->setFlash('msg',$msg);
			$this->redirect(array('site/index','msg'=>$msg));
			exit();
		}
		$this->lastactivity();

	}
	public function actionIndex($id = null)
	{		
		
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}

		if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
			$langId = Yii::app()->session['lang'] = 1;
		}else{
			$langId = Yii::app()->session['lang'];
		}
		$label = MenuPrivatemessage::model()->find(array(
			'condition' => 'lang_id=:lang_id',
			'params' => array(':lang_id' => $langId)
		));

		if(!$label){
			$label = MenuPrivatemessage::model()->find(array(
				'condition' => 'lang_id=:lang_id',
				'params' => array(':lang_id' => 1)
			));
		}

		// $criteria = new CDbCriteria;
		// $criteria->order = 'create_date ASC';
		// $PrivatemessageReturn = PrivateMessageReturn::model()->findAll($criteria);
		
		// chack user admin
		$criteria = new CDbCriteria;
		$criteria->compare('superuser',1);
		$criteria->compare('del_status',0);
		$superuser = User::model()->findAll($criteria);

		$profile = Profile::model()->findByPk(Yii::app()->user->id);
			// แชคหัวข้อตรงกับผู้ใช้
		$criteria = new CDbCriteria;
		$criteria->compare('create_by',yii::app()->user->id);
		$criteria->order = 'create_date ASC';
		$Privatemessage = PrivateMessage::model()->findAll($criteria);

		$CurrentMessage = PrivateMessage::model()->find(array(
  		              'condition' => 'pm_id=:pm_id',
  		              'params' => array(':pm_id' => $id)
  		          ));
		$this->render('index',array(
			'id' => $id,
			'Privatemessage' => $Privatemessage,
			'profile'=>$profile,
			'superuser'=>$superuser,
			'label'=> $label,
			'CurrentMessage' => $CurrentMessage
		));
	} 

	public function actionSave(){ 
		
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		$pmr = new PrivateMessageReturn;
		$pm = new PrivateMessage;

			// $file = $_FILES;
			// var_dump($file);exit();
		if (!empty($_POST['pm_quest']))
		{
							// echo $_POST['pm_id'];exit();
			$pmr->pmr_return = Helpers::lib()->xss_clean($_POST['pm_quest']);
						 	// $pmr->create_by = $_POST['Privatemessage']['user_id'];
			$pmr->pm_id = $_POST['pm_id'];
			$pmr->create_date = date('Y-m-d H:i:s');
			$pmr->create_by = Yii::app()->user->id;
			if ($pmr->save()){
				$this->redirect(array('Privatemessage/index','id'=>$_POST['pm_id']));
			}else{
				var_Dump($pmr->getErrors());
				exit();
			}
		} else {
			if($_POST['mail'] == 1){
				$fromProfile = Profile::model()->findByPk(Yii::app()->user->id);
				$toProfile = Users::model()->findByPk($_POST['pm_to']);
				$to = array();
				                //$to['email'] = 'thaiparliamenthrd@gmail.com';//$model->contac_by_email;
				                $to['email'] = $toProfile->email;//'chalermpol.vi@gmail.com';//
				                // $to['email'] = 'jojo99za@gmail.com';//'chalermpol.vi@gmail.com';//

				                $to['firstname'] = 'ผู้ดูแลระบบ';
				                $to['lastname'] = '';
				                $subject = 'ระบบส่งข้อความส่วนตัว เรื่อง  : ' . $_POST['pm_topic'] ;
				                $message = 'จาก '.$fromProfile->firstname.' '.$fromProfile->lastname.'<br> รายละเอียด : '.$_POST['detail'];
				                // $mail = Helpers::lib()->SendMail($to, $subject, $message);

				                // $file = $_FILES;
				                // var_dump($file);exit();
				                $attachment;
				                if(isset($_FILES)){
				                	$tempSave = $_FILES["upfile"]["tmp_name"];
				                	$info = pathinfo($_FILES['upfile']['name']);
				                	$ext = $info['extension'];
				                	$milliseconds = round(microtime(true) * 1000);
					                // $filename = uniqid('Contactus_', true) . ".".$ext;
				                	$filename = $milliseconds . ".".$ext;
							        // $dirfolder = Yii::app()->basePath."/../uploads/contactus/";
				                	$dirfolder =  $_SERVER['DOCUMENT_ROOT']."/lms_airasia/uploads/contactus/";
				                	if (!is_dir($dirfolder)) {
				                		$fol = mkdir($dirfolder);
				                	}
				                	$dirfolder .= $filename;
							        // $Pathuploadfile = Yii::app()->basePath.'/../uploads/contactus/'."1".'/'.$model->contac_pic;
				                	if(!empty($tempSave))
				                	{
				                		move_uploaded_file( $tempSave, $dirfolder);
				                		$attachment = $dirfolder;
							            // $tempSave->saveAs($dirfolder);
				                	}
				                	$pm->all_file = $filename;
				                }

				                $mail = Helpers::lib()->SendMailMsg($to, $subject, $message,$attachment);
				            }
							// echo $_POST['Privatemessage']['user_id'];
								// echo $_POST['upfile'];
								// echo "<br>";
								// echo $_POST['pm_to'] ;
								// echo "<br>";
								// echo $_POST['detail'] ;
								// echo "<br>";
								// echo  $_POST['pm_topic'];
								// exit();
							// $pm->all_file = $_POST['upfile'];
				            $pm->create_by = $_POST['Privatemessage']['user_id'];
				            $pm->pm_topic = $_POST['pm_topic'];
				            $pm->pm_to = $_POST['pm_to'];
				            $pm->pm_quest = $_POST['detail'];
				            $pm->create_date = date('Y-m-d H:i:s');

				            if ($pm->save()) {
				            	$this->redirect(array('Privatemessage/index'));
				            }else{
				            	var_Dump($pm->getErrors());
				            	exit();
				            }
				        }	 	
				    }

				    public function actionMessage($id=null)
				    {

				    	$criteria = new CDbCriteria;
				    	$criteria->order = 't.create_date DESC';
				    	$criteria->addCondition('t.create_by ='.Yii::app()->user->id);
				    	$model = Contactus::model()->findAll($criteria);
				    	if (!empty($id)) {
				    		$topic = Contactus::model()->findbyPK($id);

				    	}

				    	$this->render('message', array(
				    		'model'=>$model,
				    		'topic'=>$topic
				    	));
				    }

				    public function actionDownload($id) {
				    	if(Yii::app()->user->id){
				    		Helpers::lib()->getControllerActionId();
				    	}
				    	$fileDoc = PrivateMessage::model()->findByPK($id);
				    	if ($fileDoc) {
            // $webroot = Yii::app()->getUploadPath('filedoc');
				    		$webroot = Yii::app()->basePath.'/../uploads/contactus/';
            // var_dump($webroot);exit();
				    		$uploadDir = $webroot;
				    		$filename = $fileDoc->all_file;
				    		$filename = $uploadDir . $filename;
            // var_dump($filename);
            // exit;
				    		if (file_exists($filename)) {
				    			return Yii::app()->request->sendFile($fileDoc->all_file, file_get_contents($filename));
				    		} else {
				    			throw new CHttpException(404, 'The requested page does not exist.');
				    		}
				    	} else {
				    		throw new CHttpException(404, 'The requested page does not exist.');
				    	}
				    }
				}