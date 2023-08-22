<?php

class CaptureScreenController extends Controller
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
            array(
                'allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array(
                'allow',
                // กำหนดสิทธิ์เข้าใช้งาน actionIndex
                'actions' => AccessControl::check_action(),
                // ได้เฉพาะ group 1 เท่านั่น
                'expression' => 'AccessControl::check_access()',
            ),
            array(
                'deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    public $layout = '//layouts/column2';


    public function actionExportIndex()
    {

        $criteria = new CDbCriteria;
        $data = [];

        if (isset($_GET["names"])) {


            $new_pro = explode(" ",$_GET["names"]);
            if(count($new_pro) == 1){
                $criteria->compare("firstname",$new_pro[0]);
            }

            if(count($new_pro) == 2){
                $criteria->compare("lastname",$new_pro[1]);
            }

            $Pros = Profile::model()->findAll($criteria);
            $pro_id = [];
            foreach ($Pros as $key => $value) {
                $pro_id[] = $value->user_id;
            }
        }

        if (isset($_GET["gen_id"])) {
            $criteria->compare("gen.gen_id",$_GET["gen_id"]);
        }

        if (isset($_GET["ms_temas"])) {
            if (isset($_GET["names"])) {
                $criteria->addIncondition('t.user_id',$pro_id);
            }

            $criteria->compare("ms_teams_id",$_GET["ms_temas"]);
            $data = LogStartMsTeams::model()->with('pro','gen')->findAll($criteria);
            // $data = CaptureMsTeams::model()->with('pro')->findAll($criteria);
        }

        $this->render('exportindex', array('data' => $data));
    }

    public function actionExportView($id)
    {
        $Profiles = Profile::model()->findByPk($id);
        $MsTeamss = MsTeams::model()->findByPk($_GET["ms_teams_id"]);

        $criteria = new CDbCriteria;
        $criteria->compare("t.user_id",$id);
        $criteria->compare("ms_teams_id",$_GET["ms_teams_id"]);
        $criteria->order = 'create_date DESC';
        $criteria->limit = 5;
        $CaptureMsTeams = CaptureMsTeams::model()->with('pro')->findAll($criteria);


        $criteria = new CDbCriteria;
        $criteria->compare("ms_teams_id",$_GET["ms_teams_id"]);
        $criteria->order = 'upload_date DESC';
        $UploadMsTeams = UploadMsTeams::model()->findAll($criteria);

        $this->render('exportview', array('model' => $CaptureMsTeams ,'Profiles' => $Profiles , 'MsTeamss' => $MsTeamss ,'upload'=>$UploadMsTeams));
    }

    public function actionExportViewAll($id)
    {

        $MsTeamss = MsTeams::model()->findByPk($id);

        // $criteria = new CDbCriteria;
        // // $criteria->compare("t.user_id",$id);
        // $criteria->compare("ms_teams_id",$id);
        // $criteria->order = 'create_date DESC';
        // // $criteria->limit = 5;
        // $CaptureMsTeams = CaptureMsTeams::model()->with('pro')->findAll($criteria);

        $criteria = new CDbCriteria;
        $criteria->compare("ms_teams_id",$id);
        $criteria->compare("t.active","y");
        $data = LogStartMsTeams::model()->with('pro')->findAll($criteria);


        $this->render('exportviewall', array('model' => $data , 'MsTeamss' => $MsTeamss ));
        
    }

    public function actionGenAllExcelCaptureScreen()
    {
        require dirname(__FILE__) . "/../extensions/phpexcel/Classes/PHPExcel.php";
        require dirname(__FILE__) . "/../extensions/phpexcel/Classes/PHPExcel/IOFactory.php";


        $objPHPExcel = new PHPExcel();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ลำดับ');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'ชื่อ นามสกุล');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'หลักสูตร');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, 'บทเรียน');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, 'รุ่น');

        $row = 2;

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        // $objDrawing->setPath(Yii::app()->request->baseUrl.'/uploads/'.);
        $objDrawing->setCoordinates('A' . $row);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->getRowDimension($rowNumber)->setRowHeight(120);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, 'test');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, 'test');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, 'test');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, 'test');

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="CaptureScreenExport.xlsx"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter->save('php://output');
    }
    public function actionGenSingleExcelCaptureScreen($id)
    {

        $Profiles = Profile::model()->findByPk($id);
        $MsTeamss = MsTeams::model()->findByPk($_GET["ms_teams_id"]);

        require dirname(__FILE__) . "/../extensions/phpexcel/Classes/PHPExcel.php";
        require dirname(__FILE__) . "/../extensions/phpexcel/Classes/PHPExcel/IOFactory.php";

        $objPHPExcel = new PHPExcel();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ลำดับ');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'ชื่อ นามสกุล');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'หลักสูตร');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, 'บทเรียน');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, 'รุ่น');

        $row = 2;
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();

        // $objDrawing->setPath(Yii::app()->request->baseUrl.'/uploads/FaceRegis/1.jpg');
        $objDrawing->setCoordinates('A' . $row);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        $objPHPExcel->getActiveSheet()->getRowDimension($rowNumber)->setRowHeight(120);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, 'test');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, 'test');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, 'test');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, 'test');


        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="CaptureScreenExport.xlsx"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter->save('php://output');
    }


    public function actionExportIndexTheory()
    {

        $criteria = new CDbCriteria;
        $data = [];

        if (isset($_GET["names"])) {


            $new_pro = explode(" ",$_GET["names"]);
            if(count($new_pro) == 1){
                $criteria->compare("firstname",$new_pro[0]);
            }

            if(count($new_pro) == 2){
                $criteria->compare("lastname",$new_pro[1]);
            }

            $Pros = Profile::model()->findAll($criteria);
            $pro_id = [];
            foreach ($Pros as $key => $value) {
                $pro_id[] = $value->user_id;
            }
        }

        if (isset($_GET["gen_id"])) {
            $criteria->compare("gen.gen_id",$_GET["gen_id"]);
        }


        if (isset($_GET["course_id"])) {
            if (isset($_GET["names"])) {
                $criteria->addIncondition('t.user_id',$pro_id);
            }

            $criteria->compare("t.course_id",$_GET["course_id"]);
            $criteria->addCondition('pro.user_id IS NOT NULL');
            $data = LogStartcourse::model()->with('pro','gen')->findAll($criteria);
            // $data = CaptureMsTeams::model()->with('pro')->findAll($criteria);
        }

        $this->render('exportindextheory', array('data' => $data));
    }


    public function actionExportViewTheory($id)
    {
        $Profiles = Profile::model()->findByPk($id);
        $Courses = CourseOnline::model()->findByPk($_GET["course_id"]);

        $criteria = new CDbCriteria;
        $criteria->compare("t.user_id",$id);
        $criteria->compare("course_id",$_GET["course_id"]);
        $criteria->order = 'create_date DESC';
        $criteria->limit = 5;
        $CaptureLearn = CaptureLearn::model()->with('pro')->findAll($criteria);


        $this->render('exportviewtheory', array('model' => $CaptureLearn ,'Profiles' => $Profiles , 'Courses' => $Courses ));
    }


    public function actionExportViewAllTheory($id)
    {

        $Courses = CourseOnline::model()->findByPk($id);

        $criteria = new CDbCriteria;
        $criteria->compare("course_id",$id);
        $criteria->compare("t.active","y");
        $criteria->addCondition('pro.user_id IS NOT NULL');
        $data = LogStartcourse::model()->with('pro')->findAll($criteria);


        $this->render('exportviewalltheory', array('model' => $data ,'Courses' => $Courses ));
        
    }


    public function actionGenAllExcelCaptureScreenTheory()
    {
        require dirname(__FILE__) . "/../extensions/phpexcel/Classes/PHPExcel.php";
        require dirname(__FILE__) . "/../extensions/phpexcel/Classes/PHPExcel/IOFactory.php";


        $objPHPExcel = new PHPExcel();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ลำดับ');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'ชื่อ นามสกุล');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'หลักสูตร');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, 'บทเรียน');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, 'รุ่น');

        $row = 2;

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        // $objDrawing->setPath(Yii::app()->request->baseUrl.'/uploads/'.);
        $objDrawing->setCoordinates('A' . $row);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objPHPExcel->getActiveSheet()->getRowDimension($rowNumber)->setRowHeight(120);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, 'test');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, 'test');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, 'test');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, 'test');

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="CaptureScreenExport.xlsx"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter->save('php://output');
    }
    public function actionGenSingleExcelCaptureScreenTheory($id)
    {

        $Profiles = Profile::model()->findByPk($id);
        $MsTeamss = MsTeams::model()->findByPk($_GET["ms_teams_id"]);

        require dirname(__FILE__) . "/../extensions/phpexcel/Classes/PHPExcel.php";
        require dirname(__FILE__) . "/../extensions/phpexcel/Classes/PHPExcel/IOFactory.php";

        $objPHPExcel = new PHPExcel();
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'ลำดับ');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'ชื่อ นามสกุล');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'หลักสูตร');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, 'บทเรียน');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, 'รุ่น');

        $row = 2;
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();

        // $objDrawing->setPath(Yii::app()->request->baseUrl.'/uploads/FaceRegis/1.jpg');
        $objDrawing->setCoordinates('A' . $row);
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        $objPHPExcel->getActiveSheet()->getRowDimension($rowNumber)->setRowHeight(120);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, 'test');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, 'test');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, 'test');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, 'test');


        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="CaptureScreenExport.xlsx"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $objWriter->save('php://output');
    }


    public function actionGetGeneration(){
        if($_POST['course_id']){
            $course_id = $_POST['course_id'];
        }else {
            $course_id = $_POST['ms_temas'];
        }

        $criteria = new CDbCriteria;
        $criteria->compare("active","y");
        $criteria->compare("course_id",$course_id);
        $criteria->order = 'create_date DESC';
        $generation = CourseGeneration::model()->findAll($criteria);
        if($generation){
            $listText = "<option value=''>--- เลือกรุ่นหลักสูตร ---</option>"; 
            foreach ($generation as $gen) {
                $listText .= "<option value='".$gen->gen_id."'>".$gen->gen_detail."&nbsp;&nbsp;&nbsp;(". Helpers::lib()->CuttimeLang($gen->gen_period_start, 2)." - ".Helpers::lib()->CuttimeLang($gen->gen_period_end, 2).")"."</option>";
            }
        }else{
            $listText = "<option value=''>--- ไม่พบรุ่นหลักสูตร ---</option>"; 
        }

        echo $listText;
    }


}
