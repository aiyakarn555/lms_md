<?php

class PasscpdController extends Controller {

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

    public function actionIndex() {
        $model = new Passcours('highsearch');
//        $model = new Coursescore();
        $model->unsetAttributes();
//        $model->cate_id = '36';
//        $model->news_per_page = 25;
        if (isset($_GET['Passcours'])) {
//
            $passcours = $_GET['Passcours'];
//			$model = new Passcours('highsearch');
            //set attributes
            $model->generation = $passcours['generation'];
            $model->passcours_cours = $passcours['course_id'];
            $model->search = $passcours['search'];
            $model->memtype = $passcours['memtype'];
            $model->period_start = $passcours['period_start'];
            $model->period_end = $passcours['period_end'];
        }
        $sqlUser = " SELECT title_id,firstname,lastname,bookkeeper_id,auditor_id,username,auditor_id,address,province,email,phone,tbl_coursescore.course_id,tbl_coursescore.user_id ,
passcours_date,tbl_category.special_category,pic_cardid,create_at,tbl_type_user.name,tbl_type_user.id,type_user,tbl_coursescore.create_date as pass_60_date,course_title
            FROM tbl_coursescore 
            INNER JOIN tbl_profiles ON tbl_coursescore.user_id = tbl_profiles.user_id 
            INNER JOIN tbl_users ON tbl_coursescore.user_id = tbl_users.id
            INNER JOIN tbl_course_online ON tbl_course_online.course_id = tbl_coursescore.course_id
            LEFT JOIN tbl_category ON tbl_course_online.cate_id = tbl_category.cate_id
            LEFT JOIN tbl_type_user ON tbl_type_user.id = tbl_profiles.type_user
            LEFT JOIN tbl_passcours ON tbl_passcours.passcours_cours = tbl_coursescore.course_id and tbl_passcours.passcours_user = tbl_coursescore.user_id
            WHERE tbl_course_online.cate_id = '36' and score_past = 'y'

";
        
                if(isset($model->search) && $model->search != null) {
//			$criteria->compare('Profiles.firstname', $model->search, true);
//			$criteria->compare('Profiles.lastname', $model->search, true, 'OR');
//			$criteria->compare('user.bookkeeper_id', $model->search, true, 'OR');
                        $sqlUser .= " AND (tbl_profiles.firstname like '%".$model->search."%' OR tbl_profiles.lastname like '%".$model->search."%' OR tbl_users.username like '%".$model->search."%' )";
		}

                //check course category type
//		if(isset($model->cate_id) && $model->cate_id != null) {
////			$criteria->compare('courseonline.cate_id', $model->cate_id, false, 'AND');
//                        $sqlUser .= " AND tbl_course_online.cate_id = '".$model->cate_id."' ";
//		}
                
		//check generation
		if(isset($model->generation) && $model->generation != null) {
//			$criteria->compare('Profiles.generation', $model->generation, true, 'OR');
                        $sqlUser .= " AND tbl_profiles.generation = '".$model->generation."' ";
		}

		//check course id
		if(isset($model->passcours_cours) && $model->passcours_cours != null && $model->passcours_cours[0]!='') {
//			$criteria->addInCondition('passcours_cours', $model->passcours_cours, 'AND');
                        $sqlUser .= " AND tbl_coursescore.course_id IN (".implode(",",$model->passcours_cours).") ";
		}
        //check memtype
if(isset($model->memtype) && $model->memtype != null) {
//          $criteria->compare('Profiles.generation', $model->generation, true, 'OR');
                        $sqlUser .= " AND tbl_type_user.id = '".$model->memtype."' ";
        }


		//check period start - end
		if(isset($model->period_start) && $model->period_start != null) {
//			$criteria->addCondition('passcours_date >= "' . date('Y-m-d 00:00:00', strtotime($model->period_start)) . '"');
//                        $sqlUser .= " AND tbl_passcours.passcours_date >= '".date('Y-m-d 00:00:00', strtotime($model->period_start))."' ";
                        $sqlUser .= " AND tbl_coursescore.create_date >= '".date('Y-m-d 00:00:00', strtotime($model->period_start))."' ";
		}
		if(isset($model->period_end) && $model->period_end != null) {
//			$criteria->addCondition('passcours_date <= "' . date('Y-m-d 23:59:59', strtotime($model->period_end)) . '"');
//                        $sqlUser .= " AND tbl_passcours.passcours_date <= '".date('Y-m-d 23:59:59', strtotime($model->period_end))."' ";
                        $sqlUser .= " AND tbl_coursescore.create_date <= '".date('Y-m-d 23:59:59', strtotime($model->period_end))."' ";
		}
        
            $sqlUser .= " GROUP BY tbl_coursescore.course_id,tbl_coursescore.user_id ORDER BY pass_60_date asc";
//                if(!empty($_GET)){
//                    var_dump($sqlUser);exit();
//                }

        // $item_count = Yii::app()->db->createCommand($sqlUser)->queryScalar();
        $modelAll = Yii::app()->db->createCommand($sqlUser)->queryAll();
        $dataProvider=new CArrayDataProvider($modelAll, array(
                'pagination'=>array(
                  'pageSize'=>25
                ),
          ));
//        
//        $dataProvider_ex=new CArrayDataProvider($modelAll, array(
//                'pagination'=>false,
//          ));
        
        //setstat
        Yii::app()->user->setState('ReportPassCours', $model);
        $this->render('index', array(
            'model' => $model,
            'search' => $passcours,
            'dataProvider' => $dataProvider,
//            'dataProvider_ex' => $dataProvider_ex
        ));
    }
    
