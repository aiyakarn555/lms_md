<?php
class ReportController extends Controller
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
                'actions' => array('index', 'Loadgen', 'LogReset', 'ajaxgetlesson', 'ajaxgetlevel'),
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



    public function actionImportExcel()
    {
        $model = new User('import');
        $HisImportArr = array();
        $HisImportErrorArr = array();
        $HisImportAttrErrorArr = array();
        $HisImportErrorMessageArr = array();
        $HisImportUserPassArr = array();
        $data = array();
        // if(isset($_FILES['excel_import_student']))
        $model->excel_file = CUploadedFile::getInstance($model, 'excel_file');

        if (!empty($model->excel_file)) {
            $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');
            include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

            $model->excel_file = CUploadedFile::getInstance($model, 'excel_file');
            // $model->excel_file =  $_FILES['excel_import_student'];

            //if ($model->excel_file && $model->validate()) {
            // $webroot = YiiBase::getPathOfAlias('webroot');
            $webroot = Yii::app()->basePath . "/../..";
            // $filename = $webroot.'/uploads/' . $model->excel_file->name . '.' . $model->excel_file->extensionName;
            $filename = $webroot . '/uploads/' . $model->excel_file->name;
            $model->excel_file->saveAs($filename);

            $sheet_array = Yii::app()->yexcel->readActiveSheet($filename);
            $inputFileName = $filename;
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($inputFileName);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $highestRow = $objWorksheet->getHighestRow();
            $highestColumn = $objWorksheet->getHighestColumn();

            $headingsArray = $objWorksheet->rangeToArray('A1:' . $highestColumn . '1', null, true, true, true);
            $headingsArray = $headingsArray[1];

            $r = -1;
            $namedDataArray = array();
            for ($row = 2; $row <= $highestRow; ++$row) {
                $dataRow = $objWorksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, true, true);
                if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
                    ++$r;
                    foreach ($headingsArray as $columnKey => $columnHeading) {
                        $namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
                    }
                }
            }

            $index = 0;

            foreach ($namedDataArray as $key => $result) {

                if($result["เลขบัตรประชาชน"] != "" && $result["ชื่อ"] != "" && $result["นามสกุล"] != "" && $result["รหัสสถาบัน"] != "" && $result["โค้ดหลักสูตร"] != ""){

                    $data[$key]['fullnames'] = $result["ชื่อ"].' '.$result["นามสกุล"];
                    $data[$key]['institutions'] = $result["รหัสสถาบัน"];
                    $data[$key]['coursemds'] = $result["โค้ดหลักสูตร"];
                    $data[$key]['cards'] = $result["เลขบัตรประชาชน"];


                    $tempOld = ImportConditionMd::model()->find(array(
                        'condition' => 'idcard="' . $result["เลขบัตรประชาชน"] . '" AND institution_id="' . $result["รหัสสถาบัน"] . '" AND course_md_id="' . $result["โค้ดหลักสูตร"] . '"',
                    ));

                    if ($tempOld == null) {



                      $models = new ImportConditionMd;
                      $models->idcard = $result["เลขบัตรประชาชน"];
                      $models->title = $result["คำนำหน้าชื่อ"];
                      $models->fname = $result["ชื่อ"];
                      $models->lname = $result["นามสกุล"];
                      $models->institution_id = $result["รหัสสถาบัน"];
                      $models->course_md_id = $result["โค้ดหลักสูตร"];
                      $models->instructor_name = $result["ชื่อผู้สอน"];

                      try {
                          $models->save();
                          $data[$key]['msg'] = 'เพิ่มข้อมูลเรียบร้อย';
                          $Insert_success[$key] = "pass";
                      }
                      catch(Exception $e) {
                        $data[$key]['msg'] ="ข้อมูลไม่ถูกต้อง";
                        $Insert_success[$key] = "notpass";
                    }
                    

                } else {
                    $data[$key]['msg'] ="ข้อมูลนี้มีอยู่แล้ว";
                    $Insert_success[$key] = "notpass";
                }
            }
            } //end loop add user

            $this->render('ImportExcel', array('model' => $model, 'HisImportArr' => $HisImportArr, 'HisImportUserPassArr' => $HisImportUserPassArr, 'HisImportErrorArr' => $HisImportErrorArr, 'HisImportAttrErrorArr' => $HisImportAttrErrorArr, 'HisImportErrorMessageArr' => $HisImportErrorMessageArr, 'Insert_success' => $Insert_success, 'data' => $data));
            exit();
            //}
        }

        // $this->render('excel',array('model'=>$model));
        $this->render('ImportExcel', array('model' => $model, 'HisImportArr' => $HisImportArr, 'HisImportUserPassArr' => $HisImportUserPassArr, 'HisImportErrorArr' => $HisImportErrorArr, 'HisImportAttrErrorArr' => $HisImportAttrErrorArr, 'HisImportErrorMessageArr' => $HisImportErrorMessageArr, 'Insert_success' => $Insert_success));
        // $this->render('import',array(
        //     'model'=>$model,
        // ));
    }


    public function actionImportExcelPass()
    {
        $model = new User('import');
        $HisImportArr = array();
        $HisImportErrorArr = array();
        $HisImportAttrErrorArr = array();
        $HisImportErrorMessageArr = array();
        $HisImportUserPassArr = array();
        $data = array();
        // if(isset($_FILES['excel_import_student']))
        $model->excel_file = CUploadedFile::getInstance($model, 'excel_file');

        if (!empty($model->excel_file)) {
            $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');
            include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

            $model->excel_file = CUploadedFile::getInstance($model, 'excel_file');
            // $model->excel_file =  $_FILES['excel_import_student'];

            //if ($model->excel_file && $model->validate()) {
            // $webroot = YiiBase::getPathOfAlias('webroot');
            $webroot = Yii::app()->basePath . "/../..";
            // $filename = $webroot.'/uploads/' . $model->excel_file->name . '.' . $model->excel_file->extensionName;
            $filename = $webroot . '/uploads/' . $model->excel_file->name;
            $model->excel_file->saveAs($filename);

            $sheet_array = Yii::app()->yexcel->readActiveSheet($filename);
            $inputFileName = $filename;
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($inputFileName);
            $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
            $highestRow = $objWorksheet->getHighestRow();
            $highestColumn = $objWorksheet->getHighestColumn();

            $headingsArray = $objWorksheet->rangeToArray('A1:' . $highestColumn . '1', null, true, true, true);
            $headingsArray = $headingsArray[1];

            $r = -1;
            $namedDataArray = array();
            for ($row = 2; $row <= $highestRow; ++$row) {
                $dataRow = $objWorksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, true, true);
                if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
                    ++$r;
                    foreach ($headingsArray as $columnKey => $columnHeading) {
                        $namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
                    }
                }
            }

            $index = 0;

            foreach ($namedDataArray as $key => $result) {

               if($result["เลขบัตรประชาชน"] != "" && $result["ชื่อ"] != "" && $result["นามสกุล"] != "" && $result["รหัสสถาบัน"] != "" && $result["โค้ดหลักสูตร"] != ""){

                $data[$key]['fullnames'] = $result["ชื่อ"].' '.$result["นามสกุล"];
                $data[$key]['institutions'] = $result["รหัสสถาบัน"];
                $data[$key]['coursemds'] = $result["โค้ดหลักสูตร"];
                $data[$key]['cards'] = $result["เลขบัตรประชาชน"];
                $data[$key]['counum'] = $result["เลขที่ ปก."];

                $tempOld = ImportPassMd::model()->find(array(
                    'condition' => 'idcard="' . $result["เลขบัตรประชาชน"] . '" AND institution_id="' . $result["รหัสสถาบัน"] . '" AND course_md_id="' . $result["โค้ดหลักสูตร"] . '"',
                ));

                if ($tempOld == null) {


                  $models = new ImportPassMd;
                  $models->idcard = $result["เลขบัตรประชาชน"];
                  $models->title = $result["คำนำหน้าชื่อ"];
                  $models->fname = $result["ชื่อ"];
                  $models->lname = $result["นามสกุล"];
                  $models->institution_id = $result["รหัสสถาบัน"];
                  $models->course_md_id = $result["โค้ดหลักสูตร"];
                  $models->course_number = $result["เลขที่ ปก."];

                  $datest = $result["ตั้งแต่วันที่"];
                  $dateen = $result["ถึงวันที่"];

                  $models->startdate = $datest;
                  $models->enddate = $dateen;
                  $models->note = $result["หมายเหตุ"];

                  try {
                      $models->save();
                      $data[$key]['msg'] = 'เพิ่มข้อมูลเรียบร้อย';
                      $Insert_success[$key] = "pass";
                  }
                  catch(Exception $e) {
                    $data[$key]['msg'] ="ข้อมูลไม่ถูกต้อง";
                    $Insert_success[$key] = "notpass";
                }


            } else {

                $data[$key]['msg'] ="ข้อมูลนี้มีอยู่แล้ว";
                $Insert_success[$key] = "notpass";
            }
        }
            } //end loop add user

            $this->render('ImportExcelLearningPass', array('model' => $model, 'HisImportArr' => $HisImportArr, 'HisImportUserPassArr' => $HisImportUserPassArr, 'HisImportErrorArr' => $HisImportErrorArr, 'HisImportAttrErrorArr' => $HisImportAttrErrorArr, 'HisImportErrorMessageArr' => $HisImportErrorMessageArr, 'Insert_success' => $Insert_success, 'data' => $data));
            exit();
            //}
        }

        // $this->render('excel',array('model'=>$model));
        $this->render('ImportExcelLearningPass', array('model' => $model, 'HisImportArr' => $HisImportArr, 'HisImportUserPassArr' => $HisImportUserPassArr, 'HisImportErrorArr' => $HisImportErrorArr, 'HisImportAttrErrorArr' => $HisImportAttrErrorArr, 'HisImportErrorMessageArr' => $HisImportErrorMessageArr, 'Insert_success' => $Insert_success));
        // $this->render('import',array(
        //     'model'=>$model,
        // ));
    }




    public function actionConditionMd($id=null) { // ค้นหาโดยใช้หลักสูตร

        $model = new Report('ByCourse');
        $model->unsetAttributes();

        if(isset($_GET['Report'])) {

            $model->course_id = $_GET['Report']['course_id'];
            $model->gen_id = $_GET['Report']['gen_id'];
            $model->search = $_GET['Report']['search'];
            $model->type_register = $_GET['Report']['type_register'];
            $model->department = $_GET['Report']['department'];
            $model->position = $_GET['Report']['position'];
            $model->period_start = $_GET['Report']['period_start'];
            $model->period_end = $_GET['Report']['period_end'];

        }

        $this->render('ConditionMd', array(
            'model' => $model
        ));
    }


     public function actionLearningPass($id=null) { // ค้นหาโดยใช้หลักสูตร

        $model = new Report('ByCourse');
        $model->unsetAttributes();

        $this->render('LearningPass', array(
            'model' => $model
        ));
    }

    public function actionLearningPassTest($id=null) { // ค้นหาโดยใช้หลักสูตร

        $model = new Report('ByCourse');
        $model->unsetAttributes();

        $this->render('LearningPassTest', array(
            'model' => $model
        ));
    }

    public function actionExamResult($id=null) { // ค้นหาโดยใช้หลักสูตร

        $model = new Report('ByCourse');
        $model->unsetAttributes();

        $this->render('ExamResult', array(
            'model' => $model
        ));
    }

    public function actionBookingCourse($id=null) { // ค้นหาโดยใช้หลักสูตร

        $model = new Report('ByCourse');
        $model->unsetAttributes();

        $this->render('BookingCourse', array(
            'model' => $model
        ));
    }


    public function actionGenExcelConditionMd(){

        require dirname(__FILE__) . "/../extensions/phpexcel/Classes/PHPExcel.php";
        require dirname(__FILE__) . "/../extensions/phpexcel/Classes/PHPExcel/IOFactory.php";

        $objPHPExcel = new PHPExcel();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ลำดับ');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'เลขบัตรประชาชน');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'คำนำหน้าชื่อ');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, 'ชื่อ');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, 'นามสกุล');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, 'ชื่อสถาบันศึกษา');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, 'ชื่อหลักสูตร');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, 'วันที่เริ่ม (คศ)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, 'วันสุดท้าย (คศ)');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, 'ชื่อผู้สอน');

        $course_online = CourseOnline::model()->findByPk($_GET["course_number"]);
        $ms_teams = MsTeams::model()->findByPk($_GET["ms_teams_id"]);

        if($_GET['institution_id'] == 7){

            $criteria = new CDbCriteria;
            if($_GET['type_cou'] == 1){
                $criteria->with = array('profile', 'course');
            }else if($_GET['type_cou'] == 2){
                $criteria->with = array('profile', 'teams');
            }

            if(isset($_GET['nameSearch']) && $_GET['nameSearch'] != null){
                $ex_fullname = explode(" ", $_GET['nameSearch']);

                if(isset($ex_fullname[0])){
                    $pro_fname = $ex_fullname[0];
                    $criteria->compare('profile.firstname_en', $pro_fname, true);
                    $criteria->compare('profile.lastname_en', $pro_fname, true, 'OR');
                    $criteria->compare('profile.firstname', $pro_fname, true, 'OR');
                    $criteria->compare('profile.lastname', $pro_fname, true, 'OR');
                }

                if(isset($ex_fullname[1])){
                    $pro_lname = $ex_fullname[1];
                    $criteria->compare('profile.lastname',$pro_lname,true);
                    $criteria->compare('profile.lastname_en', $pro_lname, true, 'OR');
                }
            }

            if(isset($_GET['idcard']) && $_GET['idcard'] != null){
                $criteria->compare('profile.identification',$_GET['idcard'],true);
            }

            $criteria->compare('t.status','y');

            if($_GET['type_cou'] == 1){
                if(isset($_GET['course_number']) && $_GET['course_number'] != null){
                    $criteria->compare('t.course_id',$_GET['course_number']);
                }
                $Temp = CourseTemp::model()->findAll($criteria);
            }else if($_GET['type_cou'] == 2){

                if(isset($_GET['ms_teams_id']) && $_GET['ms_teams_id'] != null){
                    $criteria->compare('t.ms_teams_id',$_GET['ms_teams_id']);
                }

                $Temp = MsteamsTemp::model()->findAll($criteria);
            }
        }else{

            $cou_id = $course_online->course_md_code;
            $ms_id = $ms_teams->course_md_code;

            $criteria = new CDbCriteria;
            if($_GET['type_cou'] == 1){
                $criteria->compare('course_md_id',$cou_id);

            }else if($_GET['type_cou'] == 2){
                $criteria->compare('course_md_id',$ms_id);
            }

            if(isset($_GET['nameSearch']) && $_GET['nameSearch'] != null){
                $ex_fullname = explode(" ", $_GET['nameSearch']);

                if(isset($ex_fullname[0])){
                    $pro_fname = $ex_fullname[0];
                    $criteria->compare('fname', $pro_fname, true);
                    $criteria->compare('lname', $pro_fname, true, 'OR');
                }

                if(isset($ex_fullname[1])){
                    $pro_lname = $ex_fullname[1];
                    $criteria->compare('fname',$pro_lname,true);
                    $criteria->compare('lname', $pro_lname, true, 'OR');
                }
            }

            if(isset($_GET['idcard']) && $_GET['idcard'] != null){
                $criteria->compare('idcard',$_GET['idcard'],true);
            }

            if(isset($_GET['institution_id']) && $_GET['institution_id'] != null){
                $criteria->compare('institution_id',$_GET['institution_id']);
            }

            $TempImport = ImportConditionMd::model()->findAll($criteria);

        }



        if($_GET['institution_id'] == 7){
            if(!empty($Temp)){
                foreach($Temp as $i => $val) { 
                    $keytest = ($i) + 2;
                    $key = ($i) + 1;

                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $keytest, $key++);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $keytest, "'".$val->profile->identification);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $keytest, $val->profile->ProfilesTitle->prof_title);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $keytest, $val->profile->firstname);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $keytest, $val->profile->lastname);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $keytest, 'โรงเรียนสุภาพบุรุษเดินเรือ');

                    if($_GET['type_cou'] == 1){ 
                       $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $keytest, $val->course->course_title);
                       $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $keytest, Helpers::lib()->changeFormatDateNewEn($val->course->course_date_start ,'full'));
                       $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $keytest, Helpers::lib()->changeFormatDateNewEn($val->course->course_date_end ,'full'));
                       $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $keytest, $val->course->instructor_name);
                   }else if($_GET['type_cou'] == 2){
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $keytest, $val->teams->name_ms_teams);
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $keytest, Helpers::lib()->changeFormatDateNewEn($val->teams->start_date ,'full'));
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $keytest, Helpers::lib()->changeFormatDateNewEn($val->teams->end_date ,'full'));
                     $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $keytest, $val->teams->instructor_name);
                 }

             }
         }
     }else{

        if(!empty($TempImport)){
            foreach ($TempImport as $key => $value) {
                $keytest = ($key) + 2;
                $key = ($key) + 1;

                $couOn = CourseOnline::model()->find(array(
                    'condition' => 'course_md_code="' . $value->course_md_id . '"',
                ));

                $MsOn = MsTeams::model()->find(array(
                    'condition' => 'course_md_code="' . $value->course_md_id . '"',
                ));

                $InsOn = Institution::model()->find(array(
                    'condition' => 'code="' . $value->institution_id . '"',
                ));

                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $keytest, $key++);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $keytest, "'".$value->idcard);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $keytest, $value->title);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $keytest, $value->fname);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $keytest, $value->lname);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $keytest, $InsOn->institution_name);
                if($_GET['type_cou'] == 1){ 
                 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $keytest, $couOn->course_title);
                 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $keytest, Helpers::lib()->changeFormatDateNewEn($couOn->course_date_start ,'full'));
                 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $keytest, Helpers::lib()->changeFormatDateNewEn($couOn->course_date_end ,'full'));
                 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $keytest, $couOn->instructor_name);
             }else if($_GET['type_cou'] == 2){
               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $keytest, $MsOn->name_ms_teams);
               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $keytest, Helpers::lib()->changeFormatDateNewEn($MsOn->start_date ,'full'));
               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $keytest, Helpers::lib()->changeFormatDateNewEn($MsOn->end_date ,'full'));
               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $keytest, $MsOn->instructor_name);
           }

       }

   }
}


       header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="รายงานเงื่อนไขตามประกาศกรมเจ้าท่า.xlsx"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter->save('php://output');

    }


    public function actionGenExcelLearningPass(){

        require dirname(__FILE__) . "/../extensions/phpexcel/Classes/PHPExcel.php";
        require dirname(__FILE__) . "/../extensions/phpexcel/Classes/PHPExcel/IOFactory.php";

        $objPHPExcel = new PHPExcel();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ลำดับ');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'เลขบัตรประชาชน');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'คำนำหน้าชื่อ');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, 'ชื่อ');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, 'นามสกุล');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, 'ชื่อสถาบันศึกษา');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, 'ชื่อหลักสูตร');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, 'เลขที่ ปก.');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, 'ตั้งแต่วันที่');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, 'ถึงวันที่');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, 'หมายเหตุ');

        if(isset($_GET['institution_id']) && $_GET['institution_id'] != "" ){
            if($_GET['institution_id'] == 7){

                $criteria = new CDbCriteria;
                $criteria->with = array('Profiles', 'CourseOnlines');

                if(isset($_GET['nameSearch']) && $_GET['nameSearch'] != null){
                    $ex_fullname = explode(" ", $_GET['nameSearch']);

                    if(isset($ex_fullname[0])){
                        $pro_fname = $ex_fullname[0];
                        $criteria->compare('Profiles.firstname_en', $pro_fname, true);
                        $criteria->compare('Profiles.lastname_en', $pro_fname, true, 'OR');
                        $criteria->compare('Profiles.firstname', $pro_fname, true, 'OR');
                        $criteria->compare('Profiles.lastname', $pro_fname, true, 'OR');
                    }

                    if(isset($ex_fullname[1])){
                        $pro_lname = $ex_fullname[1];
                        $criteria->compare('Profiles.lastname',$pro_lname,true);
                        $criteria->compare('Profiles.lastname_en', $pro_lname, true, 'OR');
                    }
                }

                if(isset($_GET['idcard']) && $_GET['idcard'] != null){
                    $criteria->compare('Profiles.identification',$_GET['idcard'],true);
                }

                if(isset($_GET['course_number']) && $_GET['course_number'] != null){
                    $criteria->compare('passcours.passcours_cours',$_GET['course_number']);
                }

                if(isset($_GET['course_codenum']) && $_GET['course_codenum'] != null){
                    $criteria->compare('passcours.passcours_number',$_GET['course_codenum'],true);
                }

                if(isset($_GET['search_year']) && $_GET['search_year'] != ""){

                    $start = $_GET['search_year']."-01-01 00:00:00";
                    $end = $_GET['search_year']."-12-31 23:59:59";

                    $criteria->addCondition('passcours.cours_start_date >= :date_str');
                    $criteria->params[':date_str'] = $start;

                    $criteria->addCondition('passcours.passcours_date <= :date_end');
                    $criteria->params[':date_end'] = $end;


                }else{
                 if((isset($_GET['datestr']) && $_GET['datestr'] != "") && (isset($_GET['dateend']) && $_GET['dateend'] != "")){

                    $criteria->addCondition('passcours.cours_start_date >= :date_str');
                    $criteria->params[':date_str'] = $_GET['datestr'];

                    $criteria->addCondition('passcours.passcours_date <= :date_end');
                    $criteria->params[':date_end'] = $_GET['dateend'];

                }else if(isset($_GET['datestr']) && $_GET['datestr'] != ""){

                    $criteria->addCondition('passcours.cours_start_date >= :date_str');
                    $criteria->params[':date_str'] = $_GET['datestr'];

                }else if(isset($_GET['dateend']) && $_GET['dateend'] != ""){

                    $criteria->addCondition('passcours.passcours_date <= :date_end');
                    $criteria->params[':date_end'] = $_GET['dateend'];
                }
            }

            $PassCourses = Passcours::model()->findAll($criteria);


        }else{

            $course_online = CourseOnline::model()->findByPk($_GET["course_number"]);
            $course_online_arr = [];

            if($course_online == null){
                $course_online_ = CourseOnline::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1'));
                foreach ($course_online_ as $keyc => $valc) {
                    $course_online_arr[] = $valc->course_md_code;
                }
            }else{
                $course_online_arr[] = $course_online->course_md_code;
            }

            $criteria = new CDbCriteria;
            $criteria->addIncondition('course_md_id',$course_online_arr);

            if(isset($_GET['nameSearch']) && $_GET['nameSearch'] != null){
                $ex_fullname = explode(" ", $_GET['nameSearch']);

                if(isset($ex_fullname[0])){
                    $pro_fname = $ex_fullname[0];
                    $criteria->compare('fname', $pro_fname, true);
                    $criteria->compare('lname', $pro_fname, true, 'OR');
                }

                if(isset($ex_fullname[1])){
                    $pro_lname = $ex_fullname[1];
                    $criteria->compare('fname',$pro_lname,true);
                    $criteria->compare('lname', $pro_lname, true, 'OR');
                }
            }

            if(isset($_GET['idcard']) && $_GET['idcard'] != null){
                $criteria->compare('idcard',$_GET['idcard'],true);
            }

            if(isset($_GET['institution_id']) && $_GET['institution_id'] != null){
                $criteria->compare('institution_id',$_GET['institution_id']);
            }

            if(isset($_GET['course_codenum']) && $_GET['course_codenum'] != null){
                $criteria->compare('course_number',$_GET['course_codenum'],true);
            }

            if(isset($_GET['search_year']) && $_GET['search_year'] != ""){

                $start = $_GET['search_year']."-01-01 00:00:00";
                $end = $_GET['search_year']."-12-31 23:59:59";

                $criteria->addCondition('startdate >= :date_str');
                $criteria->params[':date_str'] = $start;

                $criteria->addCondition('enddate <= :date_end');
                $criteria->params[':date_end'] = $end;


            }else{

             if((isset($_GET['datestr']) && $_GET['datestr'] != "") && (isset($_GET['dateend']) && $_GET['dateend'] != "")){

                $criteria->addCondition('startdate >= :date_str');
                $criteria->params[':date_str'] = $_GET['datestr'];

                $criteria->addCondition('enddate <= :date_end');
                $criteria->params[':date_end'] = $_GET['dateend'];

            }else if(isset($_GET['datestr']) && $_GET['datestr'] != ""){

                $criteria->addCondition('startdate >= :date_str');
                $criteria->params[':date_str'] = $_GET['datestr'];

            }else if(isset($_GET['dateend']) && $_GET['dateend'] != ""){

                $criteria->addCondition('enddate <= :date_end');
                $criteria->params[':date_end'] = $_GET['dateend'];
            }
        }

        $PassCourseImport = ImportPassMd::model()->findAll($criteria);
    }
}else if($_GET["course_codenum"] != null || $_GET['course_codenum'] != ""){
    //Start PassCourses

    $criteria = new CDbCriteria;
    $criteria->with = array('Profiles', 'CourseOnlines');
    if(isset($_GET['nameSearch']) && $_GET['nameSearch'] != null){
        $ex_fullname = explode(" ", $_GET['nameSearch']);

        if(isset($ex_fullname[0])){
            $pro_fname = $ex_fullname[0];
            $criteria->compare('Profiles.firstname_en', $pro_fname, true);
            $criteria->compare('Profiles.lastname_en', $pro_fname, true, 'OR');
            $criteria->compare('Profiles.firstname', $pro_fname, true, 'OR');
            $criteria->compare('Profiles.lastname', $pro_fname, true, 'OR');
        }

        if(isset($ex_fullname[1])){
            $pro_lname = $ex_fullname[1];
            $criteria->compare('Profiles.lastname',$pro_lname,true);
            $criteria->compare('Profiles.lastname_en', $pro_lname, true, 'OR');
        }
    }

    if(isset($_GET['idcard']) && $_GET['idcard'] != null){
        $criteria->compare('Profiles.identification',$_GET['idcard'],true);
    }

    if(isset($_GET['course_number']) && $_GET['course_number'] != null){
        $criteria->compare('passcours.passcours_cours',$_GET['course_number']);
    }

    if(isset($_GET['course_codenum']) && $_GET['course_codenum'] != null){
        $criteria->compare('passcours.passcours_number',$_GET['course_codenum'],true);
    }

    if(isset($_GET['search_year']) && $_GET['search_year'] != ""){

        $start = $_GET['search_year']."-01-01 00:00:00";
        $end = $_GET['search_year']."-12-31 23:59:59";

        $criteria->addCondition('passcours.cours_start_date >= :date_str');
        $criteria->params[':date_str'] = $start;

        $criteria->addCondition('passcours.passcours_date <= :date_end');
        $criteria->params[':date_end'] = $end;


    }else{
       if((isset($_GET['datestr']) && $_GET['datestr'] != "") && (isset($_GET['dateend']) && $_GET['dateend'] != "")){

        $criteria->addCondition('passcours.cours_start_date >= :date_str');
        $criteria->params[':date_str'] = $_GET['datestr'];

        $criteria->addCondition('passcours.passcours_date <= :date_end');
        $criteria->params[':date_end'] = $_GET['dateend'];

    }else if(isset($_GET['datestr']) && $_GET['datestr'] != ""){

        $criteria->addCondition('passcours.cours_start_date >= :date_str');
        $criteria->params[':date_str'] = $_GET['datestr'];

    }else if(isset($_GET['dateend']) && $_GET['dateend'] != ""){

        $criteria->addCondition('passcours.passcours_date <= :date_end');
        $criteria->params[':date_end'] = $_GET['dateend'];
    }
}
$PassCourses = Passcours::model()->findAll($criteria);
//End PassCourses


//Start PassCourseImport
$course_online_arr = [];

if($_GET["course_number"] != null && $_GET["course_number"] != ""){

    $course_online = CourseOnline::model()->findByPk($_GET["course_number"]);
    if($course_online == null){
        $course_online_ = CourseOnline::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1'));
        foreach ($course_online_ as $keyc => $valc) {
            $course_online_arr[] = $valc->course_md_code;
        }
    }else{
        $course_online_arr[] = $course_online->course_md_code;
    }
    $course_online = MsTeams::model()->findByAttributes(array('course_md_code' => $_GET["course_number"]));
    if($course_online == null){
        $course_online_ = MsTeams::model()->findAll(array('condition'=>'active = "y"'));
        foreach ($course_online_ as $keyc => $valc) {
            $course_online_arr[] = $valc->course_md_code;
        }
    }else{
        $course_online_arr[] = $course_online->course_md_code;
    }
}else{
    $course_online_ = CourseOnline::model()->findAll(array('condition'=>'active = "y" AND lang_id = 1'));
    foreach ($course_online_ as $keyc => $valc) {
        $course_online_arr[] = $valc->course_md_code;
    }
    $course_online_ = MsTeams::model()->findAll(array('condition'=>'active = "y"'));
    foreach ($course_online_ as $keyc => $valc) {
        $course_online_arr[] = $valc->course_md_code;
    }
}

$criteria = new CDbCriteria;
$criteria->addIncondition('course_md_id',$course_online_arr);

if(isset($_GET['nameSearch']) && $_GET['nameSearch'] != null){
    $ex_fullname = explode(" ", $_GET['nameSearch']);

    if(isset($ex_fullname[0])){
        $pro_fname = $ex_fullname[0];
        $criteria->compare('fname', $pro_fname, true);
        $criteria->compare('lname', $pro_fname, true, 'OR');
    }

    if(isset($ex_fullname[1])){
        $pro_lname = $ex_fullname[1];
        $criteria->compare('fname',$pro_lname,true);
        $criteria->compare('lname', $pro_lname, true, 'OR');
    }
}

if(isset($_GET['idcard']) && $_GET['idcard'] != null){
    $criteria->compare('idcard',$_GET['idcard'],true);
}

if(isset($_GET['institution_id']) && $_GET['institution_id'] != null){
    $criteria->compare('institution_id',$_GET['institution_id']);
}

if(isset($_GET['course_codenum']) && $_GET['course_codenum'] != null){
    $criteria->compare('course_number',$_GET['course_codenum'],true);
}

if(isset($_GET['search_year']) && $_GET['search_year'] != ""){

    $start = $_GET['search_year']."-01-01 00:00:00";
    $end = $_GET['search_year']."-12-31 23:59:59";

    $criteria->addCondition('startdate >= :date_str');
    $criteria->params[':date_str'] = $start;

    $criteria->addCondition('enddate <= :date_end');
    $criteria->params[':date_end'] = $end;


}else{

   if((isset($_GET['datestr']) && $_GET['datestr'] != "") && (isset($_GET['dateend']) && $_GET['dateend'] != "")){

    $criteria->addCondition('startdate >= :date_str');
    $criteria->params[':date_str'] = $_GET['datestr'];

    $criteria->addCondition('enddate <= :date_end');
    $criteria->params[':date_end'] = $_GET['dateend'];

}else if(isset($_GET['datestr']) && $_GET['datestr'] != ""){

    $criteria->addCondition('startdate >= :date_str');
    $criteria->params[':date_str'] = $_GET['datestr'];

}else if(isset($_GET['dateend']) && $_GET['dateend'] != ""){

    $criteria->addCondition('enddate <= :date_end');
    $criteria->params[':date_end'] = $_GET['dateend'];
}
}
$PassCourseImport = ImportPassMd::model()->findAll($criteria);
//End PassCourseImport
}


if(count($PassCourses) > 0){
    if(!empty($PassCourses)){
        foreach($PassCourses as $i => $val) { 
            $keytest = ($i) + 2;
            $key = ($i) + 1;

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $keytest, $key++);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $keytest, "'".$val->Profiles->identification);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $keytest, $val->Profiles->ProfilesTitle->prof_title);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $keytest, $val->Profiles->firstname);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $keytest, $val->Profiles->lastname);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $keytest, 'โรงเรียนสุภาพบุรุษเดินเรือ');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $keytest, $val->CourseOnlines->course_title);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $keytest, $val->passcours_number);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $keytest, Helpers::lib()->changeFormatDateNewEn($val->cours_start_date ,'full'));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $keytest, Helpers::lib()->changeFormatDateNewEn($val->passcours_date ,'full'));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $keytest, "-");
        }
    }
}else{

    if(!empty($PassCourseImport)){
        foreach ($PassCourseImport as $key => $value) {
            $keytest = ($key) + 2;
            $key = ($key) + 1;

            $couOn = CourseOnline::model()->find(array(
                'condition' => 'course_md_code="' . $value->course_md_id . '"',
            ));

            $InsOn = Institution::model()->find(array(
                'condition' => 'code="' . $value->institution_id . '"',
            ));

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $keytest, $key++);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $keytest, "'".$value->idcard);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $keytest, $value->title);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $keytest, $value->fname);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $keytest, $value->lname);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $keytest, $InsOn->institution_name);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $keytest, $couOn->course_title);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $keytest, $value->course_number);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $keytest, Helpers::lib()->changeFormatDateNewEn($value->startdate ,'full'));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $keytest, Helpers::lib()->changeFormatDateNewEn($value->enddate ,'full'));
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $keytest, $value->note);

        }

    }
}

       header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="รายงานผู้ผ่านการเรียน.xlsx"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter->save('php://output');
        
    }




    public function actionGenExcelBookingCourse(){

        require dirname(__FILE__) . "/../extensions/phpexcel/Classes/PHPExcel.php";
        require dirname(__FILE__) . "/../extensions/phpexcel/Classes/PHPExcel/IOFactory.php";

        $objPHPExcel = new PHPExcel();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ลำดับ');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'รหัสหลักสูตร');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'เลขบัตรประชาชน');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, 'คำนำหน้าชื่อ');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, 'ชื่อ');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, 'นามสกุล');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, 'หลักสูตร');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, 'วันที่เริ่ม');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, 'วันที่จบ');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, 'สถานะ');

        $criteria = new CDbCriteria;

        if($_GET['type_cou'] == 1){
            $criteria->with = array('profile', 'course');
        }else if($_GET['type_cou'] == 2){
            $criteria->with = array('profile', 'teams');
        }

        if(isset($_GET['nameSearch']) && $_GET['nameSearch'] != null){
            $ex_fullname = explode(" ", $_GET['nameSearch']);

            if(isset($ex_fullname[0])){
                $pro_fname = $ex_fullname[0];
                $criteria->compare('profile.firstname_en', $pro_fname, true);
                $criteria->compare('profile.lastname_en', $pro_fname, true, 'OR');
                $criteria->compare('profile.firstname', $pro_fname, true, 'OR');
                $criteria->compare('profile.lastname', $pro_fname, true, 'OR');
            }

            if(isset($ex_fullname[1])){
                $pro_lname = $ex_fullname[1];
                $criteria->compare('profile.lastname',$pro_lname,true);
                $criteria->compare('profile.lastname_en', $pro_lname, true, 'OR');
            }
        }

        if(isset($_GET['idcard']) && $_GET['idcard'] != null){
            $criteria->compare('profile.identification',$_GET['idcard'],true);
        }

        if($_GET['type_cou'] == 1){

            if(isset($_GET['course_number']) && $_GET['course_number'] != null){
                $criteria->compare('courseonline.course_id',$_GET['course_number']);
            }

            if(isset($_GET['course_codenum']) && $_GET['course_codenum'] != null){
                $criteria->compare('courseonline.course_number',$_GET['course_codenum'],true);
            }

            if((isset($_GET['datestr']) && $_GET['datestr'] != "") && (isset($_GET['dateend']) && $_GET['dateend'] != "")){

                $criteria->addCondition('courseonline.course_date_start >= :date_str');
                $criteria->params[':date_str'] = $_GET['datestr'];

                $criteria->addCondition('courseonline.course_date_end <= :date_end');
                $criteria->params[':date_end'] = $_GET['dateend'];

            }else if(isset($_GET['datestr']) && $_GET['datestr'] != ""){

                $criteria->addCondition('courseonline.course_date_start >= :date_str');
                $criteria->params[':date_str'] = $_GET['datestr'];

            }else if(isset($_GET['dateend']) && $_GET['dateend'] != ""){

                $criteria->addCondition('courseonline.course_date_end <= :date_end');
                $criteria->params[':date_end'] = $_GET['dateend'];
            }


            if(isset($_GET['status_booking']) && $_GET['status_booking'] != null){
                $sta = $_GET['status_booking'];

                if($sta == 1){
                    $criteria->compare('t.status','n');
                    $criteria->addCondition('t.file_payment IS NULL');
                }else if($sta == 2){
                    $criteria->compare('t.status','y');
                }else if($sta == 3){
                    $criteria->compare('t.status','n');
                    $criteria->addCondition('t.file_payment IS NOT NULL');
                }
            }

            $Temp = CourseTemp::model()->findAll($criteria);

        }else if($_GET['type_cou'] == 2){

            if(isset($_GET['ms_teams_id']) && $_GET['ms_teams_id'] != null){
                $criteria->compare('teams.id',$_GET['ms_teams_id']);
            }


            if((isset($_GET['datestr']) && $_GET['datestr'] != "") && (isset($_GET['dateend']) && $_GET['dateend'] != "")){

                $criteria->addCondition('teams.start_date >= :date_str');
                $criteria->params[':date_str'] = $_GET['datestr'];

                $criteria->addCondition('teams.end_date <= :date_end');
                $criteria->params[':date_end'] = $_GET['dateend'];

            }else if(isset($_GET['datestr']) && $_GET['datestr'] != ""){

                $criteria->addCondition('teams.start_date >= :date_str');
                $criteria->params[':date_str'] = $_GET['datestr'];

            }else if(isset($_GET['dateend']) && $_GET['dateend'] != ""){

                $criteria->addCondition('teams.end_date <= :date_end');
                $criteria->params[':date_end'] = $_GET['dateend'];
            }


            if(isset($_GET['status_booking']) && $_GET['status_booking'] != null){
                $sta = $_GET['status_booking'];

                if($sta == 1){
                    $criteria->compare('t.status','n');
                    $criteria->addCondition('t.file_payment IS NULL');
                }else if($sta == 2){
                    $criteria->compare('t.status','y');
                }else if($sta == 3){
                    $criteria->compare('t.status','n');
                    $criteria->addCondition('t.file_payment IS NOT NULL');
                }
            }

            $Temp = MsteamsTemp::model()->findAll($criteria);
        }

        if(!empty($Temp)){
            foreach($Temp as $i => $val) { 
                $keytest = ($i) + 2;
                $key = ($i) + 1;

                if($val->status == "n" && $val->file_payment == null){
                   $stus = "ยังไม่ได้ชำระ"; 
               }else if($val->status == "n"){
                   $stus = "รอการอนุมัติจากผู้ดูแลระบบ" ;
               }else if($val->status == "y"){
                   $stus = "ชำระเรียบร้อยแล้ว" ;
               }

               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $keytest, $key++);
               if($_GET['type_cou'] == 1){
                  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $keytest, $val->course->course_number);
              }else if($_GET['type_cou'] == 2){
                  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $keytest, '-');
              }
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $keytest, "'".$val->profile->identification);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $keytest, $val->profile->ProfilesTitle->prof_title);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $keytest, $val->profile->firstname);
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $keytest, $val->profile->lastname);

              if($_GET['type_cou'] == 1){

                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $keytest, $val->course->course_title);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $keytest, Helpers::lib()->changeFormatDateNewEn($val->course->course_date_start ,'full'));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $keytest, Helpers::lib()->changeFormatDateNewEn($val->course->course_date_end ,'full'));

            }else if($_GET['type_cou'] == 2){

                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $keytest, $val->teams->name_ms_teams);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $keytest, Helpers::lib()->changeFormatDateNewEn($val->teams->start_date ,'full'));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $keytest, Helpers::lib()->changeFormatDateNewEn($val->teams->end_date ,'full'));
            }

            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $keytest, $stus);




        }
    }

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="รายงานสถานะการจองหลักสูตร.xlsx"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter->save('php://output');
        
    }






    public function actionGenPdfConditionMd(){
        $model = new Report('ByCourse');
        $model->unsetAttributes();

        if($id!=null) {
            $model->course_id = $id;
        }

        if(isset($_GET['Report'])) {
            $model->nameSearch = $_GET['Report']['search'];
            $model->course_id = $_GET['Report']['course_id'];
        }

        $renderFile = 'PdfByCourse';
        require_once __DIR__ . '/../vendors/mpdf7/autoload.php';
        $mPDF = new \Mpdf\Mpdf(['orientation' => 'L']);
        $mPDF->WriteHTML(mb_convert_encoding($this->renderPartial($renderFile, array('model'=>$model),true),'UTF-8','UTF-8'));
        $mPDF->Output("PdfByCourse.pdf" , 'D');

    }

    public function actionGetListMsTeams()
    {
        if (isset($_POST["value"])) {
            $criteria = new CDbCriteria;
            if($_POST["value"] != ""){
                $criteria->condition = "create_date >'".$_POST["value"]."-01-01 00:00:00' AND create_date < '".$_POST["value"]."-12-31 23:59:59'";
            }
            $criteria->order = "create_date DESC";
            $modelMsTeams = MsTeams::model()->findAll($criteria);
            if($modelMsTeams){
                $listText = "<option value=''>--- เลือกห้องเรียนออนไลน์ ---</option>";
                foreach ($modelMsTeams as $key => $mss) {
                    $placeHolder = (( $mss->course_md_code != "" && $mss->course_md_code != null )?$mss->course_md_code: "ไม่พบรหัส")." : ".$mss->name_ms_teams." (".(Helpers::lib()->DateThaiNewNoTime($mss->start_date)." - ".Helpers::lib()->DateThaiNewNoTime($mss->end_date)).")";
                    $listText .= "<option ".($_POST["selected"] == $mss->id ? "selected" : "" )." value='".$mss->id."'>".$placeHolder."</option>";
                }
            }else{
                $listText = "<option value=''>ยังไม่มีห้องเรียนออนไลน์</option>";
            }
            echo $listText;exit();
        }
    }

    public function actionGetList()
    {
        if (isset($_POST["year"]) && $_POST["type"]==2) {
            $criteria = new CDbCriteria;
            if($_POST["year"] != ""){
                $criteria->condition = "create_date >'".$_POST["year"]."-01-01 00:00:00' AND create_date < '".$_POST["year"]."-12-31 23:59:59'";
            }
            $criteria->compare("active","y");
            //แสดงตาม Group
            $modelUser = Users::model()->findByPk(Yii::app()->user->id);
            $group = json_decode($modelUser->group);
            if (!in_array(1, $group)){
                $groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
                $criteria->addInCondition('create_by', $groupUser);    
            }
            $criteria->order = "create_date DESC";
            $modelMsTeams = MsTeams::model()->findAll($criteria);
            if($modelMsTeams){
                $listText = "<option value=''>--- เลือกห้องเรียนออนไลน์ ---</option>";
                foreach ($modelMsTeams as $key => $mss) {
                    $placeHolder = (( $mss->course_md_code != "" && $mss->course_md_code != null )?$mss->course_md_code: "ไม่พบรหัส")." : ".$mss->name_ms_teams;
                    $listText .= "<option ".($_POST["selected"] == $mss->id ? "selected" : "" )." value='".$mss->id."'>".$placeHolder."</option>";
                }
            }else{
                $listText = "<option value=''>ยังไม่มีห้องเรียนออนไลน์</option>";
            }
            echo $listText;exit();
        }else if(isset($_POST["year"]) && $_POST["type"]==1){
            $criteria = new CDbCriteria;
            if($_POST["year"] != ""){
                $criteria->condition = "create_date >'".$_POST["year"]."-01-01 00:00:00' AND create_date < '".$_POST["year"]."-12-31 23:59:59'";
            }
            $criteria->compare("active","y");
            $criteria->compare("parent_id",0);
            //แสดงตาม Group
            $modelUser = Users::model()->findByPk(Yii::app()->user->id);
            $group = json_decode($modelUser->group);
            if (!in_array(1, $group)){
                $groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
                $criteria->addInCondition('create_by', $groupUser);    
            }
            $criteria->order = "create_date DESC";
            $modelCourse = CourseOnline::model()->findAll($criteria);
            if($modelCourse){
                $listText = "<option value=''>--- เลือกหลักสูตรทฤษฎี ---</option>";
                foreach ($modelCourse as $key => $course) {
                    // $placeHolder = (( $course->course_md_code != "" && $course->course_md_code != null )?$course->course_md_code: "ไม่พบรหัส")." : ".$course->course_title." (".(Helpers::lib()->DateThaiNewNoTime($course->course_date_start)." - ".Helpers::lib()->DateThaiNewNoTime($course->course_date_end)).")";
                     $placeHolder = (( $course->course_md_code != "" && $course->course_md_code != null )?$course->course_md_code: "ไม่พบรหัส")." : ".$course->course_title;
                    $listText .= "<option ".($_POST["selected"] == $course->course_id ? "selected" : "" )." value='".$course->course_id."'>".$placeHolder."</option>";
                }
            }else{
                $listText = "<option value=''>ยังไม่มีหลักสูตรทฤษฎี</option>";
            }
            echo $listText;exit();
        }
    }

    public function actionGetGeneration(){
        $course_id = $_POST['course_id'];

        $criteria = new CDbCriteria;
        $criteria->compare("active","y");
        $criteria->compare("course_id",$course_id);
        $criteria->order = 'create_date DESC';
        $generation = CourseGeneration::model()->findAll($criteria);
        if($generation){
            $listText = "<option value=''>--- เลือกรุ่นหลักสูตร ---</option>"; 
            foreach ($generation as $gen) {
                $listText .= "<option value='".$gen->gen_id."'>"."รุ่น ".$gen->gen_title."&nbsp;&nbsp;&nbsp;(". Helpers::lib()->CuttimeLang2($gen->gen_period_start, 2)." - ".Helpers::lib()->CuttimeLang2($gen->gen_period_end, 2).")"."</option>";
            }
        }else{
            $listText = "<option value=''>--- ไม่พบรุ่นหลักสูตร ---</option>"; 
        }

        echo $listText;
    }
}