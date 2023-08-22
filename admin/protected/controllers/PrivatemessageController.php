<?php
 
class PrivatemessageController extends Controller
{
	public function filters()
	{
		return array(
            'accessControl', // perform access control for CRUD operations
            );
	}

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
    	return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
            	'actions' => array('index', 'view'),
            	'users' => array('*'),
            	),
            array('allow',
                // กำหนดสิทธิ์เข้าใช้งาน actionIndex
            	'actions' => AccessControl::check_action(),
                // ได้เฉพาะ group 1 เท่านั่น
            	'expression' => 'AccessControl::check_access()',
            	),
            array('deny',  // deny all users
            	'users' => array('*'),
            	),
            );
    }
    
	public function init()
	{
		parent::init();
		$this->lastactivity();
		
	}
	public function actionIndex()
	{
		$criteria = new CDbCriteria;
		$criteria->with = array('msgReturn');
		$criteria->order ='t.create_date DESC';
		$modelprivate = new PrivateMessage($criteria);
		$modelprivate->unsetAttributes();
				if (isset($_GET['PrivateMessage'])){
		            $modelprivate->attributes = $_GET['PrivateMessage'];
				}
			// echo "<pre>" ; var_dump($modelprivate);exit();
			
				$this->render('index',array(
					'model'=> $modelprivate
				));
	}

		// public function actionView($id=null) 
		// {  
		// 	// var_dump($loadModel); exit();
		// 	if ($id) {
		// 				$model =PrivateMessage::model()->find(array('condition'=> 'pm_id ='.$id));
		// 				$criteria=new CDbCriteria;
		// 				$criteria->addCondition('pm_id ='.$id);
		// 			$criteria->addCondition('answer_by IS NULL');
		// 			$criteria->compare('status_answer',0);
		// 	}
		// 	$profile = Profile::model()->findbyattributes(array('user_id' => $model->create_by));
		// 	$this->render('view',array(
		// 		'profile'=> $profile,
		// 		'model' =>$model,));
		// }

		// public function actionSave(){
		// 	// echo $_POST['PrivateMessageReturn']['user_id'];exit();
		// 			$pmr = new PrivateMessageReturn();
		// 			// var_dump($pm);exit();
		// 	 if (isset($_POST['PrivateMessageReturn'])) 
		// 	 	{
		// 		 	$pmr->pmr_return = $_POST['PrivateMessageReturn']['pmr_return'];
		// 		 	$ppmrm->create_by = $_POST['PrivateMessageReturn']['user_id'];
		// 		 	$pmr->pm_id = $_POST['PrivateMessageReturn']['pm_id'];
		// 		 	$pmr->create_date = date('Y-m-d H:i:s');
				 	
		// 	 	}
		// 		if ($pmr->save())
		// 		{
		// 			$this->redirect(array('PrivateMessage/index','pmr'=>$pmr));
		// 		}else{
		// 			var_Dump($pmr->getErrors());
		// 			exit();
		// 		}
		// 			$this->render('index',array('pmr' =>$pmr,
		// 			));
		// 		}