    public function actionExport_excel(){
        $this->layout = FALSE;
        
        $model = new Passcours('highsearch');
//        $model = new Coursescore();
        $model->unsetAttributes();
//        $model->cate_id = '36';
//        $model->news_per_page = 25;
        if (isset($_GET['Passcours'])) {
//
            $passcours = $_GET['Passcours'];
//			$model = new Passcours('highsearch');
            //set attributes
            $model->generation = $passcours['generation'];
            $model->passcours_cours = $passcours['course_id'];
            $model->search = $passcours['search'];
            $model->period_start = $passcours['period_start'];
            $model->period_end = $passcours['period_end'];
            $model->memtype = $passcours['memtype'];
        }
        
        $sqlUser = " SELECT title_id,firstname,lastname,bookkeeper_id,auditor_id,username,auditor_id,address,province,email,phone,tbl_coursescore.course_id,tbl_coursescore.user_id ,
passcours_date,tbl_category.special_category,pic_cardid,create_at,tbl_type_user.name,tbl_type_user.id,type_user,tbl_coursescore.create_date as pass_60_date,course_title
            FROM tbl_coursescore 
            INNER JOIN tbl_profiles ON tbl_coursescore.user_id = tbl_profiles.user_id 
            INNER JOIN tbl_users ON tbl_coursescore.user_id = tbl_users.id
            INNER JOIN tbl_course_online ON tbl_course_online.course_id = tbl_coursescore.course_id
            LEFT JOIN tbl_category ON tbl_course_online.cate_id = tbl_category.cate_id
            LEFT JOIN tbl_type_user ON tbl_type_user.id = tbl_profiles.type_user
            LEFT JOIN tbl_passcours ON tbl_passcours.passcours_cours = tbl_coursescore.course_id and tbl_passcours.passcours_user = tbl_coursescore.user_id
            WHERE tbl_course_online.cate_id = '36' and score_past = 'y'

";
        
                if(isset($model->search) && $model->search != null) {
//			$criteria->compare('Profiles.firstname', $model->search, true);
//			$criteria->compare('Profiles.lastname', $model->search, true, 'OR');
//			$criteria->compare('user.bookkeeper_id', $model->search, true, 'OR');
                        $sqlUser .= " AND (tbl_profiles.firstname like '%".$model->search."%' OR tbl_profiles.lastname like '%".$model->search."%' OR tbl_users.username like '%".$model->search."%' )";
		}

                //check course category type
//		if(isset($model->cate_id) && $model->cate_id != null) {
////			$criteria->compare('courseonline.cate_id', $model->cate_id, false, 'AND');
//                        $sqlUser .= " AND tbl_course_online.cate_id = '".$model->cate_id."' ";
//		}
                
		//check generation
		if(isset($model->generation) && $model->generation != null) {
//			$criteria->compare('Profiles.generation', $model->generation, true, 'OR');
                        $sqlUser .= " AND tbl_profiles.generation = '".$model->generation."' ";
		}

        if(isset($model->memtype) && $model->memtype != null) {
//          $criteria->compare('Profiles.generation', $model->generation, true, 'OR');
                        $sqlUser .= " AND tbl_type_user.id = '".$model->memtype."' ";
        }

		//check course id
		if(isset($model->passcours_cours) && $model->passcours_cours != null && $model->passcours_cours[0]!='') {
//			$criteria->addInCondition('passcours_cours', $model->passcours_cours, 'AND');
                        $sqlUser .= " AND tbl_coursescore.course_id IN (".implode(",",$model->passcours_cours).") ";
		}

		//check period start - end
		if(isset($model->period_start) && $model->period_start != null) {
//			$criteria->addCondition('passcours_date >= "' . date('Y-m-d 00:00:00', strtotime($model->period_start)) . '"');
//                        $sqlUser .= " AND tbl_passcours.passcours_date >= '".date('Y-m-d 00:00:00', strtotime($model->period_start))."' ";
                        $sqlUser .= " AND tbl_coursescore.create_date >= '".date('Y-m-d 00:00:00', strtotime($model->period_start))."' ";
		}
		if(isset($model->period_end) && $model->period_end != null) {
//			$criteria->addCondition('passcours_date <= "' . date('Y-m-d 23:59:59', strtotime($model->period_end)) . '"');
//                        $sqlUser .= " AND tbl_passcours.passcours_date <= '".date('Y-m-d 23:59:59', strtotime($model->period_end))."' ";
                        $sqlUser .= " AND tbl_coursescore.create_date <= '".date('Y-m-d 23:59:59', strtotime($model->period_end))."' ";
		}
        
            $sqlUser .= " GROUP BY tbl_coursescore.course_id,tbl_coursescore.user_id ORDER BY pass_60_date asc";
//                if(!empty($_GET)){
//                    var_dump($sqlUser);exit();
//                }

        // $item_count = Yii::app()->db->createCommand($sqlUser)->queryScalar();
        $modelAll = Yii::app()->db->createCommand($sqlUser)->queryAll();

        $dataProvider_ex=new CArrayDataProvider($modelAll, array(
                'pagination'=>false
          ));
        
        
        $contentView = $this->renderPartial('excel', array(
            'dataProvider_ex' => $dataProvider_ex
                ));
        
       

      echo '<meta charset="UTF-8">';
	echo '<h3 align="center">'.$titlePage.'</h3>';
      echo $contentView;
      exit();
    }

