<?php

class ReportProblemController extends Controller
{
	public function init()
	{
		// parent::init();
		// $this->lastactivity();
		if(Yii::app()->user->id == null){
				$this->redirect(array('site/index'));
			}
		
	}
	
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index','view', 'SendMailMessage'),
				'users'=>array('*'),
				),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
				),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','accept','adminaccept','report','SendMailMessage'),
				'users'=>array('admin'),
				),
			array('deny',  // deny all users
				'users'=>array('*'),
				),
			);
	}

	// public function actionReport()
	// {
	// 	// $model=new ReportProblem('search');
	// 	// $model->unsetAttributes();  // clear any default values

	// 	$model = new ReportProblem('searchPrint');
	// 	$model->unsetAttributes();  // clear any default values
	

	// 	if (isset($_GET['export'])) 
	// 	{
	// 		$production = 'export';
	// 	} 
	// 	else 
	// 	{
	// 		$production = 'grid';
	// 	}
	// 	$this->render('report', array('model' => $model, 'production' => $production));
	// }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ReportProblem;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ReportProblem']))
		{
			$model->attributes=$_POST['ReportProblem'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
			));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{


		$model=$this->loadModel($id);
		$SettingAll = Helpers::lib()->SetUpSetting();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ReportProblem']))
		{
			$model->attributes=$_POST['ReportProblem'];
			$adminEmail = $SettingAll['USER_EMAIL'];
			$adminEmailPass = $SettingAll['PASS_EMAIL'];
			Yii::import('application.extensions.phpmailer.JPhpMailer');
			$mail = new JPhpMailer;
			$mail->CharSet = 'UTF-8';
			$mail->IsSMTP();
			$mail->Host = 'smtp.gmail.com'; // gmail server
			$mail->Port = '465'; // port number
			$mail->SMTPSecure = "ssl";
			$mail->SMTPKeepAlive = true;
			$mail->Mailer = "smtp";
			$mail->SMTPAuth = true;
			$mail->SMTPDebug = 0;
			$mail->Username = $adminEmail;
			$mail->Password = $adminEmailPass;
			$mail->SetFrom($adminEmail, $adminEmail);
			$mail->Subject = 'ตอบคำถาม'.$model->report_title;
			$mail->MsgHTML($model->answer);
			//$mail->AddAddress('piya.ssm@gmail.com', 'piya.ssm@gmail.com');
			$mail->AddAddress($model->email, $model->email);
			if ($mail->Send()) {
				
				$model->status = 'success';
				date_default_timezone_set("Asia/Bangkok");
				$model->accept_report_date = date("Y-m-d H:i:s");
				if($model->save()) {
					Yii::app()->user->setFlash('contact','ตอบกลับสำเร็จ.');
				} else {
					Yii::app()->user->setFlash('contact','ตอบกลับเมลสำเร็จ แต่มีปัญหาการบันทึกข้อมูล.');
				}
			} else {
				Yii::app()->user->setFlash('error','Error while sending email: '.$mail->getError());
			}

			// $model->attributes=$_POST['ReportProblem'];
			// if($model->save())
			// 	$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('accept',array(
			'model'=>$model,
			));

		// $model=$this->loadModel($id);

		// // Uncomment the following line if AJAX validation is needed
		// // $this->performAjaxValidation($model);

		// if(isset($_POST['ReportProblem']))
		// {
		// 	$model->attributes=$_POST['ReportProblem'];
		// 	if($model->save())
		// 		$this->redirect(array('view','id'=>$model->id));
		// }

		// $this->render('update',array(
		// 	'model'=>$model,
		// ));
	}

	public function actionAccept($id)
	{
		$model=$this->loadModel($id);
		$SettingAll = Helpers::lib()->SetUpSetting();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ReportProblem']))
		{
			$model->attributes=$_POST['ReportProblem'];
			$adminEmail = $SettingAll['USER_EMAIL'];
			$adminEmailPass = $SettingAll['PASS_EMAIL'];
			Yii::import('application.extensions.phpmailer.JPhpMailer');
			$mail = new JPhpMailer;
			$mail->CharSet = 'UTF-8';
			$mail->IsSMTP();
			$mail->Host = 'smtp.gmail.com'; // gmail server
			$mail->Port = '465'; // port number
			$mail->SMTPSecure = "ssl";
			$mail->SMTPKeepAlive = true;
			$mail->Mailer = "smtp";
			$mail->SMTPAuth = true;
			$mail->SMTPDebug = 0;
			$mail->Username = $adminEmail;
			$mail->Password = $adminEmailPass;
			$mail->SetFrom($adminEmail, $adminEmail);
			$mail->Subject = 'ตอบคำถาม'.$model->report_title;
			$mail->MsgHTML($model->answer);
			//$mail->AddAddress('piya.ssm@gmail.com', 'piya.ssm@gmail.com');
			$mail->AddAddress($model->email, $model->email);
			if ($mail->Send()) {
				
				$model->status = 'success';
				date_default_timezone_set("Asia/Bangkok");
				$model->accept_report_date = date("Y-m-d H:i:s");
				if($model->save()) {
					Yii::app()->user->setFlash('contact','ตอบกลับสำเร็จ.');
				} else {
					Yii::app()->user->setFlash('contact','ตอบกลับเมลสำเร็จ แต่มีปัญหาการบันทึกข้อมูล.');
				}
			} else {
				Yii::app()->user->setFlash('error','Error while sending email: '.$mail->getError());
			}

			// $model->attributes=$_POST['ReportProblem'];
			// if($model->save())
			// 	$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('accept',array(
			'model'=>$model,
			));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model = new ReportProblem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ReportProblem']))
			$model->attributes=$_GET['ReportProblem'];
		$this->render('index',array(
			'model'=>$model,
			));
	}

	public function actionSendMailMessage(){
		$id = $_POST['id'];
		$msg  = $_POST['inputValue'];
		$model = ReportProblem::model()->findByPk($id);
		$model->status = 'success';
		$model->accept_report_date = date("Y-m-d H:i:s");
		$model->answer = $msg;
		if ($model->save(false)) {
		$Usability = Usability::model()->findByPk($model->report_type);
		$to = array();
       	$to['email'] = $model->email;
      	$to['firstname'] = $model->firstname;
       	$to['lastname'] = $model->lastname;
       	if ($Usability) {
    	//$subject = 'ตอบคำถาม เรื่อง  : ' . $Usability->usa_title;
    		$subject = 'LmsMd inquiry report system\ รายงานผลการสอบถามระบบ LmsMd : ' . $Usability->usa_title;
       	}else{
       	//$subject = 'ตอบคำถามที่ท่านส่งมา';
       		$subject = 'LmsMd inquiry report system\ รายงานผลการสอบถามระบบ LmsMd : ';
       	}      
       	$message = $msg;
        $mail = Helpers::lib()->SendMail($to, $subject, $message);
        echo 'y';
    }else{
    	echo 'n';
    }
 }

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ReportProblem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ReportProblem']))
			$model->attributes=$_GET['ReportProblem'];

		$this->render('admin',array(
			'model'=>$model,
			));
	}

	public function actionAdminaccept()
	{
		$model=new ReportProblem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ReportProblem']))
			$model->attributes=$_GET['ReportProblem'];

		$this->render('admin-accept',array(
			'model'=>$model,
			));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ReportProblem the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ReportProblem::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ReportProblem $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='report-problem-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