public function actionView($id)
{
	{
		$pmr = PrivateMessageReturn::model()->findall();

		$criteria = new CDbCriteria;
		$criteria->order = 'create_date ASC';
		$criteria->condition = 'pm_id ='.$id;
		// $criteria->condition = 'question_status = 0';
		// $modelprivate_message = PrivateMessage::model()->findall($criteria);
		$modelprivate_message = PrivateMessage::model()->find($criteria);

		$profile = Profile::model()->find(array('condition'=> 'user_id ='.$modelprivate_message->create_by));
	}
	
		$this->render('view',array(
				'id' =>$id,
				'pmr' =>$pmr,
				'profile'=>$profile,
				'model'=>$modelprivate_message,
			));
	}

	public function actionSave(){
		$pmr = new PrivateMessageReturn;
 
			if( isset($_POST['ptivatemessage']) || isset($_POST['privatemessage_return']))
			{
					$pmr->status_answer = 1;
					// $modelprivate_message_return->answer_by = Yii::app()->user->id;
					$pmr->pm_id = $_POST['PrivateMessageReturn']['ptivatemessage'];
					$pmr->pmr_return = $_POST['privatemessage_return'];
					$pmr->update_date = date('Y-m-d H:i:s');
					$pmr->create_date = date('Y-m-d H:i:s');
					$pmr->answer_by = Yii::app()->user->id;
					$pmr->create_by = Yii::app()->user->id;
					if ($pmr->save()) { 
						$this->redirect(array('view','id' => $pmr->pm_id));
					}
			}else{
					var_Dump($pmr->getErrors());
					exit();
				}


























				// $path = '../uploads/file_private/UploadAllFilePrivateMessage/'.$model->pm_id.'/'; //
				// 	if (!file_exists($path)) {
				//     	mkdir($path, 0777, true);
				// 	}
					// {
					// 			$modelprivate = PrivateMessage::model()->find(array('condition'=> 'pm_id ='.$_POST['ptivatemessage']));
					// 			$modelprivate->update_date = date('Y-m-d H:i:s');

					// 			$modelprivate->question_status = 1;
					// 			$modelprivate->update_date = date('Y-m-d H:i:s');
								

					// 			$modelprivate->save();
					// 				$criteria=new CDbCriteria;
					// 				$criteria->addCondition('pm_id ='.$_POST['ptivatemessage']);
					// 				// $criteria->addCondition('answer_by IS NULL');
					// 				// $criteria->compare('status_answer',0);

									
												



									// 	if (isset($_FILES['file']['name'])) {
									//     if (0 < $_FILES['file']['error']) {
									//         echo 'Error during file upload' . $_FILES['file']['error'];
									//     } else {
									//         if (file_exists($path. $_FILES['file']['name'])) {
									//             echo 'File already exists : uploads/' . $_FILES['file']['name'];
									//         } else {
									//         	$filename = rand(0,9999999).$_FILES['file']['name'];
									//             move_uploaded_file($_FILES['file']['tmp_name'], $path.$filename);
									//             $model->all_file_return_pm = $filename;
									//         }
									//     }
									// } 
						// if($model->validate()){
						// 	if($model->save()){
   //                  if(Yii::app()->user->id){
   //                      Helpers::lib()->getControllerActionId($_POST['ptivatemessage']);
   //                  }
			// 		$criteria =new CDbCriteria;
			// 		$criteria->compare('pm_id',$model->pm_id);
			// 		$criteria->compare('pm_alert',"on");
			// 		$modelprivate_id  = PrivateMessage::model()->find($criteria);
			// 		if($modelprivate_id){
			// 			$criteria_rt =new CDbCriteria;
			// 			$criteria_rt->compare('pm_id',$modelprivate_id->pm_id);
			// 			$criteria_rt->addCondition('answer_by IS NOT NULL');
			// 			$criteria_rt->addCondition('create_by IS NULL');
			// 			$criteria_rt->order = 'create_date  DESC';
			// 			$modelprivateReturn = PrivateMessageReturn::model()->find($criteria_rt); 
			// 			if($modelprivateReturn){
			// 				$modelUser = MMember::model()->find(array('condition' => 'm_id ='.$modelprivate_id->create_by));
			// 				$modelAdmin = MMember::model()->find(array('condition' => 'm_id ='.$modelprivate_id->pm_to));
			// 				$subject = 'สวัสดี';
			// 				$to['firstname'] = $modelUser->m_firstname_th;
			// 				$to['lastname'] = $modelUser->m_lastname_th;
			// 				$to['email'] = $modelUser->m_email;
			// 				$message = 'ทาง  Admin'.$modelAdmin->m_firstname_th.' '.$modelAdmin->m_lastname_th.'ได้ตอบกลับข้อความคุณแล้ว ตรวจสอบได้ที่ระบบ';
			// 				Helpers::lib()->SendMail($to,$subject,$message);
			// 			}
			// 		}
			// 	}
			// }
			
		
		// echo true;
	}

	// protected function performAjaxValidation($model)
	// {
	// 	if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
	// 	{
	// 		echo CActiveForm::validate($model);
	// 		Yii::app()->end();
	// 	}
	// }

	// public function loadModel($id)  // ทำการร return เพือไห้ฟังชั้นอืนดึงไปใช้งาน
	// {
	// 	$model =Profile::model()->findByPk($id);
	// 	if($model===null)
	// 		throw new CHttpException(404,'The  requested page does not exist.');
	// 	return $model;
	// }
	// public function accessRules()
	// {
	// 	return array(
	// 		array('allow',  // allow all users to perform 'index' and 'view' actions
	// 			'actions'=>array('index','view'),
	// 			'users'=>array('*'),
	// 		),
	// 		array('allow', // allow authenticated user to perform 'create' and 'update' actions
	// 			'actions'=>array('create','update'),
	// 			'users'=>array('@'),
	// 		),
	// 		array('allow', // allow admin user to perform 'admin' and 'delete' actions
	// 			'actions'=>array('admin','delete','accept','adminaccept','report'),
	// 			'users'=>array('admin'),
	// 		),
	// 		array('deny',  // deny all users
	// 			'users'=>array('*'),
	// 		),
	// 	);
	// }
}