<?php

class ContactusController extends Controller
{
	public function filters()
	{
		return array(
            'accessControl', // perform access control for CRUD operations
            // 'rights',
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
            	'actions' => array('view','MultiDelete'),
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
	// public function filters()
	// {
	// 		return array(
	// 				'rights',
	// 		);
	// }

    public function actionView($id)
    {
    	$model=new Contactus;
    	if(isset($_POST['ans-subject'])){
			/*Yii::import('application.extensions.phpmailer.JPhpMailer'); // ดึง extension PHPMailer เข้ามาใช้งาน
	        $mail = new JPhpMailer;
	        $mail->IsSMTP();
	        $mail->SMTPAuth = true;
	        $mail->SMTPSecure = "ssl";
	        $mail->SMTPKeepAlive = true;
	        $mail->Mailer = "smtp";
	        $mail->SMTPDebug = 1;
	        $mail->Host = 'smtp.gmail.com'; // gmail server
	        $mail->Port = '465'; // port number
	        $mail->Username = 'peerapon.lim@gmail.com'; // User Email
	        $mail->Password = 'dokapon747'; // Pass Email
	        $mail->CharSet = 'utf-8';
	        $mail->SetFrom('peerapon.lim@gmail.com', 'peerapon'); // ตอบกลับ
	        $mail->AddAddress($_POST['ans-mail']); // to destination
	        $mail->Subject = $_POST['ans-subject']; // subject หัวข้อจดหมาย
	        $mail->MsgHTML($_POST['ans-detail']); // Message*/
	        //$mail->Send(); // ส่งเมล
	        $to = array();
	        $to['email'] = $_POST['ans-mail'];
	        $to['firstname'] = $_POST['ans-name'];
	        $to['lastname'] = $_POST['ans-surname'];
	        $subject = 'ระบบติดต่อเรา(ตอบกลับ) : '.$_POST['ans-subject'];
	        $message = $_POST['ans-detail'];
	        $send = Helpers::lib()->SendMail($to, $subject, $message);
	        if ($send) {
	        	$modelContUs = Contactus::model()->findByPk($id);
	        	$modelContUs->contac_answer = 'y';
	        	$modelContUs->contac_ans_subject = $_POST['ans-subject'];
	        	$modelContUs->contac_ans_detail = $_POST['ans-detail'];
	        	$modelContUs->update();
	        	$model=new Contactus;
	        	$this->render('index',array(
	        		'model'=>$model,
	        	));
	        }
	    }else{
	    	$this->render('view',array(
	    		'model'=>$this->loadModel($id),
	    	));
	    }
	}

	public function actionDelete($id)
	{
		// echo $_POST['returnUrl'];
		// exit();
		// $this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		$model->active = 'n';
		$model->save();
		// return
		// exit();
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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
		$model=new Contactus('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Contactus']))
			$model->attributes=$_GET['Contactus'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Contactus::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='contactus-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