    public function actionReportPasscpd() {
        $model = new Passcours('highsearch');
        $model->unsetAttributes();
//        $model->cate_id = '36';
//			$model = new Passcours('highsearch');
        //set attributes
        
        $sqlUser = " SELECT title_id,firstname,lastname,bookkeeper_id,auditor_id,username,auditor_id,address,province,email,phone,tbl_coursescore.course_id,tbl_coursescore.user_id ,
passcours_date,tbl_category.special_category,pic_cardid,create_at,tbl_type_user.name,type_user,tbl_coursescore.create_date as pass_60_date
            FROM tbl_coursescore 
            INNER JOIN tbl_profiles ON tbl_coursescore.user_id = tbl_profiles.user_id 
            INNER JOIN tbl_users ON tbl_coursescore.user_id = tbl_users.id
            INNER JOIN tbl_course_online ON tbl_course_online.course_id = tbl_coursescore.course_id
            LEFT JOIN tbl_category ON tbl_course_online.cate_id = tbl_category.cate_id
            LEFT JOIN tbl_type_user ON tbl_type_user.id = tbl_profiles.type_user
            LEFT JOIN tbl_passcours ON tbl_passcours.passcours_cours = tbl_coursescore.course_id and tbl_passcours.passcours_user = tbl_coursescore.user_id
            WHERE tbl_course_online.cate_id = '36' and score_past = 'y'

";
        
                if ($_GET['search'] != '') {
                        $sqlUser .= " AND (tbl_profiles.firstname like '%".$_GET['search']."%' OR tbl_profiles.lastname like '%".$_GET['search']."%' OR tbl_users.username like '%".$_GET['search']."%' )";
		}

		//check generation
		if ($_GET['generation'] != '') {
                        $sqlUser .= " AND tbl_profiles.generation = '".$_GET['generation']."' ";
		}

		//check course id
		if ($_GET['course_id'] != '') {
                        // $sqlUser .= " AND tbl_passcours.passcours_cours IN (".$_GET['course_id'].") ";
                        $sqlUser .= " AND tbl_coursescore.course_id IN (".$_GET['course_id'].") ";
		}

        if($_GET['memtype'] != '') {
//          $criteria->compare('Profiles.generation', $model->generation, true, 'OR');
                        $sqlUser .= " AND tbl_type_user.id = '".$_GET['memtype']."' ";
        }

		//check period start - end
		if ($_GET['period_start'] != '') {
//                        $sqlUser .= " AND tbl_passcours.passcours_date >= '".date('Y-m-d 00:00:00', strtotime($_GET['period_start']))."' ";
                    $sqlUser .= " AND tbl_coursescore.create_date >= '".date('Y-m-d 00:00:00', strtotime($_GET['period_start']))."' ";    
		}
		if ($_GET['period_end'] != '') {
//                        $sqlUser .= " AND tbl_passcours.passcours_date <= '".date('Y-m-d 23:59:59', strtotime($_GET['period_end']))."' ";
                        $sqlUser .= " AND tbl_coursescore.create_date <= '".date('Y-m-d 23:59:59', strtotime($_GET['period_end']))."' ";
		}
        
            $sqlUser .= " GROUP BY tbl_coursescore.course_id,tbl_coursescore.user_id ORDER BY pass_60_date asc";
             
        // $item_count = Yii::app()->db->createCommand($sqlUser)->queryScalar();
        $modelAll = Yii::app()->db->createCommand($sqlUser)->queryAll();
        $dataProvider=new CArrayDataProvider($modelAll, array(
                'pagination'=>false//array(
//                  'pageSize'=>25
//                ),
          ));
//        if(Yii::app()->user->getState('ReportPassCours'))
//        {
//        	$model = Yii::app()->user->getState('ReportPassCours');
//        }

        if (isset($_GET['export'])) {
            $production = 'export';
        } else {
            $production = 'grid';
        }
        if(isset($_GET['download'])){
        $this->deletezipFile();
          $downloadzip = $this->zipFilesAndDownload($dataProvider);
          if($downloadzip){
              $this->deletezipFile();
          }
        }
//        $this->render('reportpasscpd', array(
//            'model' => $model, 
//            'production' => $production,
//            'dataProvider' => $dataProvider
//                ));
    }

