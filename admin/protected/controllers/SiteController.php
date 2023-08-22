<?php
class SiteController extends Controller
{
	public function init()
	{
		parent::init();
		$this->lastactivity();
		
	}
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index','error','sendmailUpdate'),
				'users'=>UserModule::getAdmins(),
			),
			array('deny',
				'users'=>array('*'),
				'deniedCallback' => array($this, 'redirecting'),
			),
		);
	}

	//No Login
	public function redirecting()
	{ 
		if (Yii::app()->user->id) {
			Yii::app()->session->clear();
			Yii::app()->session->destroy();
		    $this->redirect(array('/user/login'));
		    Yii::app()->end();
		}else{
			Yii::app()->session->clear();
		    $this->redirect(array('/user/login'));
		    Yii::app()->end();
		}
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionSendmailUpdate()
	{
		// $user = User::model()->findByPk(Yii::app()->user->id);
	 //        $profile = $user->profile;
	 //        if($profile->generation != '' && is_numeric($profile->generation)){
	 //        	$course_notifications = CourseNotification::model()->findAll(array('condition'=>'generation_id='.$profile->generation,'order'=>'end_date DESC'));
		//         $data = '';
		//         $i = 0;
		//         foreach ($course_notifications as $key => $course_notification) {
	 //                $checkNotification = Helpers::lib()->emailNotificationCourse($course_notification);
	 //                if($checkNotification != false){
	 //                	$i++;
	 //                	$name = CourseOnline::model()->findByPk($checkNotification[0]);
	 //                	$data .= '<br>'.$i.'. '.$name->course_title.' เหลือเวลาเรียน '.$checkNotification[1].' วัน ';
	 //                	$status = true;
	 //                }
		//         }
		//         if($status){
		// 			$check = UserModule::sendMail($user->email,'DBD Academy ระบบแจ้งเตือนการเรียนหลักสูตร',UserModule::t("รายชื่อหลักสูตรที่ใกล้หมดเวลาเรียน มีดังนี้ {name} <br>กรุณาเข้าสู่ระบบเพื่อเข้าเรียนหลักสูตร",array('{name}'=>$data)));
		// 			if (!$check) {
		// 			    Yii::app()->user->setFlash('error',' Error while sending email: '.$mail->getError());
		// 			}
		//         }
	 //        }

		$user = User::model()->findAll(array('condition'=>'occupation="ธุรกิจส่วนตัว/เจ้าของกิจการ"'));
		// $user = User::model()->findAll(array('condition'=>'username="0000000000000"'));
		foreach ($user as $key => $value) {
			// var_dump($value);exit();
			$link = $this->createAbsoluteUrl('/user/profile/edit');
			$check = UserModule::sendMail($value->email,'DBD Academy ระบบแจ้งเตือนการเปลี่ยนแปลงข้อมูล',UserModule::t("เนื่องจากระบบมีการเปลี่ยนข้อมูลสมาชิก โดยสมาชิกที่ได้รับอีเมลนี้ จะเป็นบุคคลที่มีข้อมูลด้านธุรกิจส่วนตัว รบกวนสมาชิกที่ได้รับอีเมล กรุณาเข้าระบบเพื่ออัพเดทข้อมูลทางด้านธุรกิจได้ลิงค์นี้ {link}",array('{link}'=>$link)));
				if (!$check) {
				    Yii::app()->user->setFlash('error',' Error while sending email: '.$mail->getError());
				}
		}
		// exit();

		$this->render('index');


	}

	public function actionTest()
	{
		
		require_once __DIR__ . '/vendor/autoload.php';

		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML('<h1>Hello world!</h1>');
		$mpdf->Output();

	}

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

	
}