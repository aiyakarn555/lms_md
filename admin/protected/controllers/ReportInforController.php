<?php
/**
 * Created by PhpStorm.
 * User: nutti_000
 * Date: 7/5/2558
 * Time: 16:22
 */

class ReportInforController extends Controller
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
    public function actionProvince()
    {
        $model=new ReportInfor();
        $model->unsetAttributes();
        if(isset($_GET['ReportInfor'])){
            $model->attributes=$_GET['ReportInfor'];
        }

        $this->render('province',array('model'=>$model));
    }

    public function actionByProvince() {

        $model = new ReportInfor('ByProvince');
        $model->unsetAttributes();

        if(isset($_GET['ByProvince'])) {
            $model->province = $_GET['ByProvince']['Province'];
        }

        $this->render('ByProvince', array(
            'model' => $model,
        ));

    }

    public function actionBusinessType()
    {
        $model=new ReportInfor();
        $model->unsetAttributes();
        if(isset($_GET['ReportInfor'])){
            $model->attributes=$_GET['ReportInfor'];
        }

        $this->render('BusinessType',array('model'=>$model));
    }

    public function actionBusinessModel()
    {
        $model=new ReportInfor();
        $model->unsetAttributes();
        if(isset($_GET['ReportInfor'])){
            $model->attributes=$_GET['ReportInfor'];
        }

        $this->render('BusinessModel',array('model'=>$model));
    }

    public function actionStudy()
    {
        $model=new ReportInfor();
        $model->unsetAttributes();
        if(isset($_GET['ReportInfor'])){
            $model->attributes=$_GET['ReportInfor'];
        }

        $this->render('Study',array('model'=>$model));
    }

    public function actionCareer()
    {
        $model=new ReportInfor();
        $model->unsetAttributes();
        if(isset($_GET['ReportInfor'])){
            $model->attributes=$_GET['ReportInfor'];
        }

        $this->render('Career',array('model'=>$model));
    }

    public function actionRelations()
    {
        $model=new ReportInfor();
        $model->unsetAttributes();
        if(isset($_GET['ReportInfor'])){
            $model->attributes=$_GET['ReportInfor'];
        }

        $this->render('Relations',array('model'=>$model));
    }

    public function actionSaveChart()
    {
        function base64_to_jpeg($base64_string) {
            $data = explode(',', $base64_string);

            return base64_decode($data[1]);
        }

        if(isset($_POST)){
            $save = file_put_contents(Yii::app()->basePath."/../uploads/".$_POST['name'].".png",base64_to_jpeg($_POST['image_base64']));
            $array = array('msg'=>'success');
            echo json_encode($array);
        }

    }

    public function actionExportIndex()
    {
        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ลำดับ')
            ->setCellValue('B1', 'หลักสูตร/หัวข้อวิชา')
            ->setCellValue('C1', 'จำนวนผู้เรียน')
            ->setCellValue('D1', 'ผ่าน')
            ->setCellValue('E1', 'ไม่ผ่าน')
            ->setCellValue('F1', '%การจบ');

        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);

        $style = array(
            'font' => array('bold' => true, 'size' => 10,),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        $objPHPExcel->getActiveSheet()->getStyle("A1:F1")->applyFromArray($style);


        $model=new Report();
        $model->unsetAttributes();
        if(isset($_GET['Report']))
            $model->attributes=$_GET['Report'];

                $cate_type = array('university'=>1,'company'=>2);
                if($model->typeOfUser != '') {
                    $cate_id = '';
                    if($model->typeOfUser == 'university'){
                        if($model->categoryUniversity != ''){
                            $cate_id = $model->categoryUniversity;
                        }
                    }
                    if($model->typeOfUser == 'company'){
                        if($model->categoryCompany != ''){
                            $cate_id = $model->categoryCompany;
                        }
                    }

                    if($cate_id == '') {
                        $course = CourseOnline::model()->with('cates')->findAll(array(
                            'condition' => 'courseonline.active = "y" AND cate_type="' . $cate_type[$model->typeOfUser] . '"',
                            'order' => 'sortOrder'
                        ));
                    }else{
                        $course = CourseOnline::model()->with('cates')->findAll(array(
                            'condition' => 'courseonline.active = "y" AND cate_type="' . $cate_type[$model->typeOfUser] . '" AND categorys.cate_id ="'.$cate_id.'"',
                            'order' => 'sortOrder'
                        ));
                    }
                }else{
                    $course = CourseOnline::model()->findAll(array(
                        'condition' => 'active = "y"',
                        'order' => 'sortOrder'
                    ));
                }
                $courseAllCountTotal = 0;
                $coursePassCountTotal = 0;
                $courseAllCount = array();
                $coursePassCount = array();
                $i = 2;
                foreach ($course as $key => $courseItem) {
                    $courseTitle[$key] = $courseItem->course_title;
                    $courseAllCount[$key] = 0;
                    $coursePassCount[$key] = 0;

                    if(isset($owner_id)) {
                        $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y" AND create_by ="'.$owner_id.'"', 'order' => 'title'));
                    }else{
                        $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y"', 'order' => 'title'));
                    }
                    foreach ($lesson as $lessonItem) {
                        /** @var Lesson $lessonItem */
                        $sqlAll = " SELECT COUNT(*) FROM tbl_learn INNER JOIN tbl_users ON tbl_learn.user_id = tbl_users.id ";
                        if($model->typeOfUser == 'university' ) {
                            $sqlAll .= " INNER JOIN university ON tbl_users.student_house = university.id ";
                        }
                        $sqlAll .= " WHERE lesson_id = '".$lessonItem->id."' AND tbl_users.status = '1' ";
                        if($model->typeOfUser == 'university' ) {
                            if($model->university != '') {
                                $sqlAll .= " AND university.id = '".$model->university."' ";
                            }
                        }
                        if($model->typeOfUser !='' ) {
                            $sqlAll .= " AND authitem_name = '" . $model->typeOfUser . "' ";
                        }

                        if($model->dateRang !='' ) {
                            list($start,$end) = explode(" - ",$model->dateRang);
                            $start = date("Y-d-m",strtotime($start))." 00:00:00";
                            $end = date("Y-d-m",strtotime($end))." 23:59:59";
                            $sqlAll .= " AND learn_date BETWEEN '" . $start . "' AND '".$end."'";
                        }

                        $allCount = Yii::app()->db->createCommand($sqlAll)->queryScalar();

                        $sqlPass = " SELECT COUNT(*) FROM tbl_learn learnmain
 INNER JOIN tbl_users
 ON learnmain.user_id = tbl_users.id";
                        if($model->typeOfUser == 'university' ) {
                            $sqlPass .= " INNER JOIN university ON tbl_users.student_house = university.id ";
                        }
                        $sqlPass .= "
 WHERE lesson_id = '".$lessonItem->id."'
 AND (SELECT COUNT(*) FROM tbl_file WHERE lesson_id = learnmain.lesson_id) = (SELECT COUNT(*) FROM tbl_learn_file WHERE learn_id = learnmain.learn_id AND learn_file_status = 's')
 AND ((SELECT COUNT(*) FROM tbl_score WHERE lesson_id = learnmain.lesson_id AND user_id = learnmain.user_id AND tbl_score.type='post' AND score_past='y') > 0 OR (SELECT COUNT(*) FROM tbl_manage WHERE id = learnmain.lesson_id AND type='post') = 0)";

                        if($model->typeOfUser == 'university' ) {
                            if($model->university != '') {
                                $sqlPass .= " AND university.id = '".$model->university."' ";
                            }
                        }

                        if($model->typeOfUser !='' ) {
                            $sqlPass .= " AND authitem_name = '" . $model->typeOfUser . "' ";
                        }

                        if($model->dateRang !='' ) {
                            list($start,$end) = explode(" - ",$model->dateRang);
                            $start = date("Y-d-m",strtotime($start))." 00:00:00";
                            $end = date("Y-d-m",strtotime($end))." 23:59:59";
                            $sqlPass .= " AND learn_date BETWEEN '" . $start . "' AND '".$end."'";
                        }

                        $passCount = Yii::app()->db->createCommand($sqlPass)->queryScalar();

//                        $sqlAll = " SELECT COUNT(*) FROM tbl_learn INNER JOIN tbl_users ";
//                        $sqlAll .= " WHERE lesson_id = '".$lessonItem->id."' AND tbl_users.status = '1' ";
//                        if($model->typeOfUser !='' ) {
//                            $sqlAll .= " AND authitem_name = '" . $model->typeOfUser . "' ";
//                        }
                        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i-1);
                        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $lessonItem->title);
                        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $courseAllCount[$key] += $allCount);
                        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $coursePassCount[$key] += $passCount);
                        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $allCount-$passCount);
                        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $passCount/(($allCount==0)?1:$allCount)*100);
                        $i++;

                    }


                    $courseAllCountTotal += $courseAllCount[$key];
                    $coursePassCountTotal += $coursePassCount[$key];

                }