    public function loadModel($id) {
        $model = Passcours::model()->passcourscheck()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionPasscoursLog() {

        $model = new PasscoursLog('search');

        $this->render('passcours_log', array(
            'model' => $model,
        ));
    }

    public function actionCertificate($PassCoursId = null,$UserId = null,$CertificateType = null,$filepath = null) {

		//get all $_POST data
        if(!empty($_POST['CourseId'])){
            $PassCoursId = $_POST['CourseId'];
        }
        if(!empty($_POST['UserId'])){
            $UserId = $_POST['UserId'];
        }
        if(!empty($_POST['CertificateType'])){
            $CertificateType = $_POST['CertificateType'];
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
        
		$model = Passcours::model()->find(array(
			'condition'=>'passcours_cours=:id AND passcours_user=:user','params' => array(
				':id' => $PassCoursId,
				':user' => $UserId
			)
	    ));
                if(!$model || $model->passcours_date < $startDate){
                    $model = Coursescore::model()->find(array(
			'condition'=>'course_id=:id AND user_id=:user','params' => array(
				':id' => $PassCoursId,
				':user' => $UserId
			),
                        'order' => 'create_date ASC'
                    )); 
                     $passcours_date = Helpers::learn_end_date_from_course($PassCoursId, $UserId);
                        if($passcours_date > $model->create_date ){
                            $passcours_date = $model->create_date;
                        }
                }
       
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

        $course_check_sign = array('170','174','186','187','188','189','190','191','192','193','194');  

        $renderFile = 'certificate';
        if( $CertificateType == 'cpd' ) {
            $renderFile = 'certificate_cpd';
            $renderSign = 'dbd_certificate_dbd_sign.png';
            $nameSign = '( นางโสรดา เลิศอาภาจิตร์ )';
            $positionSign = 'ผู้อำนวยการกองกำกับบัญชีธุรกิจ';
        } else {
            if(in_array($PassCoursId,$course_check_sign)){
                $renderSign = 'dbd_certificate_sign_2.png';
                $nameSign = '( ม.ล. ภู่ทอง  ทองใหญ่ )';
                $positionSign = 'ผู้อำนวยการกองพัฒนาผู้ประกอบธุรกิจ';
            } else {
                $renderSign = 'dbd_certificate_sign.png';
                $nameSign = '( นายธานี  โอฬารรัตน์มณี )';
                $positionSign = 'ผู้อำนวยการกองพาณิชย์อิเล็กทรอนิกส์';
            }
        }
        
	    if($model) {
	    	$setCertificateData = array(
	    		'fulltitle' => $model->Profiles->ProfilesTitle->prof_title . $model->Profiles->firstname . " " . $model->Profiles->lastname,
	    		'userAccountCode' => $userAccountCode,
	    		'courseTitle' => $model->CourseOnlines->course_title,
	    		'courseCode' => (isset($courseCode))?'รหัสหลักสูตร '.$courseCode:null,
	    		'courseAccountHour' => (isset($courseAccountHour))?$courseAccountHour:null,
	    		'courseEtcHour' => (isset($courseEtcHour))?$courseEtcHour:null,
	    		'startLearnDate' => $startDate,
	    		'endLearnDate' => (isset($model->passcours_date))?$model->passcours_date:$passcours_date,
	    		'courseDatePassOver60Percent' => $CourseDatePass,
                'renderSign' => $renderSign,
                'nameSign' => $nameSign,
                'positionSign' => $positionSign,
	    		);

	    	//Print
		    $mPDF = Yii::app()->ePdf->mpdf('th', 'A4-L', '0', 'dbhelvethaicax');
	        $mPDF->setDisplayMode('fullpage');
	        $mPDF->setAutoFont();
			$mPDF->AddPage('L');
			
			
			//encode html for UTF-8 before write to html
	        $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('cerfile/' . $renderFile, array('model'=>$setCertificateData), true), 'UTF-8', 'UTF-8'));

	        //save log private function saveCertificateLog()
	        self::savePassCourseLog('Print', (isset($model->passcours_id))?$model->passcours_id:null);

	        //output
                if($filepath==null){
                    $mPDF->Output();
                }else{
	        $mPDF->Output($filepath,'F');
                }
	    } else {
	    	throw new CHttpException( 404, 'The requested page does not exist.' );
	    }

	}

