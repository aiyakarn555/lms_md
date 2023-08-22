<?php

class PasscoursController extends Controller
{
	public function init()
	{
		// parent::init();
		// $this->lastactivity();
		if(Yii::app()->user->id == null){
				$this->redirect(array('site/index'));
			}
		
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
        	array('allow',  // allow all users to perform 'index' and 'view' actions
            	'actions' => array('PrintCertificate', 'PrintPDF', 'ajaxgetdepartment', 'ajaxgetposition', 'ajaxgetgenid', 'ExcelIndex', 'DownloadIndex'),
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

	public function actionIndex() { //รายงานผู้ผ่านการเรียน

		$model= new Passcours('search');
		$model->unsetAttributes();

		if(isset($_GET['Passcours'])) {

			$passcours = $_GET['Passcours'];
			$model = new Passcours('highsearch');

			$model->passcours_cours = $passcours['passcours_cours'];
			$model->gen_id = $passcours['gen_id'];
			$model->search = $passcours['search'];
			$model->type_register = $passcours['type_register'];			
			$model->department = $passcours['department'];
			$model->position = $passcours['position'];
			$model->period_start = $passcours['period_start'];
			$model->period_end = $passcours['period_end'];


		}
		
		//setstat
		Yii::app()->user->setState('ReportPassCours',$model);

		$this->render('index',array(
			'model'=>$model,
			'passcours'=>$passcours,
		));
	}

	public function actionExcelIndex() {

		$model= new Passcours('search');
		$model->unsetAttributes();

		if(isset($_GET['Passcours'])) {
			$model->attributes=$_GET['Passcours'];

		}

		$this->renderPartial('ExcelIndex', array(
            'model'=>$model
        ));
	}

	public function actionDownloadIndex(){

		$arr_Passcours = [];
		if(isset($_GET["val"])){
			$arr_Passcours = explode(",", $_GET["val"]);
		}


		$uploadDir = Yii::app()->getUploadPath(null);
		$path1 = "download_cer";
		$path2 = Yii::app()->user->id;

		if (!is_dir($uploadDir."../".$path1."/".$path2."/")) {
			mkdir($uploadDir."../".$path1."/".$path2."/", 0777, true);
		}else{
			$files = glob($uploadDir."../".$path1."/".$path2.'/*');
			foreach($files as $file){
				if(is_file($file)){
					unlink($file);
				}             
			}
		}


		$renderFile = 'Newcertificate';
		require_once __DIR__ . '/../vendors/mpdf7/autoload.php';


		foreach ($arr_Passcours as $keyy => $valuee) { // วนสร้าง pdf cer

			$model = Passcours::model()->findByPk($valuee);

			$PassCoursId = $model->passcours_cours;
			$UserId = $model->passcours_user;
			$gen_id = $model->gen_id;

			$certIdModel = CertificateNameRelations::model()->find(array('condition' => 'course_id = '.$PassCoursId));
			$certId = $certIdModel->cert_id;
			$modelSign = Certificate::model()->find(array('condition' => 'cert_id= '.$certId));
			$pageSide = $modelSign->cert_display;

			$modelSign2 = $modelSign->sign_id2;
			$model2 = Signature::model()->find(array('condition' => 'sign_id = '.$modelSign2));

			$CourseDatePassModel = Passcours::model()->find(array('condition' => 'passcours_user = '.$UserId.' AND gen_id="'.$gen_id.'" AND passcours_cours="'.$PassCoursId.'"'));
			$CourseDatePass = $CourseDatePassModel->passcours_date;
			$num_pass = PasscourseNumber::model()->find(array(
				'condition' => 'course_id=:course_id AND gen_id=:gen_id AND user_id=:user_id',
				'params' => array(':course_id'=>$CourseDatePassModel->passcours_cours, ':gen_id'=>$CourseDatePassModel->gen_id, ':user_id'=>$CourseDatePassModel->passcours_user,),
				'order' => 'id DESC',
			));
			$num_pass = $num_pass->code_number;
			$CoursePassedModel = Coursescore::model()->find(array(
				'condition' => 'user_id = ' . $UserId . ' AND course_id = ' . $PassCoursId . ' AND score_past = "y" AND gen_id="'.$gen_id.'"',
				'order' => 'create_date ASC'
			));

			if($CoursePassedModel) {
				$CourseDatePass = date('Y-m-d', strtotime($CoursePassedModel->create_date));
			}
			$lastPasscourse = Helpers::lib()->PeriodDate($CourseDatePass, true);
			$year_pass = date("y", strtotime($CourseDatePass));
			$format_date_pass = date('jS F Y', strtotime($lastPasscourse));
			$format_date_pass2 = date('d M Y', strtotime($lastPasscourse));

			$renderSign = $modelSign->signature->sign_path;
			$nameSign = $modelSign->signature->sign_title;
			$positionSign = $modelSign->signature->sign_position;

			$renderSign2 = $model2->sign_path;
			$nameSign2 = $model2->sign_title;
			$positionSign2 = $model2->sign_position;

			$fulltitle =  $model->Profiles->firstname . " " . $model->Profiles->lastname;
			$fulltitle_en =  $model->Profiles->firstname_en . " " . $model->Profiles->lastname_en;


			$setCertificateData = array(
				'fulltitle' => $fulltitle,
				'fulltitle_en' => $fulltitle_en,
				'cert_text' => $modelSign->cert_text,
				'courseTitle_en' => $model->CourseOnlines->course_title,
				'coursenumber' => $model->CourseOnlines->course_number,
				'renderSign' => $renderSign,
				'renderSign2' => $renderSign2,
				'nameSign' => $nameSign,
				'nameSign2' => $nameSign2,
				'positionSign' => $positionSign,
				'positionSign2' => $positionSign2,
				'bgPath' => $modelSign->cert_background,
				'format_date_pass' => $format_date_pass,
				'format_date_pass2' => $format_date_pass2,
				'year_pass' => $year_pass,
				'num_pass' => $num_pass,
				'pageSide' => $pageSide,
				'user' => $UserId,
				'course' => $PassCoursId,
				'gen' => $gen_id
			);


			if($modelSign->cert_display == '1'){
				$pageFormat = 'P';
			}else if($modelSign->cert_display == '3'){
				$pageFormat = 'P';
			} else {
				$pageFormat = 'L';
			}

			$mPDF = new \Mpdf\Mpdf(['format' => 'A4-'.$pageFormat]);
			$mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('cerfile/' . $renderFile, array('model'=>$setCertificateData), true), 'UTF-8', 'UTF-8'));
			$mPDF->Output('..\uploads\\'.$path1.'\\'.$path2."\\".$model->user->username.'_cer'.'.pdf', 'F');
			// $mPDF->Output();

		} // foreach ($model


		$files = glob(Yii::app()->getUploadPath(null)."../".$path1."/".$path2.'/*'); //วนเก็บที่อยู่ file cer
		if(!empty($files)){
			foreach ($files as $key => $value) {
				$path_zip[] = "../uploads/".$path1."/".$path2."/".basename($value);	
				$name_file[] = basename($value);	
			}		
		}


		if(!empty($path_zip)){
			$zip = Yii::app()->zip;
			$path_in_zip = "..\uploads\\".$path1.'\\'.$path2."\\";
			$name_zip = "certificate_".date("YmdHis").".zip";

			foreach ($path_zip as $key => $link_file) { // วน zip file
				$zip->makeZip_nn($link_file, $path_in_zip.$name_zip, $name_file[$key]);
			}

			$file_in_folder = glob(Yii::app()->getUploadPath(null)."..\\".$path1."\\".$path2."\\"."\\*");
			foreach($file_in_folder as $file_in){
				if(is_file($file_in)){
					$file = basename($file_in); 
					if($file == $name_zip){
						// echo "..\..\..\uploads\\".$path1."\\".$path2."\\".$name_zip;
						$this->redirect(array('../../uploads/'.$path1."/".$path2."/".$name_zip));
						exit();
					}
				}
			}
		}else{
			echo "ไม่มีข้อมูล";
			exit();
		}

		// var_dump($model); exit();

	}