//        $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $i);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, "รวม");
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $courseAllCountTotal);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $coursePassCountTotal);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $courseAllCountTotal-$coursePassCountTotal);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, number_format($coursePassCountTotal/(($courseAllCountTotal==0)?1:$courseAllCountTotal)*100,2));

//        $gdImage = imagecreatefrompng(Yii::app()->basePath.'/../uploads/index.png');

//        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Chart %การจบ');
        $objDrawing->setDescription('Chart %การจบ');
        $objDrawing->setPath(Yii::app()->basePath.'/../uploads/index.png');
//        $objDrawing->setHeight(350);
        $objDrawing->setCoordinates('H1');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


        $objPHPExcel->getActiveSheet()->setTitle('ภาพรวมผลการเรียน');

        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        $strFileName = "ภาพรวมผลการเรียน-".date('YmdHis').".xlsx";
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');

// It will be called file.xls
        header('Content-Disposition: attachment; filename="'.$strFileName.'"');

        $objWriter->save("php://output");

    }

    public function actionExportTrack()
    {
        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
        $objPHPExcel = new PHPExcel();
        $columnChar = range("C","Z");

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'ลำดับ');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'ชื่อ - นามสกุล');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);

        $model=new Report();
        $model->unsetAttributes();
        if(isset($_GET['Report']))
            $model->attributes=$_GET['Report'];

