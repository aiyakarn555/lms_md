<?php

class VirtualClassroomController extends Controller
{

  public function init()
  {
      parent::init();

      if (Yii::app()->user->id == null) {

        Yii::app()->user->setFlash('msg','Please log in');
        Yii::app()->user->setFlash('icon','warning');

        $this->redirect(array('site/index'));
        exit();
    }


    $this->lastactivity();
}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }

        $criteria = new CDbCriteria;
        $criteria->with = array('teams');
        $criteria->compare('teams.active','y');
        $criteria->compare('user_id',Yii::app()->user->id);
            // $criteria->compare('t.status','y');
        $criteria->addCondition('teams.end_date >= :date_now');
        $criteria->params[':date_now'] = date('Y-m-d H:i');
        $criteria->order = 'teams.id';
        $modelTemp = MsteamsTemp::model()->findAll($criteria);

        foreach ($modelTemp as $keytemp => $valTemp) {
            $teams_id[] = $valTemp->ms_teams_id;
        }

        $criteria = new CDbCriteria;
        $criteria->addIncondition('id',$teams_id);
        if(isset($_POST["course_title"])){
         $criteria->compare('name_ms_teams',$_POST["course_title"],true);
     }
     $criteria->compare('active', 'y');
     $criteria->compare('type_ms_teams', 1); //ออนไลน์  2= ออนไลน์ สถาบัน
     if($_POST["sort"] == 2){
         $criteria->order = 'id ASC';
     }else{
         $criteria->order = 'id DESC';
     }
     $MsTeams = MsTeams::model()->findAll($criteria);

     $this->render('index',array('MsTeams'=>$MsTeams,'textold'=>$_POST["course_title"]));
 }




 public function actionDetail($id) {
    if(Yii::app()->user->id == null){
        $this->redirect(array('//site/index'));
    }


    if(Yii::app()->user->id){
        Helpers::lib()->getControllerActionId();
    }

    if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
        $langId = Yii::app()->session['lang'] = 1;
        Yii::app()->language = 'en';
    }else{
        $langId = Yii::app()->session['lang'];
        Yii::app()->language = (Yii::app()->session['lang'] == 1)? 'en':'th';
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

    $course = MsTeams::model()->findByPk($id);
    $lessonList = LessonMsTeams::model()->findAll(array('condition' => 'active = "y" AND lang_id = 1 AND ms_teams_id=' . $id, 'order' => 'lesson_no'));
    
    $user = Yii::app()->getModule('user')->user();

    $user_id = Yii::app()->user->id;
    $user = User::model()->findByPk($user_id);

    if (!empty(Yii::app()->user->id)) {
        $gen_id = 0;
        $logtime = LogStartMsTeams::model()->find(array(
            'condition'=>'ms_teams_id=:id AND user_id=:user_id AND active=:active AND gen_id=:gen_id',
            'params' => array(':id' => $id, ':user_id' => Yii::app()->user->id , ':active' => 'y', ':gen_id'=>$gen_id)
        ));

        if (empty($logtime)) {

            $now = date('Y-m-d H:i:s');

            $date1=date_create(date('Y-m-d'));
            $date2=date_create(date_format(date_create($course->end_date),"Y-m-d"));
            $diff=date_diff($date1,$date2);
            $day =  $diff->format("%a");

            $logtime = new LogStartMsTeams;
            $logtime->user_id = Yii::app()->user->id;
            $logtime->ms_teams_id = $id;
            $logtime->start_date = $now;
            $logtime->end_date = date_format(date_create($course->end_date),"Y-m-d");
            $logtime->course_day = $day;
            $logtime->gen_id = $gen_id;
            $logtime->save();


        }else if(!empty($logtime)){
            if(date_format(date_create($logtime->end_date),"Y-m-d") != date_format(date_create($course->end_date),"Y-m-d")) {
             $date1=date_create(date('Y-m-d'));
             $date2=date_create(date_format(date_create($course->end_date),"Y-m-d"));
             $diff=date_diff($date1,$date2);
             $days =  $diff->format("%a");

             $logtime->end_date = date_format(date_create($course->end_date),"Y-m-d");
             $logtime->course_day = $days;
             $logtime->save();
         }
     }
 }

 if($logtime){

     $courseDateExpire =  $course->end_date;
     $dateStart=date_create();
     $dateEnd=date_create($logtime->end_date);
     $diff=date_diff($dateStart,$dateEnd);
     $diff = $diff->format("%a");
            if($diff < 0 || (date('Y-m-d') > date($courseDateExpire))){//$course->course_date_end
                //set Flash
            	Yii::app()->user->setFlash('msg', 'คุณหมดเวลาเรียนแล้ว');
            	$this->redirect(array('site/index'));
            }
            
        }

        $criteria = new CDbCriteria;
        $criteria->with = array('teams');
        $criteria->compare('teams.active','y');
        $criteria->compare('ms_teams_id',$id);
        $criteria->compare('user_id',Yii::app()->user->id);
        $courseTemp = MsteamsTemp::model()->find($criteria);

        $criteria = new CDbCriteria;
        $criteria->compare('ms_teams_id',$id);
        $criteria->compare('ms_teams_temp_id',$courseTemp->id);
        $criteria->compare('user_id',Yii::app()->user->id);
        $criteria->compare('active','y');
        $courseDocument = MsteamsDocument::model()->findAll($criteria);
        $note = MtCodeMd::model()->find(array('condition'=> 'code_md ='. $course->course_md_code));


        if (isset($_FILES["face_image_1"]) && isset($_FILES["face_image_2"]) && isset($_FILES["face_image_3"])) {

            $user_id = Yii::app()->user->id;
          
            $result =  Helpers::lib()->ApiFaceImage($user_id,$_FILES,"zoom","FaceRegis");
            if($result != "success"){
                if($result == "fake"){
                    $msg = "การตรวจสอบใบหน้าไม่ถูกต้อง ระบบตรวจสอบพบว่าไม่ใช่การถ่ายภาพตามเงื่อนไขที่กำหนด กรุณาถ่ายภาพใหม่อีกครั้งให้ถูกต้องตามเงื่อนไข";
                }else{
                    $msg = "ไม่สามารถตรวจจับใบหน้าของคุณได้ กรุณาลองอีกครั้ง";
                }
                Yii::app()->user->setFlash('msg',$msg);
                Yii::app()->user->setFlash('icon','warning');
                $this->render('detail', array(
                    'lessonList' => $lessonList,
                    'course' => $course,
                    'label' => $label,
                    'logtime' => $logtime,
                    'diff' => $diff,
                    "courseTemp"=>$courseTemp,
                    "courseDocument"=>$courseDocument,
                    'note'=>$note
                ));
            }else{
      
                $path = 'uploads/FaceMsTeams/';
                $date = date('Y-m-d H:i:s');
                $timestamp = strtotime($date);
                $file_name = $user_id.'-'.$timestamp;
                $file_extension = '.jpg';
                $full_path = $path.$file_name.$file_extension;
                $checkSaveImage = file_put_contents($full_path, file_get_contents($_FILES["face_image_1"]["tmp_name"]));
       
                if($checkSaveImage){
                    $model = New CaptureMsTeams;
                    $model->user_id = $user_id;
                    $model->ms_teams_id = $_POST['msteams'];
                    $model->file_name = $file_name;
                    $model->active = 'y';
                    $model->type_noti = 'web';
                    $model->create_date = date("Y-m-d h:i:s");
                    $model->update_date = date("Y-m-d h:i:s");
                    $model->save();
                    $url = $_POST['zoom'];
                    echo "<script type=\"text/javascript\">
                    window.open('".$url."', '_blank', 'noopener')
                </script>";
                }else{
                    $msg = "ไม่สามารถบันทึกรูปภาพได้ กรุณาลองอีกครั้ง";
                    Yii::app()->user->setFlash('msg',$msg);
                    Yii::app()->user->setFlash('icon','warning');
                    $this->render('detail', array(
                        'lessonList' => $lessonList,
                        'course' => $course,
                        'label' => $label,
                        'logtime' => $logtime,
                        'diff' => $diff,
                        "courseTemp"=>$courseTemp,
                        "courseDocument"=>$courseDocument,
                        'note'=>$note
                    ));  
                }
    
            }
            // echo "<script>window.close();</script>";
        }

        

        $this->render('detail', array(
            'lessonList' => $lessonList,
            'course' => $course,
            'label' => $label,
            'logtime' => $logtime,
            'diff' => $diff,
            "courseTemp"=>$courseTemp,
            "courseDocument"=>$courseDocument,
            'note'=>$note
        ));
    }


    public function actionPrintCertificate($id, $dl = null) {


        if(Yii::app()->user->id){
            Helpers::lib()->getControllerActionId();
        }
        //get all $_POST data
        $UserId = Yii::app()->user->id;
        $PassCoursId = $id;
        $certDetail = CertificateNameRelationsMsTeams::model()->find(array('condition'=>'ms_teams_id='.$id));
        //
        $currentUser = User::model()->findByPk($UserId);
        
        $gen_id = 0;
        

        // $coruse_percents =  Helpers::lib()->percent_CourseGen($id, $gen_id);

        // if($coruse_percents < 100){
        //     $this->redirect(array('/course/detail/', 'id' => $id));
        // }
        
        $renderFile = 'Newcertificate';

        $renderSign = $certDetail->certificate->signature->sign_path;
        $nameSign = $certDetail->certificate->signature->sign_title;
        $positionSign = $certDetail->certificate->signature->sign_position;

        $sign_id2 = $certDetail->certificate->sign_id2; //key

        if($sign_id2 != null){
            $model2 = Signature::model()->find(array('condition' => 'sign_id = '.$sign_id2)); //model PK = sign_id2
            $renderSign2 = $model2->sign_path;
            $nameSign2 = $model2->sign_title;
            $positionSign2 = $model2->sign_position;

        }

        $course_model = MsTeams::model()->findByPk($PassCoursId);
        $CoursePassedLog = PasscoursLog::model()->find(array(
            'condition' => 'pclog_userid=:user_id AND pclog_event=:event AND pclog_ms_teams=:cou ',
            'params' => array(':user_id' => Yii::app()->user->id,':event' => 'Print',':cou' => $PassCoursId)
        ));

        if(!$CoursePassedLog){
            $last = PasscoursLog::model()->find(
                array(
                    'order'=>'pclog_number DESC',
                    'condition' => ' pclog_event=:event AND pclog_ms_teams=:cou AND gen_id=:cgd_gen',
                    'params' => array(':event' => 'Print',':cou' => $PassCoursId,':cgd_gen' => $gen_id)
                ));

            $cid = $last['pclog_number']+1;
            $CoursePassedLog = new PasscoursLog();
            $CoursePassedLog->pclog_userid = Yii::app()->user->id;
            $CoursePassedLog->pclog_event = 'Print';
            $CoursePassedLog->gen_id = $gen_id;
            $CoursePassedLog->pclog_number = $cid;
            $CoursePassedLog->pclog_ms_teams = $PassCoursId;
            $CoursePassedLog->pclog_date = date('Y-m-d H:i:s');
            $CoursePassedLog->save(false);
        }

        $number = $CoursePassedLog->pclog_number;
        $num_pass = str_pad($number, 5, '0', STR_PAD_LEFT);


        $course_model = MsTeams::model()->findByAttributes(array(
            'id' => $PassCoursId,
            'active' => 'y'
        ));
        if(!empty($course_model->end_date)){ //LMS
            $course_model->end_date =  Helpers::lib()->PeriodDate($course_model->end_date,true);
        }else{ //TMS

        }

        if($certDetail->certificate->cert_type == 1){
            $bgPath = "certificate-md-1.jpg";
        }else{
            $bgPath = "certificate-md-2.jpg";
        }


        $certType = $certDetail->certificate->cert_type;
        
        $cou_numberss =  $course_model->course_md_gm;
        $cou_number = $cou_numberss.'-'.$num_pass.'/'.substr(date("Y"),2);

        $CoursePassedLog->cou_number = $cou_number;
        $CoursePassedLog->save(false);

        $model = LogStartMsTeams::model()->findByAttributes(array('user_id' => Yii::app()->user->id,'ms_teams_id'=> $PassCoursId));


        if ($model) {
            if (isset($model->pro)) {

               $fulltitle_en = $model->pro->ProfilesTitleEn->prof_title_en . " " . $model->pro->firstname_en . " " . $model->pro->lastname_en;
               $pro_pic = $model->pro->profile_picture;
               $pro_iden = $model->pro->identification;
               $pro_birth = $model->pro->birthday;

           }
           $setCertificateData = array(
                // 'fulltitle' => $fulltitle,
            'fulltitle_en' => $fulltitle_en,
            'pro_pic' => $pro_pic,
            'pro_iden' => $pro_iden,
            'pro_birth' => $pro_birth,
            'cert_text' => $certDetail->certificate->cert_text,
                // 'userAccountCode' => $userAccountCode,
            'courseTitle_en' => $course_model->name_ms_teams,
            'courseStr' => $course_model->start_date,
            'courseEnd' => $course_model->end_date,
            'coursenumber' => $cou_number,

            'endLearnDate' => (isset($model->passcours_date)) ? $model->passcours_date : $model->create_date,
            'renderSign' => $renderSign,
            'nameSign' => $nameSign,
            'positionSign' => $positionSign,
            'certType' => $certType,
            'renderSign2' => $renderSign2,
            'nameSign2' => $nameSign2,
            'positionSign2' => $positionSign2,

            'positionUser' => $position_title,
                // 'companyUser' => $company_title,

                // 'identification' => $identification,
            'bgPath' => $bgPath,
            'pageFormat' => $pageFormat,
            'pageSide' => $certDetail->certificate->cert_display,
            'user' => $UserId,
            'course' => $course_model->id,
            'gen' => $gen_id
        );

           $pageFormat = 'P';

           require_once __DIR__ . '/../../admin/protected/vendors/mpdf7/autoload.php';
           $mPDF = new \Mpdf\Mpdf(['format' => 'A4-'.$pageFormat]);
            // $mPDF = new \Mpdf\Mpdf(['orientation' => $pageFormat]);
           $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial('cerfile/' . $renderFile, array('model'=>$setCertificateData), true), 'UTF-8', 'UTF-8'));

            //output
           if (isset($model->passcours_id) OR isset($model->score_id)) {
            if (isset($model->passcours_id)) {
                $target = $model->passcours_id;
            } else if (isset($model->score_id)) {
                $target = $model->score_id;
            }
        } else {
            $target = $model->ms_teams_id;
        }
        if ($dl != null && $dl == 'dl') {
                // self::savePassCourseLog('Download', $target);
            $mPDF->Output($fulltitle . '.pdf', 'D');
        } else {
                // self::savePassCourseLog('Print', $target);
            $mPDF->Output();
        }
    } else {
        throw new CHttpException(404, 'The requested page does not exist.');
    }
}


