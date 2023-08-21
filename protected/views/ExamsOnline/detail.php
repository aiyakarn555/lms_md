<style>
    html {
        scroll-behavior: smooth;
    }

    /*header .navbar {
        position: inherit !important;
    }*/

    .header-page {
        margin: 0px 00px 20px !important;
    }

    .text-success {
        color: #3c763d;
    }

    .text-danger {
        color: rgb(232, 42, 37);
    }

    .loadding-time {
        position: relative;
        z-index: 0;
        transform: translate(0px, 0px);
    }

    .pre-loading {
        position: relative;
        width: 100%;
        height: 0;
        display: block;
        top: -15px;
    }

    #loader {
        position: absolute;
        left: 50%;
        top: 50%;
        z-index: 1;
        width: 30px;
        height: 30px;
        margin: 0 -18px 0px;
        border: 2px solid #f3f3f3;
        border-radius: 50%;
        border-top: 2px solid #3498db;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
        /* transform: translate(-26%, -23%); */
    }

</style>

<?php
$course_wait_cer = 1; // สถานะ 1=พิมใบ cer ได้    2=มีข้อสอบบรรยายรอตรวจ พิมไม่ได้
$themeBaseUrl = Yii::app()->theme->baseUrl;
$uploadFolder = Yii::app()->getUploadUrl("lesson");
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
    $statusEdu = "Study status";
    $lastStatus = "Recent study status";
    $failStudy = "Still not passing the condition";
    $successStudy = "You have passed the conditions";
    $Period = "Period";
    $day = "day";
    $Questionnaire = "Questionnaire ";
    $Click = "Assessment";
    $final = "Final";
    $clickFinal = "Final test";
    $click_precourse = "Pre test";
    $pre_course = "Pre Test Course";
    $pre_course_wait = "Wait for inspection...";
    $CourseInstructor = 'Course Instructor';
    $CourseApprover = 'Course Approver';
    $Time = 'Time';
    $Lessons = 'Lessons';
    $CourseEvaluation = 'Course Evaluation';
    $Hr = 'Hr';
    $Print = 'Print';
    $CourseCert = 'Certificate';
    $Join = 'Join';
    $txtShow["ExamRoom"] = 'Exam Room';

} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
    $statusEdu = "สถานะการเรียน";
    $lastStatus = "ไปยังสถานะเรียนล่าสุด";
    $failStudy = "ท่านยังเรียนไม่ผ่านตามเงื่อนไข";
    $successStudy = "ท่านเรียนผ่านตามเงื่อนไข";
    $Period = "ระยะเวลา";
    $day = "วัน";
    $Questionnaire = "แบบสอบถาม ";
    $Click = "แบบประเมิน";
    $final = "การสอบวัดผล";
    $pre_course = "การสอบก่อนเรียนหลักสูตร";
    $click_precourse = "เข้าสู่การสอบ";
    $clickFinal = "เข้าสู่การสอบ";
    $pre_course_wait = "รอตรวจสอบ...";
    $CourseInstructor = 'ผู้สร้างหลักสูตร';
    $CourseApprover = 'ผู้อนุมัติหลักสูตร';
    $Time = 'เวลา';
    $Lessons = 'บทเรียน';
    $CourseEvaluation = 'การประเมินผลหลักสูตร';
    $CourseCert = 'ใบประกาศนียบัตร';
    $Hr = 'ชั่วโมง';
    $Print = "พิมพ์";
    $Join = 'เข้าร่วม';
    $txtShow["ExamRoom"] = 'ห้องสอบออนไลน์';

}

$gen_id = 0;

function Cuttime($date)
{
    $strYear = date("Y", strtotime($date)) + 543;
    $strMonth = date("n", strtotime($date));
    $strDay = date("j", strtotime($date));
    $strHour = date("H", strtotime($date));
    $strMinute = date("i", strtotime($date));
    $strSeconds = date("s", strtotime($date));
    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay / $strMonthThai / $strYear";
}
?>