$cate_type = array('university'=>1,'company'=>2);
if($model->typeOfUser != '') {
    $cate_id = '';
    if($model->typeOfUser == 'university'){
        if($model->categoryUniversity != ''){
            $cate_id = $model->categoryUniversity;
        }
    }
    if($model->typeOfUser == 'company'){
        if($model->categoryCompany != ''){
            $cate_id = $model->categoryCompany;
        }
    }

    if($cate_id == '') {
        $course = CourseOnline::model()->with('cates')->findAll(array(
            'condition' => 'courseonline.active = "y" AND cate_type="' . $cate_type[$model->typeOfUser] . '"',
            'order' => 'sortOrder'
        ));
    }else{
        $course = CourseOnline::model()->with('cates')->findAll(array(
            'condition' => 'courseonline.active = "y" AND cate_type="' . $cate_type[$model->typeOfUser] . '" AND categorys.cate_id ="'.$cate_id.'"',
            'order' => 'sortOrder'
        ));
    }
}else{
    $course = CourseOnline::model()->findAll(array(
        'condition' => 'active = "y"',
        'order' => 'sortOrder'
    ));
}
$courseAllCountTotal = 0;
$coursePassCountTotal = 0;
$courseAllCount = array();
$coursePassCount = array();

foreach ($course as $key => $courseItem) {
    $courseTitle[$key] = $courseItem->course_title;
    $courseAllCount[$key] = 0;
    $coursePassCount[$key] = 0;

    if(isset($owner_id)) {
        $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y" AND create_by ="'.$owner_id.'"', 'order' => 'title'));
    }else{
        $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y"', 'order' => 'title'));
    }
    foreach ($lesson as $lessonKey => $lessonItem) {/** @var Lesson $lessonItem */
        $sqlAll = " SELECT COUNT(*) FROM tbl_learn INNER JOIN tbl_users ON tbl_learn.user_id = tbl_users.id ";
        if($model->typeOfUser == 'university') {
            $sqlAll .= " INNER JOIN university ON tbl_users.student_house = university.id ";
        }
        $sqlAll .= " WHERE lesson_id = '".$lessonItem->id."' AND tbl_users.status = '1' ";
        if($model->typeOfUser == 'university' ) {
            if($model->university != '') {
                $sqlAll .= " AND university.id = '".$model->university."' ";
            }
        }
        if($model->typeOfUser !='' ) {
            $sqlAll .= " AND authitem_name = '" . $model->typeOfUser . "' ";
        }
        if($model->dateRang !='' ) {
            list($start,$end) = explode(" - ",$model->dateRang);
            $start = date("Y-d-m",strtotime($start))." 00:00:00";
            $end = date("Y-d-m",strtotime($end))." 23:59:59";
            $sqlAll .= " AND learn_date BETWEEN '" . $start . "' AND '".$end."'";
        }

        $allCount = Yii::app()->db->createCommand($sqlAll)->queryScalar();

        $sqlPass = " SELECT COUNT(*) FROM tbl_learn learnmain
 INNER JOIN tbl_users
 ON learnmain.user_id = tbl_users.id";
        if($model->typeOfUser == 'university' ) {
            $sqlPass .= " INNER JOIN university ON tbl_users.student_house = university.id ";
        }
        $sqlPass .="
 WHERE lesson_id = '".$lessonItem->id."'
 AND (SELECT COUNT(*) FROM tbl_file WHERE lesson_id = learnmain.lesson_id) = (SELECT COUNT(*) FROM tbl_learn_file WHERE learn_id = learnmain.learn_id AND learn_file_status = 's')";
        /*$sqlPass .="
        WHERE lesson_id = '".$lessonItem->id."'
        AND (SELECT COUNT(*) FROM tbl_file WHERE lesson_id = learnmain.lesson_id) = (SELECT COUNT(*) FROM tbl_learn_file WHERE learn_id = learnmain.learn_id AND learn_file_status = 's')
        AND ((SELECT COUNT(*) FROM tbl_score WHERE lesson_id = learnmain.lesson_id AND user_id = learnmain.user_id AND tbl_score.type='post' AND score_past='y') > 0 OR (SELECT COUNT(*) FROM tbl_manage WHERE id = learnmain.lesson_id AND type='post') = 0)";*/

        if($model->typeOfUser == 'university' ) {
            if($model->university != '') {
                $sqlPass .= " AND university.id = '" . $model->university . "' ";
            }
        }

        if($model->typeOfUser !='' ) {
            $sqlPass .= " AND authitem_name = '" . $model->typeOfUser . "' ";
        }

        if($model->dateRang !='' ) {
            list($start,$end) = explode(" - ",$model->dateRang);
            $start = date("Y-d-m",strtotime($start))." 00:00:00";
            $end = date("Y-d-m",strtotime($end))." 23:59:59";
            $sqlPass .= " AND learn_date BETWEEN '" . $start . "' AND '".$end."'";
        }

        $passCount = Yii::app()->db->createCommand($sqlPass)->queryScalar();

        $courseAllCount[$key] += $allCount;
        $coursePassCount[$key] += $passCount;

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnChar[$key].'1', $lessonItem->title);
    }


}