	public function actionPasscoursLog() {

		$model = new PasscoursLog('search');

		if(isset($_GET['PasscoursLog'])) {

			$model->attributes = $_GET['PasscoursLog'];

		}

		$this->render('passcours_log',array(
			'model'=>$model,
		));
	}

	public function actionGenExcelPasscoursLog() {

		$model = new PasscoursLog('search');
		if(isset($_GET['PasscoursLog'])) {

			$model->attributes = $_GET['PasscoursLog'];
			
		}

		$this->renderPartial('ExcelPasscoursLog', array(
            'model'=>$model
        ));
	}














	public function actionReportPass() 
	{
	    $model = new Passcours('search');
	    $model->unsetAttributes();

        if(Yii::app()->user->getState('ReportPassCours'))
        {
        	$model = Yii::app()->user->getState('ReportPassCours');
        }

	    if (isset($_GET['export'])) 
	    {
	        $production = 'export';
	    } 
	    else 
	    {
	        $production = 'grid';
	    }

	    $this->render('reportpass', array('model' => $model, 'production' => $production));
	} 

	public function loadModel($id)
	{
		$model=Passcours::model()->passcourscheck()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}	

		

	public function actionPrintCertificate() {

		//get all $_POST data
		$PassCoursId = Yii::app()->request->getPost('CourseId');
		$UserId = Yii::app()->request->getPost('UserId');
		$gen_id = Yii::app()->request->getPost('gen_id');
		$CertificateType = Yii::app()->request->getPost('CertificateType');
		$Download = Yii::app()->request->getPost('Download');
		$model = Passcours::model()->find(array(
			'condition'=>'passcours_cours=:id AND passcours_user=:user AND gen_id=:gen_id',
			'params' => array(
				':id' => $PassCoursId,
				':user' => $UserId,
				':gen_id' => $gen_id
			)
	    ));
	    // var_dump($model); exit();
	    // var_dump($PassCoursId); 
	    // var_dump($UserId); 
	    // var_dump($gen_id); 
	    // exit();
	    //set default text + data
		$PrintTypeArray = array( 
            '2' => array( 'text' => 'ผู้ทำบัญชีรหัสเลขที่', 'id' => $model->user->bookkeeper_id ), 
            '3' => array( 'text' => 'ผู้สอบบัญชีรับอนุญาต เลขทะเบียน', 'id' => intval($model->user->auditor_id) )
        );

        //set user type
        switch ($model->Profiles->type_user) {
        	case '1':
        		$userAccountCode = null;
        		break;
        	case '4':
        		$userAccountCode = $PrintTypeArray['2']['text'] . ' ' . $PrintTypeArray['2']['id'] . ' ' . $PrintTypeArray['3']['text'] . ' ' . $PrintTypeArray['3']['id'];
        		break;
        	default:
        		$userAccountCode = $PrintTypeArray[$model->Profiles->type_user]['text'] . ' ' . $PrintTypeArray[$model->Profiles->type_user]['id'];
        		break;
        }

        //get start & end learn date of current course
        $StartDateLearnThisCourse = Learn::model()->with('LessonMapper')->find(array(
            'condition' => 'learn.user_id=:user_id AND learn.course_id =:course_id AND learn.gen_id=:gen_id',
            'params' => array(':user_id' => $UserId,':course_id'=>$PassCoursId, ':gen_id'=>$gen_id),
            'alias' => 'learn',
            'order' => 'learn.create_date ASC',
        ));
        $startDate = $StartDateLearnThisCourse->learn_date;
        if($StartDateLearnThisCourse->create_date){
			$startDate = $StartDateLearnThisCourse->create_date;
		}
        //

        //get date passed final test **future change
        $CourseDatePass = null;
        $CoursePassedModel = Coursescore::model()->find(array(
            'condition' => 'user_id = ' . $UserId . ' AND course_id = ' . $PassCoursId . ' AND score_past = "y" AND gen_id="'.$gen_id.'"',
            'order' => 'create_date ASC'
        ));
        //Pass Course Date
        $CourseDatePassModel = Passcours::model()->find(array('condition' => 'passcours_user = '.$UserId.' AND gen_id="'.$gen_id.'" AND passcours_cours="'.$PassCoursId.'"'));
        $CourseDatePass = $CourseDatePassModel->passcours_date;


        $num_pass = PasscourseNumber::model()->find(array(
        	'condition' => 'course_id=:course_id AND gen_id=:gen_id AND user_id=:user_id',
        	'params' => array(':course_id'=>$CourseDatePassModel->passcours_cours, ':gen_id'=>$CourseDatePassModel->gen_id, ':user_id'=>$CourseDatePassModel->passcours_user,),
        	'order' => 'id DESC',
        ));
        $num_pass = $num_pass->code_number;

        $identification= null;
        $identification = Profiles::model()->find(array(
            'condition' => 'user_id = ' . $UserId,
         ));

         // var_dump($identification['identification']);exit();


         // $CourseDatePass = null;
        $CoursePassedModel = Coursescore::model()->find(array(
            'condition' => 'user_id = ' . $UserId . ' AND course_id = ' . $PassCoursId . ' AND score_past = "y" AND gen_id="'.$gen_id.'"',
            'order' => 'create_date ASC'
        ));

        if($CoursePassedModel) {
			$CourseDatePass = date('Y-m-d', strtotime($CoursePassedModel->create_date));
		}
		//

        //get period when test score over thai 60 percent **remark select just only first time
        if($model->Period) {
        	foreach($model->Period as $i => $PeriodTime) {
        		if( $CourseDatePass >= $PeriodTime->startdate && $CourseDatePass <= $PeriodTime->enddate ) {
        			$courseCode = $PeriodTime->code;
        			$courseAccountHour = $PeriodTime->hour_accounting;
        			$courseEtcHour = $PeriodTime->hour_etc;
        		}
        	}
        }

        $course_check_sign = array('170','174','186','187','188','189','190','191','192','193','194');

        //cert_id 1 or 2 or ......
		$certIdModel = CertificateNameRelations::model()->find(array('condition' => 'course_id = '.$PassCoursId));
		$certId = $certIdModel->cert_id;

        $modelSign = Certificate::model()->find(array('condition' => 'cert_id= '.$certId));
        $modelSign2 = $modelSign->sign_id2;

        if($modelSign->cert_display == '1'){
			$pageFormat = 'P';
		}else if($modelSign->cert_display == '3'){
			$pageFormat = 'P';
		} else {
			$pageFormat = 'L';
		}

		$pageSide = $modelSign->cert_display;

        $model2 = Signature::model()->find(array('condition' => 'sign_id = '.$modelSign2)); 
         // var_dump($model2);exit();
        // $modelSign2 = signature::model()->find(array('condition' => 'sign_id = '.$model->sign_id2));       
        
        // $renderFile = 'certificate';
        $renderFile = 'Newcertificate';

        if( $CertificateType == 'cpd' ) {
            $renderFile = 'certificate_cpd';
            $renderSign = 'dbd_certificate_dbd_sign.png';
            $nameSign = 'นางโสรดา เลิศอาภาจิตร์';
            $positionSign = 'ผู้อำนวยการกองกำกับบัญชีธุรกิจ';
        } else {
            if(in_array($PassCoursId,$course_check_sign)){
                $renderSign = 'dbd_certificate_sign_2.png';
                $nameSign = 'ม.ล. ภู่ทอง  ทองใหญ่';
            	$positionSign = 'ผู้อำนวยการกองพัฒนาผู้ประกอบธุรกิจ';
            } else {
                $renderSign = 'dbd_certificate_sign.png';
                $nameSign = 'นายธานี  โอฬารรัตน์มณี';
            	$positionSign = 'ผู้อำนวยการกองพาณิชย์อิเล็กทรอนิกส์';
            }
        }

        $renderSign = $modelSign->signature->sign_path;
        // var_dump($renderSign);exit();
		$nameSign = $modelSign->signature->sign_title;
		$positionSign = $modelSign->signature->sign_position;

		$renderSign2 = $model2->sign_path;
		$nameSign2 = $model2->sign_title;
		$positionSign2 = $model2->sign_position;

		$modelUser = Users::model()->find(array('condition' => 'id = '.$UserId));
		$positionUser = $modelUser->position->position_title;
		$companyUser = $modelUser->company->company_title;
		$logStartTime = LogStartcourse::model()->findByAttributes(array('user_id' => $UserId,'course_id'=> $PassCoursId));

		$startLogDate = Helpers::lib()->PeriodDate($logStartTime->start_date,false);
		$endLogDate = Helpers::lib()->PeriodDate($logStartTime->end_date,true);

		$ckMonthStart = explode(' ', $startLogDate);
		$ckMonthEnd = explode(' ', $endLogDate);
		if($ckMonthStart[1] == $ckMonthEnd[1]){
			$period = $ckMonthStart[0]." - ".$ckMonthEnd[0]." ".$ckMonthStart[1]." ".$ckMonthEnd[2];
		}else{
			$period = $startLogDate." - ".$endLogDate;
		}
		$model->CourseOnlines->course_date_end =  Helpers::lib()->PeriodDate($model->CourseOnlines->course_date_end,true);
		$lastPasscourse = Helpers::lib()->PeriodDate($CourseDatePass, true);
		$year_pass = date("y", strtotime($CourseDatePass));


		$format_date_pass = date('jS F Y', strtotime($lastPasscourse));
		$format_date_pass2 = date('d M Y', strtotime($lastPasscourse));

	    if($model) {
			// $fulltitle = $model->Profiles->ProfilesTitle->prof_title . $model->Profiles->firstname . " " . $model->Profiles->lastname;
			$fulltitle =  $model->Profiles->firstname . " " . $model->Profiles->lastname;
			$fulltitle_en =  $model->Profiles->firstname_en . " " . $model->Profiles->lastname_en;
	    	$setCertificateData = array(
	    		'fulltitle' => $fulltitle,
	    		'fulltitle_en' => $fulltitle_en,
				'cert_text' => $modelSign->cert_text,
	    		'userAccountCode' => $userAccountCode,
	    		'courseTitle_en' => $model->CourseOnlines->course_title,
	    		'coursenumber' => $model->CourseOnlines->course_number,
	    		'courseCode' => (isset($courseCode))?'รหัสหลักสูตร '.$courseCode:null,
	    		'courseAccountHour' => (isset($courseAccountHour))?$courseAccountHour:null,
	    		'courseEtcHour' => (isset($courseEtcHour))?$courseEtcHour:null,
	    		// 'startLearnDate' => $startDate,
	    		'startLearnDate' => $logStartTime->start_date,
	    		// 'endLearnDate' => $model->passcours_date,
	    		'endLearnDate' => $logStartTime->end_date,
	    		'period' => $period,
	    		'endDateCourse' => $model->CourseOnlines->course_date_end,
	    		'courseDatePassOver60Percent' => $CourseDatePass,
	    		'renderSign' => $renderSign,
	    		'renderSign2' => $renderSign2,
	    		'nameSign' => $nameSign,
	    		'nameSign2' => $nameSign2,
	    		'positionSign' => $positionSign,
	    		'positionSign2' => $positionSign2,
	    		'bgPath' => $modelSign->cert_background,
	    		'identification' => $identification['identification'],
	    		'positionUser' => $positionUser,
	    		'format_date_pass' => $format_date_pass,
	    		'format_date_pass2' => $format_date_pass2,
	    		'year_pass' => $year_pass,
	    		'num_pass' => $num_pass,
	    		'companyUser' => $companyUser,
	    		'pageSide' => $pageSide,
	    		'user' => $UserId,
                'course' => $PassCoursId,
                'gen' => $gen_id
	    		);
	    	// // var_dump($model->identification);exit();
	    	// //Print
		    // $mPDF = Yii::app()->ePdf->mpdf('th', 'A4-L', '0', 'thdanvivek');
	        // $mPDF->setDisplayMode('fullpage');
	        // $mPDF->setAutoFont();
			// $mPDF->AddPage('L');

			// //encode html for UTF-8 before write to html

			// $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('cerfile/' . $renderFile, array('model'=>$setCertificateData), true), 'UTF-8', 'UTF-8'));
			
			require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
			$mPDF = new \Mpdf\Mpdf(['format' => 'A4-'.$pageFormat]);
			// $mPDF = new \Mpdf\Mpdf(['orientation' => $pageFormat]);
			$mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('cerfile/' . $renderFile, array('model'=>$setCertificateData), true), 'UTF-8', 'UTF-8'));