    private function savePassCourseLog($action, $passcours_id=null) {

        if (Yii::app()->user->id) {
            $model = new PasscoursLog();
            //set model data
            $model->pclog_userid = Yii::app()->user->id;
            $model->pclog_event = $action;
            $model->pclog_target = $passcours_id;
            $model->pclog_date = date('Y-m-d H:i:s');

            //save
            if (!$model->save()) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
        }
    }

    public function actionPrintPDF($id, $user) {
        $CheckPasscours = Passcours::model()->find(array(
            'condition' => 'passcours_cours=:id AND passcours_user=:user', 'params' => array(
                ':id' => $id,
                ':user' => $user
            )
        ));
        if (isset($CheckPasscours)) {
            $mPDF = Yii::app()->ePdf->mpdf();
            $mPDF->setDisplayMode('fullpage');
            $mPDF->setAutoFont();
            $mPDF->AddPage('L');
            $mPDF->WriteHTML($this->renderPartial('PrintPDF', array('model' => $CheckPasscours), true));
            $mPDF->Output();
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    function zipFilesAndDownload($model) {
        //create the object
//        $model->page_false = 1;
        $file='';
           foreach($model->getData() as $index => $value){
            //บัตรประชาชน----------------------------------------------------------
               $id_user = $value['user_id'];
                $bookkeeper_id = $value['bookkeeper_id'];
                $username = $value['username'];
               // $firstname = $value->Profiles->firstname;
               // $lastname = $value->Profiles->lastname;
//                $bookpath = ($bookkeeper_id != '')? $bookkeeper_id."_":'';
                $bookpath = ($bookkeeper_id != '')? $bookkeeper_id:$username;
//                $path_new = $bookpath.$firstname."_".$lastname."/";
                $path_new = $bookpath."/";
            if($value['pic_cardid'] != '') {
		  $idcard = $value['pic_cardid'];
                $regis_model = Coursescore::model()->findByAttributes(array('user_id'=>$value['user_id'],'course_id'=>$value['course_id']));
                $file_names[] = array('file'=>Yush::getPath($regis_model->register, Yush::SIZE_ORIGINAL, $idcard),'path'=>$path_new.$idcard);
            } else {
                $idcard = 'null';
                $regis_model = Coursescore::model()->findByAttributes(array('user_id'=>$value['user_id'],'course_id'=>$value['course_id']));
                $file_names[] = array('file'=>Yush::getPath($regis_model->register, Yush::SIZE_ORIGINAL, $idcard),'path'=>$path_new.$idcard);
            }
            //--------------------------------------------------------------------
            
            //ใบรับรอง++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            $folder = Yush::getPath($regis_model->user, Yush::SIZE_ORIGINAL);
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }
            $filecert = Yush::getPath($regis_model->user, Yush::SIZE_ORIGINAL,'cert_'.$value['course_id'].'.pdf');
            if (!file_exists($filecert)) {

                $CourseSpecialType = $value['special_category'];
		$CertificateType = null;

		//check if this course is special (for cpd certificate)
		if($CourseSpecialType === 'y') {
			$CertificateType = 'cpd';
		}
                $PassCoursId = $value['course_id'];
                     $UserId = $value['user_id'];
                    self::actionCertificate($PassCoursId,$UserId,$CertificateType,$filecert);
                    
            }
            $file_names[] = array('file'=>$filecert,'path'=>$path_new.'cert_'.$value['course_id'].'.pdf');
            //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
           } 
        $archive_file_name = 'Download.zip'; 
        $zip = new ZipArchive();
        //create the file and throw the error if unsuccessful
        if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE) !== TRUE) {
            exit("cannot open <$archive_file_name>\n");
        }

        //add each files of $file_name array to archive
        
        foreach ($file_names as $files) {
            $zip->addFile($files['file'],$files['path']);
        }
        $zip->close();

        //then send the headers to foce download the zip file
        header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename=$archive_file_name");
        header("Pragma: no-cache");
        header("Expires: 0");
        readfile("$archive_file_name");
        return true;
//        exit;
    }
    
    function deletezipFile(){
        $filename = 'Download.zip';
        if (file_exists($filename)) {
            unlink($filename);
        } 
    }

}