$style = array(
    'font' => array('bold' => true, 'size' => 10,),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
for($i=0;$i<=$key;$i++) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnChar[$i])->setWidth(20);
}
$objPHPExcel->getActiveSheet()->getStyle("A1:".$columnChar[$key]."1")->applyFromArray($style);

$learnUser = Learn::model()->findAll(array(
    'select'=>'distinct user_id'
));

$learnUserArray = array();
foreach($learnUser as $user){
    $learnUserArray[] = $user->user_id;
}
$sqlUser = " SELECT *,tbl_users.id AS user_id FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id ";

if($model->typeOfUser == 'university') {
    $sqlUser .= " INNER JOIN university ON tbl_users.student_house = university.id ";
}

$sqlUser .= " WHERE status='1' ";

if(count($learnUserArray) == 0){
    $learnUserArray = array(0);
}

$sqlUser .= " AND user_id IN (".implode(",",$learnUserArray).") ";
//                $sqlUser .= " WHERE status='1' ";

if($model->typeOfUser == 'university' ) {
    if($model->university != '') {
        $sqlUser .= " AND university.id = '".$model->university."' ";
    }
}

if($model->typeOfUser !='' ) {
    $sqlUser .= ' AND authitem_name = "'.$model->typeOfUser.'" ';
}

