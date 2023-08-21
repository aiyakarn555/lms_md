<?php

class PasscoursController extends Controller
{

    public function filters() 
    {
        return array(
            'rights',
        );
    }

	public function actionIndex()
	{
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
		$model= new Passcours('search');
		$model->unsetAttributes();
		
		if(isset($_POST['Passcours'])) {
			
			$passcours = $_POST['Passcours'];
			$model = new Passcours('highsearch');

			//set attributes
			$model->generation = $passcours['generation'];
			$model->passcours_cours = $passcours['course_id'];
			$model->search = $passcours['search'];
			$model->period_start = $passcours['period_start'];
			$model->period_end = $passcours['period_end'];

		}
		//setstat
		Yii::app()->user->setState('ReportPassCours',$model);

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionReportPass() 
	{
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
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

	public function actionPasscoursLog() {

		$model = new CourseOnline('PrintFileStatic');
		$model->unsetAttributes();

		if(isset($_POST['Passcours'])) {
			$passcours = $_POST['Passcours'];
			if($passcours['period_end'] != null) {
				$model->period_start = $passcours['period_start'];
			}
			if($passcours['period_start'] != null) {
				$model->period_end = $passcours['period_end'];
			}
		}

		$this->render('passcours_log',array(
			'model'=>$model,
		));
	}

	public function actionCertificate() {

        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
		//get all $_POST data
		$PassCoursId = Yii::app()->request->getPost('CourseId');
		$UserId = Yii::app()->request->getPost('UserId');
		$CertificateType = Yii::app()->request->getPost('CertificateType');
		$Download = Yii::app()->request->getPost('Download');

		$model = Passcours::model()->find(array(
			'condition'=>'passcours_cours=:id AND passcours_user=:user','params' => array(
				':id' => $PassCoursId,
				':user' => $UserId
			)
	    ));

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
            'condition' => 'learn.user_id = ' . $UserId . ' AND course_id = ' . $PassCoursId,
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
            'condition' => 'user_id = ' . $UserId . ' AND course_id = ' . $PassCoursId . ' AND score_past = "y"',
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

	    if($model) {
			$fulltitle = $model->Profiles->ProfilesTitle->prof_title . $model->Profiles->firstname . " " . $model->Profiles->lastname;
	    	$setCertificateData = array(
	    		'fulltitle' => $fulltitle,
	    		'userAccountCode' => $userAccountCode,
	    		'courseTitle' => $model->CourseOnlines->course_title,
	    		'courseCode' => (isset($courseCode))?'รหัสหลักสูตร '.$courseCode:null,
	    		'courseAccountHour' => (isset($courseAccountHour))?$courseAccountHour:null,
	    		'courseEtcHour' => (isset($courseEtcHour))?$courseEtcHour:null,
	    		'startLearnDate' => $startDate,
	    		'endLearnDate' => $model->passcours_date,
	    		'courseDatePassOver60Percent' => $CourseDatePass,
	    		);

	    	//Print
		    // $mPDF = Yii::app()->ePdf->mpdf('th', 'A4-L', '0', 'dsnmtn');
	        // $mPDF->setDisplayMode('fullpage');
	        // $mPDF->setAutoFont();
			// $mPDF->AddPage('L');

			require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
			$mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
			
			$renderFile = 'certificate';
			if( $CertificateType == 'cpd' ) {
				$renderFile = 'certificate_cpd';
			}
			//encode html for UTF-8 before write to html
			// $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('cerfile/' . $renderFile, array('model'=>$setCertificateData), true), 'UTF-8', 'UTF-8'));
			
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
        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
	    $CheckPasscours = Passcours::model()->find(array(
			'condition'=>'passcours_cours=:id AND passcours_user=:user','params' => array(
				':id' => $id,
				':user' => $user
			)
	    ));
		if(isset($CheckPasscours))
		{
	        $mPDF = Yii::app()->ePdf->mpdf();
	        $mPDF->setDisplayMode('fullpage');
	        $mPDF->setAutoFont();
			$mPDF->AddPage('L');
	        $mPDF->WriteHTML($this->renderPartial('PrintPDF', array('model'=>$CheckPasscours), true));
	        $mPDF->Output();
		}
		else
		{
			throw new CHttpException(404,'The requested page does not exist.');
		}
	}
}
