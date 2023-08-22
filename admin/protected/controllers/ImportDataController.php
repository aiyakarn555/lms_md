<?php
class ImportDataController extends Controller
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



    public function actionImportExcelIndex()
    {
     $model=new ImportConditionMd('search');

     if(isset($_GET['ImportConditionMd']))
        $model->attributes=$_GET['ImportConditionMd'];
    $model->fullname=$_GET['ImportConditionMd']['fullname'];



    $this->render('import_excel_index',array(
        'model'=>$model
    ));
}

public function actionImportExcelPassIndex()
    {
     $model=new ImportPassMd('search');

     if(isset($_GET['ImportPassMd']))
        $model->attributes=$_GET['ImportPassMd'];
        $model->fullname=$_GET['ImportPassMd']['fullname'];

    $this->render('import_excel_pass_index',array(
        'model'=>$model
    ));

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
                    if($result["รหัสสถาบัน"] != 7){

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

                          $datest = $result["วันที่เริ่ม (คศ)"];
                          $dateen = $result["วันสุดท้าย (คศ)"];

                          $models->startdate = $datest;
                          $models->enddate = $dateen;

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
                   if($result["รหัสสถาบัน"] != 7){
                      
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




}