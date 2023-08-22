<?php

class CertificateController extends Controller
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
            	'actions' => array('index', 'view', 'coursemodal','create','multidelete','active','delImg','savecoursemodal','certificatedisplay'),
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
		$model = new Certificate;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		// var_dump($model->cert_display);exit();
		if(isset($_POST['Certificate']))
		{
			// $model->attributes=$_POST['Certificate'];
			$model->cert_name=$_POST['Certificate']['cert_name'];
			$model->cert_type = $_POST['Certificate']['cert_type'];
			$model->sign_id= 0;
			$model->sign_id2= $_POST['Certificate']['sign_id2'];
			$model->cert_text = $_POST['Certificate']['cert_text'];

			// $cert_background = Slim::getImages('cert_background');
			// $path =  Yii::app()->basePath."/../../uploads/certificate/";
			
			// $signature_array =array();
			if($model->validate()){
				// if($cert_background){ 
				// 	$model->cert_background = Helpers::lib()->uploadImage($cert_background,$path);
				// }

				// var_dump($model->attributes);exit();
				if($model->save(false)){
					if(Yii::app()->user->id){
						Helpers::lib()->getControllerActionId();
					}
					$this->redirect(array('index'));
				}
			}
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
		$imageShow = $model->cert_background;
		
		if(isset($_POST['Certificate']))
		{
			$model->cert_name=$_POST['Certificate']['cert_name'];
			$model->cert_type = $_POST['Certificate']['cert_type'];
			$model->sign_id= 0;
			$model->sign_id2= $_POST['Certificate']['sign_id2'] != null ? $_POST['Certificate']['sign_id2'] : 0;
			$model->cert_text = $_POST['Certificate']['cert_text'];
	
			if($model->save()){
				if(Yii::app()->user->id){
					Helpers::lib()->getControllerActionId($model->cert_id);
				}
				$this->redirect(array('view','id'=>$model->cert_id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionSaveCourseModal() {
		$certificate = $_POST['certificateId'];
		$saveCourseApplied = json_decode($_POST['checkedList']);
		$model = CertificateNameRelations::model()->deleteAll(array(
			'condition'=>'cert_id = "'.$certificate.'"'
		));
		if($saveCourseApplied) {
			foreach ($saveCourseApplied as $course) {
				$model = CertificateNameRelations::model()->deleteAll(array(
					'condition'=>'course_id = "'.$course.'"'
				));
				$model = new CertificateNameRelations;
				$model->course_id = $course;
				$model->cert_id = $certificate;
				$model->save();
			}
		} 
		echo true;
	}
	

	public function actionCertificateDisplay($id,$sid,$user_id=null,$course_id=null){
		
		if($user_id != null && $course_id != null ){
			$user = Users::model()->findByPk($user_id);
			$profile = profiles::model()->findByPk($user_id);

			//position
			$position_id = $user->position_id;
			$position = Position::model()->find(array('condition' => 'id = '.$position_id));
			$position_title = $position->position_title;

			//Company
			$company_id = $user->company_id;
			$company = company::model()->find(array('condition' => 'company_id = '.$company_id));
			$company_title = $company->company_title;

			//Name
			$title_id = $profile->title_id;
			$profilesTitle = ProfilesTitle::model()->find(array('condition' => 'prof_id = '.$title_id));
			$titleName = $profilesTitle->prof_title;

			$fullName = $titleName."".$profile->getFullname();
			// $fullName = $user->profile->ProfilesTitle->prof_title ." ". $user->profile->firstname . " " . $user->profile->lastname;
			$course = CourseOnline::model()->findByPk($course_id);
			$courseTitle = $course->course_title;
			$courseNumber = $course->course_number;

			$CoursePassedModel = Passcours::model()->find(array(
				'condition' => 'passcours_user=:user_id AND passcours_cours=:course_id',
				'params' => array(':user_id' => $user_id,':course_id' => $course_id)
			));
			$lastPasscourse = $CoursePassedModel->passcours_date;
			
			if($CoursePassedModel) {
				$CourseDatePass = date('Y-m-d', strtotime($CoursePassedModel->passcours_date));
			}
		} 
		$model = Certificate::model()->find(array('condition' => 'cert_id='.$id));
		$model2 = Signature::model()->find(array('condition' => 'sign_id = '.$model->sign_id2));

		 // var_dump($CoursePassedModel);exit();
		$pageFormat = 'P';
		$renderSign = $model->signature->sign_path;
		$nameSign = $model->signature->sign_title;
		$positionSign = $model->signature->sign_position;

		$renderSign2 = $model2->sign_path;
		$nameSign2 = $model2->sign_title;
		$positionSign2 = $model2->sign_position;

		// วันที่เรียนจบ
		$CoursePassedModel->passcours_date = "2020-12-10";
		$format_date_pass = date('jS F Y', strtotime($CoursePassedModel->passcours_date));
		$format_date_pass2 = date('d M Y', strtotime($CoursePassedModel->passcours_date));
		
		$fullName = "MR. TEST ADMIN";
		$date_couse = "22 JULY 2021 to 24 JULY 2021";
		if($model->cert_type == 1){
			$bgPath = "certificate-md-1.jpg";
		}else{
			$bgPath = "certificate-md-2.jpg";
		}


		if($model->cert_text){
			$cert_text = $model->cert_text;
		}else{
			$cert_text = "This course complies with the requirements of regulation VI/1 of the
        International Convention on Standard of Training Certification and 
        Watchkeeping for seafarers, 1978 as amended in 2010. The Marine
        Department of the Kingdom of Thailand has approved this course
        on 21 July 2021.";
		}

		

        $certType = $model->cert_type;


		if($model) {
			$setCertificateData = array(
				'fulltitle' => $fullName,
				'courseTitle' => $courseTitle,
				'cert_text' => $cert_text,
				'lastPasscourse' => $lastPasscourse,
				'courseNumber'=>$courseNumber,
				'renderSign' => $renderSign,
				'nameSign' => $nameSign,
				'positionSign' => $positionSign,
				'renderSign2' => $renderSign2,
				'nameSign2' => $nameSign2,
				'positionSign2' => $positionSign2,
				'certType' => $certType,
				'pageFormat' => $pageFormat,
				'pageSide' => $model->cert_display,
				'bgPath' => $bgPath,
				'courseDatePass' => $format_date_pass,
				'format_date_pass2' => $format_date_pass2,
			);

			require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
			// $mPDF = new \Mpdf\Mpdf(['orientation' => $pageFormat]);
			$mPDF = new \Mpdf\Mpdf(['format' => 'A4-'.$pageFormat]);
			$mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('display', array('model'=>$setCertificateData), true), 'UTF-8', 'UTF-8'));
			
			if($filepath==null){
				$mPDF->Output();
			}else{
				$mPDF->Output($filepath,'F');
			}
		} else {
			throw new CHttpException( 404, 'The requested page does not exist.' );
		}
	}

	public function actionCourseModal() {
		$respon = '';
		$certificateId = $_POST['certificateId'];

		if($certificateId != null) {
			// $getAllCourse = CourseOnline::model()->findAll();
			$getAllCourse = CourseOnline::model()->findAll(array(
				'condition'=>'lang_id = 1 AND active = "y"'
			));
			$model = CertificateNameRelations::model()->findAll(array(
				'condition'=>'cert_id = "'.$certificateId.'"'
			));
			$mtId = array();
			foreach ($model as $key => $value) {
				$mtId[$key] = $value->course_id;
			}
			if($getAllCourse) {
				$respon .= '<table class="table table-striped">';
				$respon .= '<input type="hidden" name="cert_id" value="' . $certificateId . '">';
				$respon .= '<tr>';
				$respon .= '<th style="width:90px;"><input type="checkbox" id="checkAll" /> ทั้งหมด</th>';
				$respon .= '<th>ชื่อหลักสูตร</th>';
				$respon .= '</tr>';
				foreach ($getAllCourse as $course) {
					$checked = '';
					if(in_array($course['course_id'], $mtId)){
						$checked = 'checked';
					}
					$respon .= '<tr>';
					$respon .= '<td>';
					$respon .= '<input class="courseCheckList" type="checkbox" ' . $checked . ' value="' . $course['course_id'] . '"> ';
					$respon .= '</td>';
					$respon .= '<td>';
					$respon .= $course['course_title'];
					$respon .= '</td>';
					$respon .= '</tr>';
				}
				$respon .= '</table>';
			}
			$respon .= "<script>
			$('#checkAll').change(function () {
				$('input:checkbox').prop('checked', $(this).prop('checked'));
			});
			</script>";
		}
		echo $respon;	
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        // Page
		$model=new Certificate('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Certificate']))
			$model->attributes=$_GET['Certificate'];
		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Certificate the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		// $model = Certificate::model()->certificatecheck()->findByPk($id);
		$model = Certificate::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function actionDelete($id)
	{
        //$this->loadModel($id)->delete();
		$model = $this->loadModel($id);
		$model->active = 'n';
		if($model->cert_background != ''){
			$path = Yii::app()->basePath . "/../../uploads/certificate/";
			@unlink($path . $model->cert_background);
			$model->cert_background = null;
		}
		$model->update();
		if(Yii::app()->user->id){
			Helpers::lib()->getControllerActionId();
		}
		if(!isset($_GET['ajax']))
			$this->redirect(array('index'));
	}

	public function actionMultiDelete()
	{
		header('Content-type: application/json');
		if(isset($_POST['chk']))
		{
			foreach($_POST['chk'] as $val)
			{
				$this->actionDelete($val);
			}
		}
	}

	public function actionActive($id){
		$model = Certificate::model()->findByPk($id);
		if($model->cert_hide == 1){
			$model->cert_hide = 0;
			$model->save(false);
		} else {
			$model->cert_hide = 1;
			$model->save(false);
		}
		$this->redirect(array('/Certificate/index'));
	}

	public function actionDelImg()
	{
		$id = $_POST['id'];
		$model = Certificate::model()->findByPk($id);
		if(!empty($model)){
			$path = Yii::app()->basePath . "/../../uploads/certificate/";
			@unlink($path . $model->cert_background);
			$model->cert_background = null;
			$model->update();
		}
		echo true;
	}
	public function actionTest()
	{
		// $subject = "แจ้งเตือนหลักสูตรกำลังจะหมดอายุ";
		// $message = "TEST EMAIL";
		// Helpers::lib()->SendMailNotification($subject,$message,1);
		$to['email'] = 'aiyakarn2540@gmail.com';
		$to['firstname'] = 'aaaaaa';
		$to['lastname'] = 'bbbb';
		$message = "TESTTEST";
		$send = Helpers::lib()->SendMailNotification($to,'อนุมัติการสมัครสมาชิก',$message);
	}

	public function actionTest3()
	{
		$subject = "แจ้งเตือนหลักสูตรกำลังจะหมดอายุ";
		$message = "TEST EMAIL";
		Helpers::lib()->SendMailNotification2($subject,$message,2);
	}

	public function actionEmail()
	{
		$email = 'bws.rom3@gmail.com';
		$user = Users::model()->findByPk(181);
		$user->department_id = 1;
		$user->save(false);
		var_dump($user);exit();
	}

	public function actionAlluser()
	{
		$user = Users::model()->findAll();
		var_dump($user);exit();
	}

	public function actionEdituser()
	{
		$user = Users::model()->findByPk(1);
		$user->type_register = 2;
		$user->save(false);
		//
	}

	public function actionEdittype()
	{
		$type = TypeUser::model()->findByPk(1);
		$type->active = 0;
		$type->save(false);

		$type = TypeUser::model()->findByPk(4);
		$type->active = 0;
		$type->save(false);
		// $type = TypeUser::model()->findByPk(2);
		// $type->name = 'สมาชิกทั่วไป';
		// $type->save(false);

		// $type = TypeUser::model()->findByPk(3);
		// $type->name = 'บุคคลากรภายใน';
		// $type->save(false);
	}

	public function actionDeletelog(){
		// $model = Users::model()->deleteAll(array(
		// 	'condition'=>'id = 163'
		// ));
		$criteria = new CDbCriteria;
        $criteria->compare('user_id',167);
        $logStart = LogStartcourse::model()->deleteAll($criteria);
	}
	public function actionDisplaylog(){
		$criteria = new CDbCriteria;
        $criteria->compare('user_id',167);
        $logStart = LogStartcourse::model()->findAll($criteria);
        var_dump($logStart);
        exit();
	}

	public function actionTest2()
	{
		echo '<pre>';
		require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
		$mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
		var_dump($mPDF);exit();
	}



	
	/**
	 * Performs the AJAX validation.
	 * @param Certificate $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='certificate-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