<?php if (!empty($_GET['msg'])) { ?>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        swal({
            title: "แจ้งเตือน",
            text: "<?= $_GET['msg'] ?>",
            icon: "warning",
            dangerMode: true,
        });
        $(document).ready(function() {
            window.history.replaceState({}, 'msg', '<?= $this->createUrl('site/index') ?>');
        });
    </script>
<?php } ?>
<link href="<?php echo $themeBaseUrl; ?>/plugins/video-js/video-js.css" rel="stylesheet" type="text/css">
<script src="<?php echo $themeBaseUrl; ?>/plugins/video-js/video.js"></script>

<div class="">
    <div class="container-main">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/course/index'); ?>"><?php echo $label->label_course; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $course->name_ms_teams ?> </li>
        </ol>
    </nav>
       
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="course-active" id="sticker">
                    <div class="alert alert-warning mt-20" role="alert">
                        <?php 
                            $criteria = new CDbCriteria;
                            $criteria->compare('gen_id',$gen_id);
                            $courseGeneration = CourseGeneration::model()->find($criteria);
                            $periodCourse = "";
                            $periodDate ="";
                            if(isset($courseGeneration)){
                                $periodCourse = (!empty($courseGeneration)) ? "(".Helpers::lib()->covert24HourTo12Hour($courseGeneration->gen_period_start, $langId) . Helpers::lib()->CuttimeLang($courseGeneration->gen_period_start, $langId) . " - " .Helpers::lib()->covert24HourTo12Hour($courseGeneration->gen_period_end, $langId) . Helpers::lib()->CuttimeLang($courseGeneration->gen_period_end, $langId) . ")" : "";
                                $periodDate = Helpers::lib()->datePeriod($courseGeneration->gen_period_start,$courseGeneration->gen_period_end);
                            }else{
                                $periodCourse = (!empty($course)) ? "(".Helpers::lib()->covert24HourTo12Hour($course->start_date, $langId) . Helpers::lib()->CuttimeLang($course->start_date, $langId) . " - " .Helpers::lib()->covert24HourTo12Hour($course->end_date, $langId) . Helpers::lib()->CuttimeLang($course->end_date, $langId) . ")" : "";
                                $periodDate = Helpers::lib()->datePeriod($course->start_date,$course->end_date);
                            }
                        ?>
                        <?= $Period ?> <?= $periodDate ?> <?= $day ?> <?= $periodCourse ?>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <?php if ($course->ms_teams_picture != null) { ?>
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/msonline/<?= $course->id ?>/thumb/<?= $course->ms_teams_picture ?>" class="w-100 ">
                                <?php } else { ?>
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/thumbnail-course.png" class="w-100 ">
                                <?php } ?>
                            </div>
                           
                            <div class="text-left">
                                <h3><?= $course->name_ms_teams ?> </h3>
                            </div>

                            <div class="course-progress">
                             

                                <div class="text-center"> <a href="#tab-content" onclick="$('#change_tab2').click();" class="btn btn-success"><?= $lastStatus ?></a></div>
                                <div class="course-admin">
                                    <h4><?= $CourseInstructor ?> : <span><?php $profile = Profile::model()->findByPk($course->create_by); 
                                    if($langId==1){
                                        $pro_name = $profile->firstname_en;
                                        $title_name = $profile->ProfilesTitleEn->prof_title_en;
                                    }else{
                                        $pro_name = $profile->firstname;
                                        $title_name = $profile->ProfilesTitleTH->prof_title;
                                    }
                                       echo  $title_name.' '.$pro_name; ?></span></h4>
                                    
                                </div>
                            </div>

                        </div>

                    </div>
                   

                    <div class="card course-detail-2">
                        <div class="card-body ">
                            <div class="row">
                              
                                <div class="col-md-12 col-xs-12">
                                    <div class="c-item">
                                        <small><?= $Lessons ?></small>
                                        <div class="text-center mt-20">
                                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/book-icon.png">
                                            <small class="text-center detail-value"><?= count($lessonList).' '.$Lessons ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                </div>
            </div>


            <div class="col-sm-8 col-md-8 col-xs-12">

                <div class="topic-course">
                    <div class="alert alert-primary mt-20" style="background-color: #c5ebef !important;border: 1px solid var(--color-primary) !important; " role="alert">
                        <div class="row">
                            <div class="col-md-10 col-sm-12 col-xs-12 center-flex">
                               <?= $txtShow["ExamRoom"] ?> : <?= $course->name_ms_teams ?>
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12 mt-xs-2">
                                    <?php
                                        if(isset($course->url_join_meeting)){
                                            $urlZoom = $course->url_join_meeting ;
                                            $alert = "join";
                                        }else{
                                            $urlZoom = "javascript:void(0);";
                                            $alert = "noRoom";
                                        }
                                    ?>
                                    <a href="<?= $urlZoom ?>" class="btn btn-warning pull-right" onclick="joinZoomMeeting('<?= $alert ?>');"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><?= $Join ?></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="course-detail">
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#course-info" aria-controls="course-info" role="tab" id="change_tab1" data-toggle="tab"><?php echo $label->label_detail; ?></a>
                            </li>
                            <li role="presentation">
                                <a href="#course-unit" aria-controls="course-unit" role="tab" id="change_tab2" data-toggle="tab"><?php echo $label->label_Content; ?></a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content" id="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="course-info">
                                <li class="list-group-item">

                                    <?php echo htmlspecialchars_decode($course->detail_ms_teams); ?>

                                    <div class="text-left"> <a href="#tab-content" onclick="$('#change_tab2').click();" class="btn btn-warning">Next</a></div>

                                </li>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="course-unit">
                                <ol class="course-ol">
                                    <div class="panel panel-default">

                                        <?php
                                        foreach ($lessonList as $key => $lessonListValue) {
                                            if (!$flag) {

                                                $lessonListChildren  = LessonOnline::model()->find(array('condition' => 'parent_id = ' . $lessonListValue->id, 'order' => 'lesson_no'));
                                                if ($lessonListChildren) {
                                                    $lessonListValue->title = $lessonListChildren->title;
                                                    $lessonListValue->description = $lessonListChildren->description;
                                                    $lessonListValue->content = $lessonListChildren->content;
                                                    $lessonListValue->image = $lessonListChildren->image;
                                                }
                                            }

                                            // var_dump($lessonListValue);
                                            $idx = 1;
                                            $checkPreTest = Helpers::checkHavePreTestInManageOnline($lessonListValue->id);

                                            $checkPostTest = Helpers::checkHavePostTestInManageOnline($lessonListValue->id);

                                            $checkLessonPass = Helpers::lib()->checkLessonPass_Percent_Online($lessonListValue);

                                            $postStatus = Helpers::lib()->CheckTestOnline($lessonListValue, "post");
                                            
                                            $step = 0;

                                             if ($checkLessonPass->status == "notLearn") {
                                                $colorTab = 'listlearn-danger';
                                                $lessonStatusStr = $label->label_notLearn;
                                            } else if ($checkLessonPass->status == "learning") {
                                                $colorTab = 'listlearn-warning';
                                                $lessonStatusStr = $label->label_learning;
                                            } else if ($checkLessonPass->status == "pass") {
                                                $colorTab = 'listlearn-success';
                                                // $lessonStatusStr = $label->label_lessonPass;
                                                $lessonStatusStr =  $label->label_learnPass;
                                            }

                                            
                                            ?>

                                            <div class="panel-heading headcourse <?php ?>" role="tab" id="lessonId<?= $lessonListValue->id; ?>">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?= $lessonListValue->id ?>" aria-expanded="true" aria-controls="collapseOne">
                                                    <li id="collapseles<?= $lessonListValue->id ?>">
                                                        <span class="title__course">
                                                            <?= $lessonListValue->title ?>
                                                        </span>
                                                        <label style="color: <?= $checkLessonPass->color ?>" class="<?= $checkLessonPass->class ?>"><?= $lessonStatusStr ?></label>
                                                        <span class="pull-right"><i class="fa fa-angle-down"></i></span>

                                                    </li>
                                                </a>
                                            </div>

                                            <div class="panel-collapse collapse <?= ($lessonListValue->id == $stopId && $can_next_step != 2) ? 'in' : '' ?>" id="collapse-<?= $lessonListValue->id ?>" role="tabpanel" aria-labelledby="headingOne">
                                                <?php if ($checkPreTest) { ?>
                                                    <div class="stepcoursediv">
                                                        <div> <span class="stepcourse"><?php echo $label->label_step; ?> <?= $idx++; ?> </span><?php echo $label->label_testPre; ?></div>
                                                    </div>
                                                    <ul class="list-group">
                                                        <?php

                                                        $isPreTest = Helpers::isPretestStateOnline($lessonListValue->id);

                                                        // alertswalExams
                                                        if($lessonListValue->status_exams_pre == 1){

                                                           if ($can_next_step  != 2) {
                                                            $ckLinkTest = $this->createUrl('/questiononline/preexams', array('id' => $lessonListValue->id, 'type' => 'pre'));
                                                            $ckLinkTest_onClick = '';
                                                            } else {
                                                                $ckLinkTest = 'javascript:void(0);';
                                                                $ckLinkTest_onClick = 'onclick="alertSequence();"';
                                                            }

                                                            }else{
                                                                $ckLinkTest = 'javascript:void(0);';
                                                                    $ckLinkTest_onClick = 'onclick="alertswalExams();"';
                                                            }
                                                       

                                                        if ($isPreTest) { // สอบ pre 1 ครั้ง แล้ว ไม่เข้า
                                                            $prelearn = false;
                                                        ?>
                                                            <li class="list-group-item">
                                                                <?php if ($step == 1) { ?>
                                                                    <!-- <div class="pt-now"> You are here</div> -->
                                                                <?php } ?>
                                                                <?php echo $label->label_testPre; ?> <span class="pull-right">
                                                                   
                                                                    <a href="<?= $ckLinkTest; ?>" <?= $ckLinkTest_onClick; ?> class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true">
                                                                        </i> <?php echo $label->label_DoTest; ?></a>
                                                                </span>
                                                            </li>
                                                            <?php
                                                        } else { //Pre Test // สอบ pre 1 ครั้ง แล้ว เข้านี่
                                                            $prelearn = true;
                                                            // $flagPreTestPass = false;
                                                            $flagPreTestPass = true;
                                                            $criteriaScoreAll = new CDbCriteria;
                                                            $criteriaScoreAll->condition = ' type = "pre" AND lesson_teams_id="' . $lessonListValue->id . '" AND user_id="' . Yii::app()->user->id . '" and active = "y"' . " AND gen_id='" . $gen_id . "'";
                                                            $scoreAll = ScoreOnline::model()->findAll($criteriaScoreAll);
                                                            foreach ($scoreAll as $keyx => $score_ck) {

                                                                if ($score_ck->score_past == 'y') {
                                                                    $flagPreTestPass = true;
                                                                    $colorText = 'text-success';
                                                                } else {
                                                                    $colorText = 'text-danger';
                                                                }
                                                                $preStatus = Helpers::lib()->CheckTestAllOnline($lessonListValue, "pre", $score_ck);


                                                                $CheckPreTestAnsTextAreaLesson = Helpers::lib()->CheckPreTestAnsTextAreaLessonOnline($lessonListValue, "pre");

                                                                if ($CheckPreTestAnsTextAreaLesson) {

                                                            ?>
                                                                    <li class="list-group-item">
                                                                        <?php echo $label->label_resultTestPre; ?> <?= $keyx + 1; ?><span class="pull-right <?= $colorText; ?> prepost"> <?= $preStatus->value['score']; ?>/<?= $preStatus->value['total']; ?> <?php echo $label->label_point; ?></span> </li>
                                                                <?php
                                                                } else {
                                                                    //ข้อสอบ ก่อนเรียน ของบทเรียน
                                                                    $course_wait_cer = 2;
                                                                ?>
                                                                    <li class="list-group-item">
                                                                        <?php echo $label->label_resultTestPre; ?> <?= $keyx + 1; ?><span class="pull-right <?= $colorText; ?> prepost"> <?= $label->label_course_wait ?> </span> </li>
                                                        <?php
                                                                }
                                                            } //end foreach
                                                        }
                                                        ?>
                                                        <?php
                                                        $pre_test_again = 2; // ไม่ให้โชว์ สอบ pre อีก

                                                        if ($pre_test_again == 1 && count($scoreAll) < 1 && !$flagPreTestPass && count($scoreAll) != 0 && $can_next_step  != 2) {
                                                        ?>
                                                            <li class="list-group-item">
                                                                <?php if ($step == 1) { ?>
                                                                    <!-- <div class="pt-now"> You are here</div> -->
                                                                <?php } ?>

                                                                <?php 
                                                                if($lessonListValue->status_exams_pre == 1){ ?>
                                                                    ?>
                                                                    <?php echo $label->label_testPre; ?> <?= count($scoreAll) + 1; ?> <span class="pull-right"><a href="<?php echo $this->createUrl('/questiononline/preexams', array('id' => $lessonListValue->id, 'type' => 'pre')); ?>" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $label->label_DoTest; ?></a></span>

                                                                <?php }else{ ?> 

                                                                    <?php echo $label->label_testPre; ?> <?= count($scoreAll) + 1; ?> <span class="pull-right"><a href="javascript:void(0);" onclick="alertswalExams();" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $label->label_DoTest; ?></a></span>

                                                               <?php } ?>  


                                                            </li>
                                                        <?php } ?>
                                                    <?php
                                                } else {
                                                    $prelearn = true;
                                                }
                                                    
                                                    if ($checkPostTest) {
                                                        $isPostTest = Helpers::isPosttestStateOnline($lessonListValue->id);

                                                        if ($isPostTest) {
                                                            if($lessonListValue->status_exams_post == 1){

                                                                if ($prelearn) {
                                                                 $link = $this->createUrl('questiononline/preexams', array('id' => $lessonListValue->id));
                                                                 $alert = '';
                                                                } else {
                                                                   $link = 'javascript:void(0);';
                                                                   $alert = 'alertswal();';
                                                                } 
                                                            }else{
                                                                $link = 'javascript:void(0);';
                                                                $alert = 'alertswalExams();';
                                                            }

                                                    ?>
                                                            <div class="stepcoursediv">
                                                                <div>
                                                                    <span class="stepcourse"><?php echo $label->label_step; ?> <?= $idx++; ?>
                                                                    </span><?php echo $label->label_testPost; ?>
                                                                </div>
                                                            </div>
                                                            <li class="list-group-item">
                                                                <?php if ($step == 3) { ?>
                                                                    <!-- <div class="pt-now"> You are here</div> -->
                                                                <?php } ?>
                                                                <?php echo $label->label_testPost; ?> <span class="pull-right"><a href="<?= $link ?>" <?= $alert != '' ? 'onclick="' . $alert . '"' : ''; ?> class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $label->label_DoTest; ?></a></span>
                                                            </li>
                                                        <?php
                                                        } else { //Post Test
                                                            $flagPostTestPass = false;
                                                            $criteriaScoreAll = new CDbCriteria;
                                                            $criteriaScoreAll->condition = ' type = "post" AND lesson_teams_id="' . $lessonListValue->id . '" AND user_id="' . Yii::app()->user->id . '" and active = "y"' . " AND gen_id='" . $gen_id . "'";
                                                            $scoreAll = ScoreOnline::model()->findAll($criteriaScoreAll);
                                                        ?>
                                                            <div class="stepcoursediv">
                                                                <div> <span class="stepcourse"><?php echo $label->label_step; ?> <?= $idx++; ?> </span><?php echo $label->label_testPost; ?></div>
                                                            </div>
                                                            <?php
                                                            foreach ($scoreAll as $keys => $scorePost) {
                                                                if ($scorePost->score_past == 'y') {
                                                                    $flagPostTestPass = true;
                                                                    $colorText = 'text-success';
                                                                } else {
                                                                    $colorText = 'text-danger';
                                                                }
                                                                $postStatus = Helpers::lib()->CheckTestAllOnline($lessonListValue, "post", $scorePost);

                                                                $CheckPreTestAnsTextAreaLessonPost = Helpers::lib()->CheckPreTestAnsTextAreaLessonOnline($lessonListValue, "post");

                                                                if ($CheckPreTestAnsTextAreaLessonPost) {
                                                            ?>

                                                                    <li class="list-group-item"><?php echo $label->label_resultTestPost; ?> <?= $keys + 1 ?><span class="pull-right <?= $colorText ?> prepost"><?= $postStatus->value['score']; ?>/<?= $postStatus->value['total']; ?> <?php echo $label->label_point; ?></span></li>
                                                                <?php
                                                                } else {
                                                                    $course_wait_cer = 2;
                                                                ?>

                                                                    <li class="list-group-item"><?php echo $label->label_resultTestPost; ?> <?= $keys + 1 ?><span class="pull-right <?= $colorText ?> prepost"><?= $label->label_course_wait ?></span></li>
                                                            <?php
                                                                }
                                                            } //end foreach
                                                            ?>
                                                            <?php if (count($scoreAll) < $lessonListValue->cate_amount && !$flagPostTestPass && count($scoreAll) != 0 && $can_next_step != 2 && $CheckPreTestAnsTextAreaLessonPost == true) {

                                                                if($lessonListValue->status_exams_post == 1){

                                                                   $link = $this->createUrl('questiononline/preexams', array('id' => $lessonListValue->id));
                                                                   $alert = '';
                                                                }else{
                                                                    $link = 'javascript:void(0);';
                                                                    $alert = 'alertswalExams();';
                                                                }

                                                                $alert = '';
                                                            ?>
                                                                <li class="list-group-item">
                                                                    <?php if ($step == 3) { ?>
                                                                        <!-- <div class="pt-now"> You are here</div> -->
                                                                    <?php } ?>
                                                                    <?php echo $label->label_testPost; ?> <?= count($scoreAll) + 1; ?> <span class="pull-right"><a href="<?= $link ?>" <?= $alert != '' ? 'onclick="' . $alert . '"' : ''; ?> class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $label->label_DoTest; ?></a></span>
                                                                </li>
                                                            <?php } ?>

                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                    <?php } ?>
                                                    </ul>
                                            </div>
                                        <?php } ?>

                                        </div>
                                    </div>
                                    
                            </div>

                        </div>

                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</section>
<script>
    
    function confirmModel(id){
       <?php 
            session_start();
            $_SESSION["alertConfirm".$course->id] = 'done';
        ?>
    }

    function alertswal() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_swal_plsLearnPass ?>', "error");
    }

    function alertSequence() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_swal_plsLearnPass ?>', "error");
    }

    function alertswal_test() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_swal_plsTestPost ?>', "error");
    }

    function alertswalpretest() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_swal_plsTestPre ?>', "error");
    }

    function alertswalCourse() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_noPermis ?>', "error");
    }

    function alertswalNoCourse() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_alert_msg_notFound ?>', "error");
    }

    function alertswalcert() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_cantPrintCert ?>', "error");
    }

    function alertswalNocert() {
        swal('<?= $label->label_swal_warning ?>', 'หลักสูตรนี้ไม่มีใบประกาศนียบัตร กรุณาติดต่อผู้ดูแลระบบ', "error");
    }

    function alertswalExams() {
        swal('<?= $label->label_swal_warning ?>', 'ข้อสอบ ยังไม่เปิดให้ทำการสอบ', "error");
    }


    function showNotice(coursetype) {
        if (coursetype != null && coursetype == '36') {
            swal({
                title: '<?= $label->label_swal_warning ?>',
                text: "หากช่วงเวลาการเข้าระบบ (Login) พร้อมกันในหลายวิชา <br> กรมฯ จะนับ CPD ให้ท่าน<span style='color: red;'>เพียงวิชาเดียว</span>เท่านั้น",
                type: "info",
                html: true,
                showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: '<?= $label->label_confirm ?>',
                closeOnConfirm: true
            }, function() {
                //do something
            });
        } else {
            console.log(coursetype);
        }
    }


    $(window).load(function() {
        console.log($('#loader1'));
    });
    $(function() {

        <?php if (Yii::app()->user->hasFlash('CheckQues')) {
        ?>
            var msg = '<?php echo Yii::app()->user->getFlash('CheckQues'); ?>';
            var cla = '<?php echo Yii::app()->user->getFlash('class'); ?>';
            swal({
                title: '<?= $label->label_swal_system ?>',
                text: msg,
                type: cla,
                confirmButtonText: '<?= $label->label_confirm ?>',
            });
        <?php
            Yii::app()->user->setFlash('CheckQues', null);
            Yii::app()->user->setFlash('class', null);
        }
        ?>
        $('#loader1').hide();

        $(".knob").knob({
            draw: function() {
                // "tron" case
                if (this.$.data('skin') == 'tron') {
                    var a = this.angle(this.cv) // Angle
                        ,
                        sa = this.startAngle // Previous start angle
                        ,
                        sat = this.startAngle // Start angle
                        ,
                        ea // Previous end angle
                        , eat = sat + a // End angle
                        ,
                        r = true;

                    this.g.lineWidth = this.lineWidth;

                    this.o.cursor &&
                        (sat = eat - 0.3) &&
                        (eat = eat + 0.3);

                    if (this.o.displayPrevious) {
                        ea = this.startAngle + this.angle(this.value);
                        this.o.cursor &&
                            (sa = ea - 0.3) &&
                            (ea = ea + 0.3);
                        this.g.beginPath();
                        this.g.strokeStyle = this.previousColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                        this.g.stroke();
                    }

                    this.g.beginPath();
                    this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                    this.g.stroke();

                    this.g.lineWidth = 2;
                    this.g.beginPath();
                    this.g.strokeStyle = this.o.fgColor;
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                    this.g.stroke();

                    return false;
                }
            }
        });
        /* END JQUERY KNOB */

    });

</script>


 <script type="text/javascript">
    let arr = [];
 </script>

<script type="text/javascript">
    let sum = 0;    

    setTimeout(() => {
     setTimeout(() => {
        for (let i = 0; i < arr.length; i++) {
            sum += arr[i];
        }
        var hours = Math.floor(sum / 3600);
        var minutes = Math.floor((sum - (hours * 3600)) / 60);
        var seconds = sum - (hours * 3600) - (minutes * 60);
        if (hours < 10) { hours =  hours; }
        if (minutes < 10) { minutes =  minutes; }
        if (seconds < 10) { seconds =  seconds; }

        $(".pre-loading").hide();
        $(".LoaderNone").show();

        if(hours == 0){
            $(".houHide").hide();
        }
        if(minutes == 0){
            $(".minHide").hide();
        }
        if(seconds == 0){
            $(".secHide").hide();
        }
        $(".houShow").html(hours);
        $(".minShow").html(minutes);
        $(".secShow").html(seconds);

    }, 2000);
    }, 11000);
  
  function joinZoomMeeting(type){
        if(type == "noRoom"){
            swal("ไม่พบห้องสอบออนไลน์", "", "warning");
        }
  }
</script>