	        //save log private function saveCertificateLog()
	        self::savePassCourseLog('Print', $model->passcours_id);

	        //output
			if($Download) {
				$mPDF->Output($fulltitle.'.pdf', 'D');
			} else {
				$mPDF->Output();
			}
	        
	    } else {
	    	throw new CHttpException( 404, 'The requested page does not exist.' );
	    }

	}

	private function savePassCourseLog($action, $passcours_id) {

		if(Yii::app()->user->id) {
			$model = new PasscoursLog();
			//set model data
			$model->pclog_userid = Yii::app()->user->id;
			$model->pclog_event = $action;
			$model->pclog_target = $passcours_id;
			$model->pclog_date = date('Y-m-d H:i:s');

			//save
			if(!$model->save()) {
				throw new CHttpException( 404, 'The requested page does not exist.' );
			}
		}
	}

	public function actionPrintPDF($id,$user) {
	    $CheckPasscours = Passcours::model()->find(array(
			'condition'=>'passcours_cours=:id AND passcours_user=:user','params' => array(
				':id' => $id,
				':user' => $user
			)
	    ));
		if(isset($CheckPasscours))
		{
	        // $mPDF = Yii::app()->ePdf->mpdf();
	        // $mPDF->setDisplayMode('fullpage');
	        // $mPDF->setAutoFont();
			// $mPDF->AddPage('L');
	        // $mPDF->WriteHTML($this->renderPartial('PrintPDF', array('model'=>$CheckPasscours), true));
			// $mPDF->Output();
			
			require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
			$mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
			$mPDF->WriteHTML($this->renderPartial('PrintPDF', array('model'=>$CheckPasscours), true));
			$mPDF->Output();
		}
		else
		{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}




	public function actionajaxgetdepartment(){
		if(isset($_POST["value"]) && $_POST["value"] != ""){
			$department = Department::model()->findAll(array(
				'condition' => 'active = "y" AND type_employee_id="'.$_POST["value"].'"',
				'order' => 'dep_title ASC'
			));


			?>
			<option value="">ทั้งหมด</option>
			<?php
			if(!empty($department)){				
				foreach ($department as $key => $value) {
					?>
					<option value="<?= $value->id ?>"><?= $value->dep_title ?></option>
					<?php
				}
			}
		}
	}

	public function actionajaxgetposition(){
		if(isset($_POST["value"]) && $_POST["value"] != ""){
			$position = Position::model()->findAll(array(
				'condition' => 'active = "y" AND department_id="'.$_POST["value"].'"',
				'order' => 'position_title ASC'
			));


			?>
			<option value="">ทั้งหมด</option>
			<?php
			if(!empty($position)){				
				foreach ($position as $key => $value) {
					?>
					<option value="<?= $value->id ?>"><?= $value->position_title ?></option>
					<?php
				}
			}
		}
	}

	public function actionajaxgetgenid(){
		if(isset($_POST["value"]) && $_POST["value"] != ""){


			$course_gen = CourseGeneration::model()->findAll(array(
				'condition' => 'course_id=:course_id AND active=:active ',
				'params' => array(':course_id'=>$_POST["value"], ':active'=>"y"),
				'order' => 'gen_title ASC',
			));

			if(empty($course_gen)){
				$course_gen[0]->gen_id = 0;
				$course_gen[0]->gen_title = "ไม่มีรุ่น";
			}


			?>
			<option value="">กรุณาเลือกรุ่น</option>
			<?php
			if(!empty($course_gen)){				
				foreach ($course_gen as $key => $value) {
					?>
					<option value="<?= $value->gen_id ?>"><?= $value->gen_title ?></option>
					<?php
				}
			}
		}
	}





}