public function actionDownload($id) {
    if(Yii::app()->user->id){
        Helpers::lib()->getControllerActionId();
    }
    $fileDoc = FileDocMsTeams::model()->findByPK($id);
    if ($fileDoc) {
            // $webroot = Yii::app()->getUploadPath('filedoc');
        $webroot = Yii::app()->basePath.'/../uploads/filedoc_msteams/';
            // var_dump($webroot);exit();
        $uploadDir = $webroot;
        $filename = $fileDoc->filename;
        $filename = $uploadDir . $filename;
            // var_dump($filename);
            // exit;
        if (file_exists($filename)) {
            return Yii::app()->request->sendFile($fileDoc->file_name, file_get_contents($filename));
        } else {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    } else {
        throw new CHttpException(404, 'The requested page does not exist.');
    }
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

public function actionSendNotiToApiAuthen(){
    $userId = $_POST['user_id'];
    $courseId = $_POST['course_id'];
    $lessonId = $_POST['lesson_id'];
    $zoomUrl = $_POST['zoom_url'];
    $response = Helpers::lib()->APIAuthenLmsSendNoti($userId,$courseId,$lessonId,'sercetAuthenMd',$zoomUrl); 
}

public function actionCheckStopSendNoti(){
    $checkNoti = MsTeams::model()->findByPk($_POST['course_id']);
    if($checkNoti->status_ms_teams == 0){
        echo "true";
    }else{
        echo "false";
    }
}


}