<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>
<style>
    th {
        background-color: #E25F39;
        color: white;
    }
</style>
<?php
$titleName = 'รายงานการเรียนรายวิชา';
$formNameModel = 'Report';

$this->breadcrumbs=array($titleName);

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    return true;
	});
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$('.collapse-toggle').click();
	$('#Report_dateRang').attr('readonly','readonly');
	$('#Report_dateRang').css('cursor','pointer');
	$('#Report_dateRang').daterangepicker();

EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">

    <?php
    /**  */
    $this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
            array('name'=>'nameSearch','type'=>'text'),
//            array('name'=>'course','type'=>'list','query'=>$model->courseList),
            array('name'=>'dateRang','type'=>'text'),

            //array('name'=>'course_point','type'=>'text'),
        ),
    ));?>
    <?php
    if($model->nameSearch != '') {
        $sqlUser = " SELECT * FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id WHERE status='1' AND ";
        $search = explode(" ",$model->nameSearch);

        $searchCount = count($search);

        $sqlUser .= "(";
        foreach ($search as $key => $searchText) {
            $sqlUser .= "(username LIKE '%" . trim($searchText) . "%' OR firstname LIKE '%" . trim($searchText) . "%' OR lastname LIKE '%" . trim($searchText) . "%')";
            if($searchCount != $key+1){
                $sqlUser .= " OR ";
            }
        }

        $sqlUser .= ")";
   
        $user = Yii::app()->db->createCommand($sqlUser)->queryAll();

       
        if (!empty($user)) {

            if(Yii::app()->user->isSuperuser == false) {
                $userObj = Yii::app()->getModule('user')->user();
                $model->typeOfUser = $userObj->authitem_name;
                $cate_type = array('university'=>1,'company'=>2);
                $owner_id = $userObj->id;
            }
//            if ($model->course != '') {
//                $course = CourseOnline::model()->findAll(array('condition' => 'active = "y" AND course_id ="' . $model->course . '"'));
//            } else {
                $course = CourseOnline::model()->findAll(array('condition' => 'active = "y"','order'=>'sortOrder'));
//            }
            ?>
            <div  id="dvData">
            <?php  
            foreach ($course as $key => $courseItem) {
                if(isset($owner_id)) {
                    $lesson = Lesson::model()->findAll(array(
                        'condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y" AND create_by ="'.$owner_id.'"',
                        'order' => 'title'
                    ));
                }else{
                    $lesson = Lesson::model()->findAll(array(
                        'condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y"',
                        'order' => 'title'
                    ));
                }
                if(count($lesson) > 0) {
                    ?>
                    <div class="widget" style="margin-top: -1px;">
                        <!-- Head -->
                        <div class="widget-head">
                            <h4 class="heading glyphicons show_thumbnails_with_lines">
                                <i></i> <?php echo $courseItem->course_title . " | " . $user[0]['firstname'] . " " . $user[0]['lastname']; ?>
                            </h4>
                        </div>
                        <div class="widget-body">
                            <!-- Table -->
                            <table class="table table-bordered table-striped">

                                <!-- Table heading -->
                                <thead>
                                <tr>
                                    <!--                                <th class="center" style="width: 80px;">ลำดับ</th>-->
                                    <th style="min-width: 120px;" class="center">หัวข้อ</th>
                                    <th class="center" style="width: 100px;">สถานะการเรียน</th>
                                    <th class="center" style="width: 200px;">สถานะการทำแบบทดสอบ</th>
                                </tr>
                                </thead>
                                <!--  Table heading END -->

                                <!-- Table body -->
                                <tbody>
                                <?php


                                $orderNumber = 1;
                                $statusArray = array(
                                    'pass' => '<div style="color: green;"><strong>ผ่าน</strong></div>',
                                    'learning' => '<div style="color: #0000ff;"><strong>กำลังเรียน</strong></div>',
                                    'notLearn' => '<div style="color: red;"><strong>ไม่ได้เข้าเรียน</strong></div>',
                                );
                                foreach ($lesson as $lessonItem) {
                                    /** @var Lesson $lessonItem */
                                    ?>
                                    <!-- Table row -->
                                    <tr>
                                        <!--<td class="center"><?php// echo $orderNumber++; ?></td>-->
                                        <td class="center"><?php echo $lessonItem->title; ?></td>
                                        <td class="center">
                                        <?php
                                            $user_id=$user[0]['id'];
                                            $learnStatus=1;

                                            $file=File::model()->findAll('lesson_id='.$lessonItem->id.' AND active="y"');
                                                $check_one_file=1;
                                                $check_all_file=0;
                                                foreach ($file as $fl) {
                                                    $learnf=LearnFile::model()->find('file_id='.$fl->id.' AND user_id_file='.$user[0]['id']);
                                                    if(!$learnf){
                                                        $check_one_file=0;
                                                    }else{
                                                        $check_all_file=1;
                                                    }
                                                }
                                                if($check_all_file==0){
                                                     $learnStatus="notLearn";
                                                }else if($check_one_file==0){
                                                     $learnStatus="learning";
                                                }else{
                                                   $learnStatus="pass";
                                                }

                                                $learnStatus = Helpers::lib()->checkLessonPassById($lessonItem, $user[0]['id'], $model->dateRang);
                                            
                                               
                                                //เรียนเสร็จแล้ว
                                

                                                // $learnStatus="learning";
                                           


                                            echo $learnStatus;
                                            // echo $statusArray[$learnStatus];
                                        ?>
                                        </td>
                                         <td class="center">
                                            <?php 
                                                echo Helpers::lib()->CheckTestCount($learnStatus, $lessonItem, true);
                                             

                                            ?>
                                        </td>
                                    </tr>
                                    <!-- // Table row END -->
                                <?php } ?>
                                </tbody>
                                <!-- // Table body END -->

                            </table>
                            <!-- // Table END -->

                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            </div>
            <?php
            // end show uer
        }else{
            // กรณีไม่มี User
            
            ?>
            <div class="widget" style="margin-top: -1px;">
                <div class="widget-head">
                    <h4 class="heading glyphicons show_thumbnails_with_lines">
                        <i></i> </h4>
                </div>
                <div class="widget-body">
                    <!-- Table -->
                    <h3 style="color: red;">ไม่พบข้อมูล</h3>
                    <!-- // Table END -->
                </div>
            </div>
    <?php
        }
    // End Search
    }else{

        ?>
        <div class="widget" style="margin-top: -1px;">
            <div class="widget-head">
                <h4 class="heading glyphicons show_thumbnails_with_lines">
                    <i></i> </h4>
            </div>
            <div class="widget-body">
                <!-- Table -->
                <h3 class="text-success">กรุณาใส่ ชื่อ - นามสกุล แล้วกด ปุ่มค้นหา</h3>
                <!-- // Table END -->
            </div>
        </div>
    <?php
    }
    ?>
</div>

<div class="text-center">
            <input type="button" id="btnExport" value=" Export Excel" class="btn btn-primary" />
        </div><br>
<script>
    $("#btnExport").click(function(e) {
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('#dvData').html()));
        e.preventDefault();
    });
</script>