$user = Yii::app()->db->createCommand($sqlUser)->queryAll();
$orderNumber = 1;
$statusArray = array(
    'pass'=>'ผ่าน',
    'learning'=>'กำลังเรียน',
    'notLearn'=>'ไม่ได้เข้าเรียน',
);
        foreach ($user as $userKey => $userItem) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($userKey+2),$orderNumber++);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.($userKey+2),$userItem['firstname']." ".$userItem['lastname']);
            $cate_type = array('university'=>1,'company'=>2);
            if($model->typeOfUser != '') {
                $cate_id = '';
                if($model->typeOfUser == 'university'){
                    if($model->categoryUniversity != ''){
                        $cate_id = $model->categoryUniversity;
                    }
                }
                if($model->typeOfUser == 'company'){
                    if($model->categoryCompany != ''){
                        $cate_id = $model->categoryCompany;
                    }
                }

                if($cate_id == '') {
                    $course = CourseOnline::model()->with('cates')->findAll(array(
                        'condition' => 'courseonline.active = "y" AND cate_type="' . $cate_type[$model->typeOfUser] . '"',
                        'order' => 'sortOrder'
                    ));
                }else{
                    $course = CourseOnline::model()->with('cates')->findAll(array(
                        'condition' => 'courseonline.active = "y" AND cate_type="' . $cate_type[$model->typeOfUser] . '" AND categorys.cate_id ="'.$cate_id.'"',
                        'order' => 'sortOrder'
                    ));
                }
            }else{
                $course = CourseOnline::model()->findAll(array(
                    'condition' => 'active = "y"',
                    'order' => 'sortOrder'
                ));
            }

            foreach ($course as $key => $courseItem) {
                if(isset($owner_id)) {
                    $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y" AND create_by ="'.$owner_id.'"', 'order' => 'title'));
                }else{
                    $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y"', 'order' => 'title'));
                }

                foreach ($lesson as $lessonKey => $lessonItem) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnChar[$key].($userKey+2), $statusArray[Helpers::lib()->checkLessonPassById($lessonItem,$userItem['user_id'],$model->dateRang)]);
                }

            }

        }

        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Chart เปรียบเทียบจำนวนผู้ที่เรียนผ่านกับเรียนไม่ผ่าน');
        $objDrawing->setDescription('Chart เปรียบเทียบจำนวนผู้ที่เรียนผ่านกับเรียนไม่ผ่าน');
        $objDrawing->setPath(Yii::app()->basePath.'/../uploads/track.png');
//        $objDrawing->setHeight(350);
        $objDrawing->setCoordinates('A'.($userKey+4));
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        $objPHPExcel->getActiveSheet()->setTitle('รายงานติดตามผลการเรียน');

        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        $strFileName = "รายงานติดตามผลการเรียน-".date('YmdHis').".xlsx";
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');

        // It will be called file.xls
        header('Content-Disposition: attachment; filename="'.$strFileName.'"');

        $objWriter->save("php://output");

    }

}