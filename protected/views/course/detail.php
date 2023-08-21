<style>
    .sweet-alert {
        z-index: 999999999999999999;

    }

    .swal2-container {

        z-index: 999999999999999999;

    }

    html {
        scroll-behavior: smooth;
    }

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



    $courseChildren = CourseOnline::model()->find(array('condition' => 'parent_id = ' . $course->course_id));
    if ($courseChildren) {
        $course->course_title = $courseChildren->course_title;
        $course->course_detail = $courseChildren->course_detail;
    }
}

$course_model = CourseOnline::model()->findByPk($course->course_id);
$gen_id = $gen != 0 ? $gen :  $course_model->getGenID($course_model->course_id);

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

<?php
$criteria = new CDbCriteria;
// $criteria->with = 'LessonLearn';
$criteria->compare('active', 'y');
// $criteria->compare('t.course_id',$course->course_id);
$criteria->compare('course_id', $course->course_id);
$criteria->compare('lang_id', 1);
// $criteria->compare('lesson_active','y');
$criteria->order = 'lesson_no';
$model = Lesson::model()->findAll($criteria);
$state = true;

if ($model) {
    foreach ($model as $key => $value) {
        $checkLessonPass = Helpers::lib()->checkLessonPass($value);
        $isChecklesson = Helpers::Checkparentlesson($value->id);

        $checkPreTest = Helpers::checkHavePreTestInManage($value->id);
        $checkPostTest = Helpers::checkHavePostTestInManage($value->id);
        if ($isChecklesson) {
            if ($state) {
                if ($checkLessonPass == 'notLearn') {
                    $stopId = $value->id;
                    $state = false;
                    $msg_step = UserModule::t('goto_lesson') . ': ' . $value->title;
                } else if ($checkLessonPass == 'learning') {
                    $stopId = $value->id;
                    $state = false;
                    $msg_step = UserModule::t('learning_lesson') . ': ' . $value->title;
                } else {
                    $state = true;
                }

                if ($checkPostTest) {
                    $isPostTest = Helpers::isPosttestState($value->id); //true = ยังไมได้ทำข้อสอบหลังเรียน,false = ทำข้อสอบหลังเรียนแล้ว
                    if ($isPostTest) {
                        $stopId = $value->id;
                        $state = false;
                        $msg_step = UserModule::t('learning_lesson') . ': ' . $value->title;
                    } else {
                        $criteria = new CDbCriteria;
                        $criteria->condition = ' lesson_id="' . $value->id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL AND active="y" AND score_past = "y" AND type = "post"' . " AND gen_id='" . $gen_id . "'";
                        $criteria->order = 'create_date ASC';
                        $BestFinalTestScore = Score::model()->findAll($criteria);
                        if (!$BestFinalTestScore) {
                            $stopId = $value->id;
                            $msg_step = UserModule::t('learning_lesson') . ': ' . $value->title;
                            $state = false;
                        } else {
                            $state = true;
                        }
                    }
                }
            }
        } else { //No sort
            if ($state) {
                $stopId = $value->sequence_id;
                $state = false;
                $msg_step = UserModule::t('goto_lesson') . ': ' . $value->lessonParent->title;
            }
        }
    }
}


if (empty($stopId)) { //All pass
    // $stopId = $model[count($model)-1]->id;
    $stopId = '';
    $msg_step = $label->label_startTestCourse;
}
if (!empty($_GET['lid'])) {
    $stopId = $_GET['lid'];
}
$criteria = new CDbCriteria;
$criteria->condition = ' course_id="' . $course->course_id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL AND active="y" AND score_past = "y"' . " AND gen_id='" . $gen_id . "'" . ' AND type="post"';
$criteria->order = 'create_date ASC';
$FinalScore = Coursescore::model()->findAll($criteria);
?>
<!-- Alert -->
<?php if (empty($FinalScore) && empty($_GET['lid'])) { ?>
    <script type="text/javascript">
        // $(document).ready(function() {
        //     ////state learning
        //     // swal({
        //     //     title: "<?= $label->label_swal_warning; ?>",
        //     //     text: "<?= $msg_step; ?>",
        //     //     icon: "warning",
        //     //     dangerMode: true,
        //     // });
        // });
    </script>
<?php } ?>

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
<?php
$lessonModel = Lesson::model()->findAllByAttributes(array(
    'active' => 'y',
    'lang_id' => '1',
    'course_id' => $course->course_id
));
?>

<script type="text/javascript">
    function getDuration(id) {

        var myVideoPlayer = document.getElementById('video_player' + id);
        var duration = myVideoPlayer.duration;
        var time = '';

        var lang = "<?= Yii::app()->session['lang'] ?>";

        if (lang == 1) {
            var leng = 'Length';
            var min = 'Minutes';
        } else {
            var leng = 'ความยาว';
            var min = 'นาที';
        }

        if (!isNaN(duration)) {
            var sec_num = parseInt(duration);
            var hours = Math.floor(sec_num / 3600);
            var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
            var seconds = sec_num - (hours * 3600) - (minutes * 60);
            if (hours < 10) {
                hours = "0" + hours;
            }
            if (minutes < 10) {
                minutes = "0" + minutes;
            }
            if (seconds < 10) {
                seconds = "0" + seconds;
            }
            time = '<i class="far fa-clock"></i> ' + hours + ':' + minutes + ':' + seconds + ' ' + min;
        }
        $("#lblduration-" + id).html(time);
    }
</script>
<div class="">
    <div class="container-main">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-main">
                <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/course/index'); ?>"><?php echo $label->label_course; ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $course->course_title ?> <?= $course->getGenName($gen_id); ?></li>
            </ol>
        </nav>
        <!--     <? phpโ
                    // $this->renderPartial('menu-steps', array(
                    //     'course'=>$course,
                    //     'stepActivate'=>$stepActivate,
                    //     'lessonList'=>$lessonList,
                    //     'label'=>$label,
                    //     'course_type'=>$course_type,
                    //));
                    ?> -->
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="course-active" id="sticker">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="thumbmail-course-detail">
                                    <?php if ($course->course_picture != null) { ?>
                                        <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/courseonline/<?= $course->course_id ?>/thumb/<?= $course->course_picture ?>" class="w-100 ">
                                    <?php } else { ?>
                                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/thumbnail.png" class="w-100 ">
                                    <?php } ?>
                                </div>
                            </div>
                            <?php


                            $percent_learn_net = 0;
                            foreach ($lessonModel as $key => $lessonListStatus) {
                                $checkLessonPass = Helpers::lib()->checkLessonPass_Percent($lessonListStatus, $gen_id);
                                $checkPostTest = Helpers::checkHavePostTestInManage($lessonListStatus->id);
                                $lessonStatus = Helpers::lib()->checkLessonPass($lessonListStatus,$gen_id);

                                if ($checkPostTest) {
                                    $isPostTest = Helpers::isPosttestState($lessonListStatus->id);
                                    if ($lessonStatus == 'pass') {
                                        if ($isPostTest) {
                                            $percent_learn = $checkLessonPass->percent - 10;
                                        } else {
                                            $percent_learn = $checkLessonPass->percent;
                                        }
                                    } else {
                                        $percent_learn = $checkLessonPass->percent;
                                    }
                                } else {
                                    $percent_learn = $checkLessonPass->percent;
                                }
                                $percent_learn_net += $percent_learn;
                            }

                            $percent_learn_net = count($lessonModel) > 0 ? $percent_learn_net / count($lessonModel) : 0;
                            ?>
                            <?php $coruse_percents =  Helpers::lib()->percent_CourseGen($course->course_id, $gen_id); ?>
                            <?php $checkpasscouse =  Helpers::lib()->checkpasscouse($coruse_percents, $course->course_id, $gen_id); ?>


                            <div class="text-left">
                                <h3><?= $course->course_title ?> <?= $course->getGenName($gen_id); ?></h3>
                            </div>

                            <div class="course-progress">
                                <h4 class="text-left"><?= $statusEdu ?></h4>
                                <div class="progress" style="height: 8px;">
                                    <!-- <div class="progress-bar" role="progressbar" style="width: <?= $percent_learn_net ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div> -->
                                    <div class="progress-bar" role="progressbar" style="width: <?= $coruse_percents ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <!-- <h5 class="text-muted text-left"><?= $percent_learn_net ?>%</h5> -->
                                <h5 class="text-muted text-left"><?= $coruse_percents ?>%</h5>

                                <div class="text-center"> <a href="#tab-content" onclick="$('#change_tab2').click();" class="btn btn-success"><?= $lastStatus ?></a></div>
                                <div class="course-admin">
                                    <h4><?= $CourseInstructor ?> : <span>
                                            <!--  <?php $profile = Profile::model()->findByPk($course->create_by);
                                                    if ($langId == 1) {
                                                        $pro_name = $profile->firstname_en;
                                                        $title_name = $profile->ProfilesTitleEn->prof_title_en;
                                                    } else {
                                                        $pro_name = $profile->firstname;
                                                        $title_name = $profile->ProfilesTitleTH->prof_title;
                                                    }
                                                    echo  $title_name . ' ' . $pro_name; ?> -->
                                            <?= $course->instructor_name ?>

                                        </span></h4>


                                </div>
                            </div>

                        </div>
                    </div>
                    <?php if ($course->document_status == 'y' || $course->price == 'y') { ?>
                        <div class="card course-detail-2">
                            <div class="card-body ">
                                <?php if ($course->price == 'y') { ?>
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12">
                                            <div class="c-item">
                                                <?php
                                                if ($courseTemp->status_payment == "y") {
                                                    $textPayment = "อนุมัติ";
                                                    $classPayment = "text-success";
                                                } elseif ($courseTemp->status_payment == "w") {
                                                    $textPayment = "รอการอนุมัติ";
                                                    $classPayment = "text-warning";
                                                } elseif ($courseTemp->status_payment == "n") {
                                                    $textPayment = "กรุณาชำระเงิน";
                                                    $classPayment = "text-warning";
                                                } else {
                                                    $textPayment = "ไม่อนุมัติ";
                                                    $classPayment = "text-danger";
                                                }
                                                ?>
                                                <h4>สถานะการชำระเงิน : <span class="<?= $classPayment ?>"><?= $textPayment ?></span></h4>
                                                <div class="text-center mt-20">
                                                    
                                                    <?php if (($courseTemp->file_payment == null && $courseTemp->status_payment == "n") || $courseTemp->status_payment == "x" || $courseTemp->status_payment == "n") { ?>
                                                        <a class="btn btn-booking-outline" onClick="$('#course-booking').appendTo('body').modal('show')"><i class="fas fa-file-invoice"></i>&nbsp;<?= $langId == 1 ? "Proof of payment" : "แนบหลักฐานการชำระเงิน" ?></a>
                                                        <!-- <a data-toggle="modal" data-target="#course-booking" class="btn btn-booking-outline"><i class="fas fa-file-invoice"></i>&nbsp;<?= $langId == 1 ? "Proof of payment" : "แนบหลักฐานการชำระเงิน" ?></a> -->
                                                    <?php } ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($course->document_status == 'y') { ?>
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12">
                                            <div class="c-item">
                                                <?php
                                                if ($courseTemp->status_document == "y") {
                                                    $textDocument = "อนุมัติ";
                                                    $classDocument = "text-success";
                                                } elseif ($courseTemp->status_document == "w") {
                                                    $textDocument = "รอการอนุมัติ";
                                                    $classDocument = "text-warning";
                                                } elseif ($courseTemp->status_document == "n") {
                                                    $textDocument = "กรุณาแนบเอกสาร";
                                                    $classDocument = "text-warning";
                                                } else {
                                                    $textDocument = "ไม่อนุมัติ";
                                                    $classDocument = "text-danger";
                                                }
                                                ?>
                                                <h4>สถานะของการแนบเอกสาร : <span class="<?= $classDocument ?>"><?= $textDocument ?></span></h4>
                                                <div class="text-center mt-20">
                                                    <?php if (count($courseDocument) > 0 && $courseTemp->status_document != 'x') { ?>
                                                        <a data-toggle="modal" data-target="#course-uploadfile" class="btn btn-booking-outline w-200"><i class="fas fa-file-invoice"></i>&nbsp;<?= $langId == 1 ? "Check Document" : "ตรวจสอบเอกสาร" ?></a>
                                                    <?php } else { ?>
                                                        <a data-toggle="modal" data-target="#course-uploadfile" class="btn btn-booking-outline w-200"><i class="fas fa-file-invoice"></i>&nbsp;<?= $langId == 1 ? "Upload Document" : "แนบไฟล์เอกสาร" ?></a>
                                                    <?php } ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="card course-detail-2">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <div class="c-item">
                                        <small><?= $Time ?></small>
                                        <div class="text-center mt-20">
                                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/clock-icon.png">
                                            <div class="pre-loading">
                                                <div id="loader" class="mt-3 mb-2"></div>
                                            </div>
                                            <small class="text-center detail-value LoaderNone" style="display: none">
                                                <font class="houHide"><b class="houShow">0</b> ชั่วโมง </font>
                                                <font class="minHide"><b class="minShow">0</b> นาที </font>
                                                <font class="secHide"><b class="secShow">0</b> วินาที </font>
                                            </small>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="c-item">
                                        <small><?= $Lessons ?></small>
                                        <div class="text-center mt-20">
                                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/book-icon.png">
                                            <small class="text-center detail-value"><?= count($lessonModel) . ' ' . $Lessons ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card course-detail-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <!--    <div class="c-item">
                                        <small><?= $CourseCert ?></small>
                                    <?php if ($coruse_percents >= 100) { ?>
                                        <div class="mt-20 text-center">
                                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/certificate-icon.png">
                                            <small class="mt-20"><a class="btn btn-warning" href="<?= $this->createUrl('Course/PrintCertificate', array('id' => $course->course_id)); ?>"><?= $Print ?></a></small> 
                                        </div>
                                    <?php } else { ?>
                                        <div class="mt-20 text-center">
                                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/certificate-icon-mute.png">
                                            <small class="mt-20"></small> 
                                        </div>
                                    <?php } ?>
                                      
                                        
                                    </div> -->

                                    <?php
                                    $category = Category::model()->findByPk($course->cate_id);
                                    $checkCourseTest = Helpers::lib()->checkCoursePass($course->course_id,$gen_id);
                                    $checkHaveCourseTest = Helpers::lib()->checkHaveCourseTestInManage($course->course_id);
                                    $checkHaveCoursePreTest = Helpers::lib()->checkHaveCoursePreTestInManage($course->course_id);
                                    $criteria = new CDbCriteria;
                                    $criteria->condition = ' course_id="' . $course->course_id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL AND active="y"' . " AND gen_id='" . $gen_id . "'" . ' AND type="post"';
                                    $criteria->order = 'create_date ASC';
                                    $BestFinalTestScore = Coursescore::model()->findAll($criteria);
                                    $allPassed = true;
                                    if ($checkHaveCourseTest && $checkCourseTest == 'pass') {
                                        if ($BestFinalTestScore) {
                                            foreach ($BestFinalTestScore as $time => $FinalTest) {
                                                if ($FinalTest->score_past == 'n' && $allPassed) {
                                                    $allPassed = false;
                                                }
                                                if ($FinalTest->score_past == 'y') {
                                                    $allPassed = true;
                                                }
                                            }
                                        } else {
                                            $allPassed = false;
                                        }
                                    } else if ($checkCourseTest == 'pass') {
                                        $allPassed = true;
                                    }

                                    $pathPassed_Onclick = '';
                                    $statePrintCert = false;
                                    $disBtn = '';

                                    $can_print_cer = 2;
                                    $CourseSurvey = CourseTeacher::model()->findAllByAttributes(array('course_id' => $course->course_id));
                                    if ($CourseSurvey) { // มี แบบสอบถาม
                                        foreach ($CourseSurvey as $key => $value) {
                                            $num_step++;
                                            $passQuest = QQuestAns_course::model()->find(array(
                                                'condition' => 'user_id = "' . Yii::app()->user->id . '" AND course_id ="' . $course->course_id . '"' . " AND gen_id='" . $gen_id . "'",
                                            ));
                                            if ($passQuest) { //ตอบแบบสอบถามแล้ว
                                                $can_print_cer = 1;
                                            }
                                        }
                                    } else {
                                        $can_print_cer = 1;
                                    }

                                    if ($allPassed && $can_print_cer == 1 && $course_wait_cer == 1 && $coruse_percents == 100) {

                                        $certDetail = CertificateNameRelations::model()->find(array('condition' => 'course_id=' . $course->course_id));
                                        if (empty($certDetail)) {
                                            $pathPassed = 'javascript:void(0);';
                                            $pathPassed_Onclick = 'onClick="alertswalNocert()"';
                                        } else {
                                            $targetBlank = 'target="_blank"';
                                            $statePrintCert = true;
                                            $pathPassed = $this->createUrl('Course/PrintCertificate', array('id' => $course->course_id, 'langId' => 1));
                                        }

                                        $certFaStat = 'text-success';
                                        $img_tophy = Yii::app()->theme->baseUrl . "/images/certificate-icon.png";
                                    } else {
                                        //$pathPassed = $this->createUrl('/course/final', array('id' => $course->course_id));
                                        $pathPassed = 'javascript:void(0);';
                                        $certFaStat = 'text-muted';
                                        $certEvnt = 'onclick="alertswalcert()"';
                                        $img_tophy = Yii::app()->theme->baseUrl . "/images/certificate-icon-mute.png";
                                        $disBtn = 'disabled';
                                    }

                                    ?>
                                    <?php
                                    $CheckHaveCer = Helpers::lib()->CheckHaveCer($course->course_id);
                                    if ($CheckHaveCer) {
                                    ?>
                                        <?php if($courseTemp->lock_document == 'y') { ?> <!--มีการล็อค-->
                                            
                                            <div class="c-item">
                                                <small><?= $CourseCert ?> <i class="fa fa-lock" aria-hidden="true"></i></small>
                                                <div class="certificate-check mt-20">
                                                    <a onclick="alertLockDocument()" href="javascript:void(0)">
                                                        <div class="text-center">
                                                            <i class="" aria-hidden="true"><img src="<?= $img_tophy ?>"></i>
                                                            <small class="mt-20"><?= $label->label_printCert ?></small>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>

                                        <?php }else { ?> <!--ไม่มีการล็อค-->
                                                <?php if ($course->price == 'y') {  ?> <!--คอร์ดไม่ฟรี-->
                                                        <?php if($courseTemp->status_document == 'y' &&  $courseTemp->status_payment == 'y') {?> <!--เอกสารครบ-->
                                                            <div class="c-item">
                                                                <small><?= $CourseCert ?></small>
                                                                <div class="certificate-check mt-20">
                                                                    <a href="<?php echo $pathPassed; ?>" <?= $pathPassed_Onclick; ?> <?php echo $targetBlank . " " . $certEvnt; ?>>
                                                                        <div class="text-center">
                                                                            <i class="" aria-hidden="true"><img src="<?= $img_tophy ?>"></i>
                                                                            <small class="mt-20"><?= $label->label_printCert ?></small>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        <?php }else { ?> <!--เอกสารไม่ครบ-->
                                                            <div class="c-item">
                                                                <small><?= $CourseCert ?> <i class="fa fa-exclamation-circle" aria-hidden="true"></i></small>
                                                                <div class="certificate-check mt-20">
                                                                    <a onclick="alertIncomDocuments()" href="javascript:void(0)">
                                                                        <div class="text-center">
                                                                            <i class="" aria-hidden="true"><img src="<?= $img_tophy ?>"></i>
                                                                            <small class="mt-20"><?= $label->label_printCert ?></small>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        <?php }?>
                                                <?php }else { ?><!--คอร์ดฟรี-->
                                                            <div class="c-item">
                                                                <small><?= $CourseCert ?></small>
                                                                <div class="certificate-check mt-20">
                                                                    <a href="<?php echo $pathPassed; ?>" <?= $pathPassed_Onclick; ?> <?php echo $targetBlank . " " . $certEvnt; ?>>
                                                                        <div class="text-center">
                                                                            <i class="" aria-hidden="true"><img src="<?= $img_tophy ?>"></i>
                                                                            <small class="mt-20"><?= $label->label_printCert ?></small>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                <?php } ?>
                                        <?php } ?>

                                    <?php } ?>
                                    <?php //} 
                                    ?>
                                    <?php
                                    if ($checkCourseTest == 'pass') { //Lesson All pass
                                        if ($checkHaveCourseTest) {
                                            $criteria = new CDbCriteria;
                                            $criteria->compare('course_id', $course->course_id);
                                            $criteria->compare('gen_id', $gen_id);
                                            $criteria->compare('type', "post");
                                            $criteria->compare('user_id', Yii::app()->user->id);
                                            $criteria->compare('score_past', 'y');
                                            $criteria->compare('active', 'y');
                                            $criteria->order = 'score_id';
                                            $courseScorePass = Coursescore::model()->findAll($criteria);
                                            if ($courseScorePass) {
                                                $img_Survey = Yii::app()->theme->baseUrl . "/images/questionnaire-icon.png";

                                                if ($PaQuest) { //ทำแบบสอบถามแล้ว
                                                    $step = 0;
                                                    $pathSurvey = $this->createUrl('course/questionnaire', array('id' => $course->course_id,'gen'=>$gen_id));
                                                } else {
                                                    $pathSurvey = $this->createUrl('questionnaire_course/index', array('id' => $CourseSurvey[0]->id,'gen'=>$gen_id));
                                                }
                                            } else { //ยังทำแบบทดสอบหลักสูตรไม่ผ่าน
                                                $img_Survey = Yii::app()->theme->baseUrl . "/images/questionnaire-icon-mute.png";
                                                $pathSurvey = 'javascript:void(0);';
                                                $alrtSurvey = 'onclick="alertswalCourse()"';
                                            }
                                        } else {
                                            $img_Survey = Yii::app()->theme->baseUrl . "/images/questionnaire-icon.png";
                                            if ($PaQuest) { //ทำแบบสอบถามแล้ว
                                                $step = 0;
                                                $pathSurvey = $this->createUrl('course/questionnaire', array('id' => $course->course_id,'gen'=>$gen_id));
                                            } else {
                                                $pathSurvey = $this->createUrl('questionnaire_course/index', array('id' => $CourseSurvey[0]->id,'gen'=>$gen_id));
                                            }
                                        }
                                    } else {
                                        $pathSurvey = 'javascript:void(0);';
                                        $alrtSurvey = 'onclick="alertswalCourse()"';
                                        $img_Survey = Yii::app()->theme->baseUrl . "/images/questionnaire-icon-mute.png";
                                    }
                                    ?>
                                </div>
                                <?php if ($CourseSurvey) { ?>
                                    <div class="col-md-6">
                                        <div class="c-item">
                                            <small><?= $CourseEvaluation ?></small>
                                            <div class="mt-20 text-center">
                                                <a href="<?= $pathSurvey ?>" <?= $alrtSurvey  ?>>
                                                    <img src="<?= $img_Survey ?>">
                                                    <small class="mt-20"><?= $Click ?></small>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-sm-8 col-md-8 col-xs-12">

                <div class="topic-course">
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
                                $periodCourse = (!empty($course)) ? "(".Helpers::lib()->covert24HourTo12Hour($course->course_date_start, $langId) . Helpers::lib()->CuttimeLang($course->course_date_start, $langId) . " - " .Helpers::lib()->covert24HourTo12Hour($course->course_date_end, $langId) . Helpers::lib()->CuttimeLang($course->course_date_end, $langId) . ")" : "";
                                $periodDate = $course->course_day_learn;
                            }
                        ?>
                        <?= $Period ?> <?= $periodDate ?> <?= $day ?> <?= $periodCourse ?>
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

                                    <?php echo htmlspecialchars_decode($course->course_detail); ?>

                                    <div class="text-left"> <a href="#tab-content" onclick="$('#change_tab2').click();" class="btn btn-warning">Next</a></div>

                                </li>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="course-unit">
                                <ol class="course-ol">
                                    <div class="panel panel-default">
                                        <?php
                                        $can_next_step = 1; //เรียนได้
                                        if ($checkHaveCoursePreTest) { // เช็คมีข้อสอบ สอบก่อนเรียน ของหลักสูตร
                                        ?>
                                            <div class="panel-heading headcourse final-test">
                                                <a role="button" data-toggle="collapse" data-target="#collapsePreCourse" data-parent="#accordion" aria-expanded="true">
                                                    <li>
                                                        <span class="stepcourse"> <?= $checkHaveCoursePreTest ? $pre_course : ''; ?> <?= $course->course_title ?> <?= $course->getGenName($gen_id); ?></span>
                                                        <span class="pull-right"><i class="fa fa-angle-down"></i></span>
                                                    </li>
                                                </a>
                                            </div>


                                            <?php
                                            $checkHaveScoreCoursePreTest = Helpers::lib()->checkHaveScoreCoursePreTest($course->course_id, $gen_id);
                                            if ($checkHaveScoreCoursePreTest) { //ยังไม่สอบ ไม่มีคะแนน
                                                $can_next_step = 2; //ห้ามเรียน ห้ามสอบ ห้ามทุกอย่าง
                                                $pathCourseTest = $this->createUrl('coursequestion/preexams', array('id' => $course->course_id,'gen'=>$gen_id, 'type' => 'pre'));
                                            ?>
                                                <div id="collapsePreCourse" class="collapse in">
                                                    <li class="list-group-item ">
                                                        <a href="<?= $pathCourseTest ?>" <?= $alertCourseTest ?>>
                                                            <span class="list__course"><?php echo $label->label_testPre; ?></span>
                                                            <span class="btn btn-warning detailmore pull-right"><?php echo $label->label_DoTest; ?>
                                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>
                                                    </li>
                                                </div>

                                            <?php
                                            } else { //มีคะแนนสอบ
                                                $ScoreCoursePreTest = Helpers::lib()->ScoreCoursePreTest($course->course_id, $gen_id);
                                                $CheckPreTestAnsTextAreaCourse = Helpers::lib()->CheckPreTestAnsTextAreaCourse($course->course_id, "pre");
                                                $passCoursequestion = Helpers::lib()->checkPassCoursequestion($course->course_id, $gen_id); 
                                            ?>
                                                <div id="collapsePreCourse" class="collapse" style="height: 0px;">
                                                    <?php
                                                    if ($CheckPreTestAnsTextAreaCourse) {
                                                    ?>
                                                        <li class="list-group-item ">
                                                            <!-- <a href=""> -->
                                                                <span class="list__course"><?php echo $label->label_testPre; ?></span>

                                                                <?php if($course->hidden_score == 'y') { ?>
                                                                    <span class="pull-right text-warning prepost">
                                                                            <?= $langId == 1 ? "Pending check" : "รอตรวจคำตอบ"  ?>
                                                                    </span>
                                                                <?php }else{ ?>
                                                                    <?php if($passCoursequestion->score_past == 'y'){ ?>
                                                                    <span class="pull-right  text-success prepost">
                                                                        <?= $ScoreCoursePreTest; ?>
                                                                        <?= $label->label_point; ?>
                                                                    </span>
                                                                    <?php }else { ?>
                                                                        <span class="pull-right  text-danger prepost">
                                                                            <?= $ScoreCoursePreTest; ?>
                                                                            <?= $label->label_point; ?>
                                                                        </span>
                                                                    <?php } ?>    
                                                                <?php } ?>
                                                            <!-- </a> -->
                                                        </li>
                                                    <?php
                                                    } else {
                                                        $course_wait_cer = 2;
                                                    ?>
                                                        <li class="list-group-item ">
                                                            <a href="">
                                                                <span class="list__course"><?php echo $label->label_testPre; ?></span>
                                                                <span class="pull-right  text-danger prepost"><?= $label->label_course_wait; ?></span>
                                                            </a>
                                                        </li>
                                                    <?php
                                                    }

                                                    ?>



                                                </div>
                                        <?php
                                            } //if($checkHaveScoreCoursePreTest)
                                        } //if($checkHaveCoursePreTest) 
                                        ?>












                                        <?php
                                        foreach ($lessonList as $key => $lessonListValue) {
                                            if (!$flag) {
                                                $lessonListChildren  = Lesson::model()->find(array('condition' => 'parent_id = ' . $lessonListValue->id, 'order' => 'lesson_no'));
                                                if ($lessonListChildren) {
                                                    $lessonListValue->title = $lessonListChildren->title;
                                                    $lessonListValue->description = $lessonListChildren->description;
                                                    $lessonListValue->content = $lessonListChildren->content;
                                                    $lessonListValue->image = $lessonListChildren->image;
                                                }
                                            }

                                            // var_dump($lessonListValue);
                                            $idx = 1;
                                            $checkPreTest = Helpers::checkHavePreTestInManage($lessonListValue->id);

                                            $checkPostTest = Helpers::checkHavePostTestInManage($lessonListValue->id);
                                            // var_dump($checkPostTest);exit();
                                            $lessonStatus = Helpers::lib()->checkLessonPass($lessonListValue,$gen_id);

                                            $checkLessonPass = Helpers::lib()->checkLessonPass_Percent($lessonListValue,null,$gen_id);
                                            
                                            $postStatus = Helpers::lib()->CheckTest($lessonListValue, "post");
                                            // var_dump($postStatus);
                                            $chk_test_type = Helpers::lib()->CheckTestCount('pass', $lessonListValue->id, true, false, "post");
                                            $isChecklesson = Helpers::lib()->Checkparentlesson($lessonListValue->id);

                                        ?>

                                            <?php
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

                                            // var_dump($label->label_learning);

                                            $step = 0;
                                            if ($lessonListValue->id == $stopId) {
                                                $step =  Helpers::lib()->checkStepLesson($lessonListValue);
                                                // var_dump($step);
                                            } else if (empty($stopId)) { //step to course test
                                                $criteria = new CDbCriteria;
                                                $criteria->compare('active', 'y');
                                                $criteria->compare('user_id', Yii::app()->user->id);
                                                $criteria->compare('course_id', $course->course_id);
                                                $criteria->compare('gen_id', $gen_id);
                                                $criteria->compare('type', 'post');
                                                $scoreCourse = Coursescore::model()->findAll($criteria);
                                                $status_courseTest = array();
                                                foreach ($scoreCourse as $key => $value) {
                                                    $status_courseTest[] = $value->score_past;
                                                }
                                                if (in_array("y", $status_courseTest)) {

                                                    $step = 5;
                                                } else if (count($scoreCourse) == $course->cate_amount) {
                                                    $step = 4;
                                                } else { //ยังไม่ผ่านแต่มีสิทธสอบ
                                                    $step = 4;
                                                }
                                            }
                                            ?>

                                            <div class="panel-heading headcourse <?php //echo $colorTab; 
                                                                                    ?>" role="tab" id="lessonId<?= $lessonListValue->id; ?>">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?= $lessonListValue->id ?>" aria-expanded="true" aria-controls="collapseOne">

                                                    <?php
                                                    $idLesson_img = (!$flag) ? $lessonListChildren->id : $lessonListValue->id;
                                                    $uploadDir = Yii::app()->baseUrl . '/uploads/lesson/' . $idLesson_img . '/thumb/';
                                                    $filename = $lessonListValue->image;
                                                    $filename = $uploadDir . $filename;

                                                    ?>
                                                    <li id="collapseles<?= $lessonListValue->id ?>">
                                                        <?php if ($lessonListValue->image != "") { ?>
                                                            <img src="<?= $filename; ?>" class="img-rounded" alt="" style=" width:70px; height:50px;">
                                                        <?php } ?>
                                                        <span class="title__course">
                                                            <?= $lessonListValue->title ?>
                                                        </span>
                                                        <?php if($course->hidden_score != "y") { ?>
                                                            <label style="color: <?= $checkLessonPass->color ?>" class="<?= $checkLessonPass->class ?>"><?= $lessonStatusStr ?></label>
                                                        <?php } ?>
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

                                                        $isPreTest = Helpers::isPretestState($lessonListValue->id,$gen_id);
                                                        if ($isChecklesson && $can_next_step  != 2) {
                                                            $ckLinkTest = $this->createUrl('/question/preexams', array('id' => $lessonListValue->id,'gen'=>$gen_id ,'type' => 'pre'));
                                                            $ckLinkTest_onClick = '';
                                                        } else {
                                                            $ckLinkTest = 'javascript:void(0);';
                                                            $ckLinkTest_onClick = 'onclick="alertSequence();"';
                                                        }

                                                        if ($isPreTest) { // สอบ pre 1 ครั้ง แล้ว ไม่เข้า
                                                            $prelearn = false;
                                                        ?>
                                                            <li class="list-group-item">
                                                                <?php if ($step == 1) { ?>
                                                                    <!-- <div class="pt-now"> You are here</div> -->
                                                                <?php } ?>
                                                                <?php echo $label->label_testPre; ?> <span class="pull-right">
                                                                    <!-- <a href="<?php echo $this->createUrl('/question/preexams', array('id' => $lessonListValue->id,'gen'=>$gen_id, 'type' => 'pre')); ?>" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"> -->
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
                                                            $criteriaScoreAll->condition = ' type = "pre" AND lesson_id="' . $lessonListValue->id . '" AND user_id="' . Yii::app()->user->id . '" and active = "y"' . " AND gen_id='" . $gen_id . "'";
                                                            $scoreAll = Score::model()->findAll($criteriaScoreAll);
                                                            foreach ($scoreAll as $keyx => $score_ck) {
                                                                // $preStatus = Helpers::lib()->CheckTest($lessonListValue, "pre");
                                                                if ($score_ck->score_past == 'y') {
                                                                    $flagPreTestPass = true;
                                                                    $colorText = 'text-success';
                                                                } else {
                                                                    $colorText = 'text-danger';
                                                                }
                                                                $preStatus = Helpers::lib()->CheckTestAll($lessonListValue, "pre", $score_ck);


                                                                $CheckPreTestAnsTextAreaLesson = Helpers::lib()->CheckPreTestAnsTextAreaLesson($lessonListValue, "pre");
                                                                if ($CheckPreTestAnsTextAreaLesson) {
                                                            ?>
                                                                    <li class="list-group-item">
                                                                        <?php if($course->hidden_score == 'y') { ?>
                                                                            <?php echo $label->label_resultTestPre; ?> <?= $keyx + 1; ?>
                                                                            <span class="pull-right text-warning prepost">
                                                                                 <?= $langId == 1 ? "Pending check" : "รอตรวจคำตอบ"  ?>
                                                                            </span>
                                                                        <?php } else { ?>
                                                                            <?php echo $label->label_resultTestPre; ?> <?= $keyx + 1; ?><span class="pull-right <?= $colorText; ?> prepost"> <?= $preStatus->value['score']; ?>/<?= $preStatus->value['total']; ?> <?php echo $label->label_point; ?></span> 
                                                                        <?php } ?>
                                                                      
                                                                    </li>
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
                                                        // $lessonListValue->cate_amount = 1;
                                                        if ($pre_test_again == 1 && count($scoreAll) < 1 && !$flagPreTestPass && count($scoreAll) != 0 && $can_next_step  != 2) {
                                                        ?>
                                                            <li class="list-group-item">
                                                                <?php if ($step == 1) { ?>
                                                                    <!-- <div class="pt-now"> You are here</div> -->
                                                                <?php } ?>
                                                                <?php echo $label->label_testPre; ?> <?= count($scoreAll) + 1; ?> <span class="pull-right"><a href="<?php echo $this->createUrl('/question/preexams', array('id' => $lessonListValue->id,'gen'=>$gen_id, 'type' => 'pre')); ?>" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $label->label_DoTest; ?></a></span>
                                                            </li>
                                                        <?php } ?>
                                                    <?php
                                                } else {
                                                    $prelearn = true;
                                                    ?>
                                                        <!-- <li class="list-group-item">ไม่มีข้อสอบก่อนเรียน</li> -->
                                                    <?php
                                                }
                                                $learnModel = Learn::model()->find(array(
                                                    'condition' => 'lesson_id=:lesson_id AND user_id=:user_id AND lesson_active=:status AND gen_id=:gen_id',
                                                    'params' => array(':lesson_id' => $lessonListValue->id, ':user_id' => Yii::app()->user->id, ':status' => 'y', ':gen_id' => $gen_id)
                                                ));
                                                if ($lessonListValue->type == 'vdo') {
                                                    ?>
                                                        <div class="stepcoursediv">
                                                            <div>
                                                                <span class="stepcourse"><?php echo $label->label_step; ?> <?= $idx++; ?>
                                                                </span><?php echo $label->label_gotoLesson; ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($lessonListValue->files as $les) {
                                                            if ($isChecklesson) {
                                                                if (!$prelearn) {
                                                                    $learnlink = 'javascript:void(0);';
                                                                    $learnalert = 'alertswalpretest();';
                                                                } else {
                                                                    $criteriaPre = new CDbCriteria;
                                                                    $criteriaPre->compare('lesson_id', $lessonListValue->id);
                                                                    $criteriaPre->compare('user_id', Yii::app()->user->id);
                                                                    $criteriaPre->compare('type', 'pre');
                                                                    $criteriaPre->compare('gen_id', $gen_id);
                                                                    $criteriaPre->compare('active', 'y');
                                                                    $modelPreScore = Score::model()->findAll($criteriaPre);
                                                                    $flagCheckPre = true;
                                                                    if ($modelPreScore) {
                                                                        $checkPrePass = array();
                                                                        foreach ($modelPreScore as $key => $scorePre) {
                                                                            $checkPrePass[] = $scorePre->score_past;
                                                                            // if($scorePre->score_past == 'n' && (count($scorePre) < $lessonListValue->cate_amount)){
                                                                            //     $flagCheckPre = true;
                                                                            // }
                                                                        }
                                                                        if (!in_array("y", $checkPrePass)) {
                                                                            if (count($modelPreScore) < 1) {
                                                                                $flagCheckPre = false;
                                                                            }
                                                                        }
                                                                        // if(count($modelPreScore) == $lessonListValue->cate_amount){
                                                                        //     if(!in_array("y", $checkPrePass)){
                                                                        //         $flagCheckPre = false;
                                                                        //     }
                                                                        // } 
                                                                        // if(in_array("n", $checkPrePass) && count($modelPreScore) < $lessonListValue->cate_amount){
                                                                        //     $flagCheckPre = false;
                                                                        // }else{
                                                                        //     $flagCheckPre = true;
                                                                        // }
                                                                    }
                                                                    if (!$flagCheckPre) {
                                                                        $learnlink = 'javascript:void(0);';
                                                                        $learnalert = 'alertswalpretest();';
                                                                    } elseif ($can_next_step  != 2) {
                                                                        $learnlink = $this->createUrl('/course/courselearn', array('id' => $lessonListValue->id,'gen'=>$gen_id, 'file' => $les->id,'vdo'=>$i));
                                                                        $learnalert = '';
                                                                    } else {
                                                                        $learnlink = 'javascript:void(0);';
                                                                        $learnalert = 'alertswalpretest();';
                                                                    }
                                                                }
                                                            } else {
                                                                $learnlink = 'javascript:void(0);';
                                                                $learnalert = 'alertSequence();';
                                                            }
                                                            $learnFiles = Helpers::lib()->checkLessonFile($les, $learnModel->learn_id,$gen_id);
                                                            if ($learnFiles == "notLearn") {
                                                                $statusValue = '<span class="label label-default" >' . $label->label_notLearn . ' </span>';
                                                            } else if ($learnFiles == "learning") {
                                                                $statusValue = '<span class="label label-warning" >' . $label->label_learning . '</span>';
                                                            } else if ($learnFiles == "pass") {
                                                                $statusValue = '<span class="label label-success" >' . $label->label_learnPass . '</span>';
                                                            }
                                                        ?>
                                                            <!-- <div class="stepcoursediv"> -->
                                                            <!-- <div>
                                                                                <span class="stepcourse"><?php echo $label->label_step; ?> 
                                                                            </span><?php echo $label->label_gotoLesson; ?>
                                                                        </div> -->
                                                            <!-- </div> -->
                                                            <a href="<?= $learnlink ?>" <?= $learnalert != '' ? 'onclick="' . $learnalert . '"' : ''; ?>>
                                                                <li class="list-group-item ">
                                                                    <?php if ($step == 2) { ?>
                                                                        <!-- <div class="pt-now"> You are here</div> -->
                                                                    <?php } ?>
                                                                    <span class="pull-right">
                                                                        <span id="lblduration-<?= $les->id ?>"></span> <span class="btn btn-warning detailmore"><?php echo $label->label_gotoLesson; ?> <i class="fa fa-play-circle"></i> </span></span>
                                                                    <span class="vdocourse list__course"><?= $les->getRefileName() ?> </span>&nbsp;<?= $statusValue ?>
                                                                    <div class="hidden">
                                                                        <video id="video_player<?= $les->id ?>" width="320" height="240" controls>
                                                                            <source src="<?php echo $uploadFolder . $les->filename; ?>" type="video/mp4">
                                                                        </video>
                                                                        <div id="meta"></div>
                                                                    </div>
                                                                </li>
                                                            </a>
                                                            <script type="text/javascript">
                                                                var vid = document.getElementById("video_player" + <?= $les->id ?>);
                                                                vid.onloadedmetadata = function() {
                                                                    getDuration(<?= $les->id ?>);
                                                                };
                                                            </script>
                                                        <?php
                                                        $i++;
                                                        }
                                                    } else if ($lessonListValue->type == 'youtube') {
                                                        ?>
                                                        <div class="stepcoursediv">
                                                            <div>
                                                                <span class="stepcourse"><?php echo $label->label_step; ?> <?= $idx++; ?>
                                                                </span><?php echo $label->label_gotoLesson; ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        foreach ($lessonListValue->files as $les) {
                                                            if ($isChecklesson) {
                                                                if (!$prelearn) {
                                                                    $learnlink = 'javascript:void(0);';
                                                                    $learnalert = 'alertswalpretest();';
                                                                } else {
                                                                    $criteriaPre = new CDbCriteria;
                                                                    $criteriaPre->compare('lesson_id', $lessonListValue->id);
                                                                    $criteriaPre->compare('user_id', Yii::app()->user->id);
                                                                    $criteriaPre->compare('type', 'pre');
                                                                    $criteriaPre->compare('gen_id', $gen_id);
                                                                    $criteriaPre->compare('active', 'y');
                                                                    $modelPreScore = Score::model()->findAll($criteriaPre);
                                                                    $flagCheckPre = true;
                                                                    if ($modelPreScore) {
                                                                        $checkPrePass = array();
                                                                        foreach ($modelPreScore as $key => $scorePre) {
                                                                            $checkPrePass[] = $scorePre->score_past;
                                                                        }
                                                                        if (!in_array("y", $checkPrePass)) {
                                                                            if (count($modelPreScore) < 1) {
                                                                                $flagCheckPre = false;
                                                                            }
                                                                        }
                                                                    }
                                                                    if (!$flagCheckPre) {
                                                                        $learnlink = 'javascript:void(0);';
                                                                        $learnalert = 'alertswalpretest();';
                                                                    } elseif ($can_next_step  != 2) {
                                                                        $learnlink = $this->createUrl('/course/courselearn', array('id' => $lessonListValue->id,'gen'=>$gen_id, 'file' => $les->id));
                                                                        $learnalert = '';
                                                                    } else {
                                                                        $learnlink = 'javascript:void(0);';
                                                                        $learnalert = 'alertswalpretest();';
                                                                    }
                                                                }
                                                            } else {
                                                                $learnlink = 'javascript:void(0);';
                                                                $learnalert = 'alertSequence();';
                                                            }
                                                            $learnFiles = Helpers::lib()->checkLessonFile($les, $learnModel->learn_id);
                                                            if ($learnFiles == "notLearn") {
                                                                $statusValue = '<span class="label label-default" >' . $label->label_notLearn . ' </span>';
                                                            } else if ($learnFiles == "learning") {
                                                                $statusValue = '<span class="label label-warning" >' . $label->label_learning . '</span>';
                                                            } else if ($learnFiles == "pass") {
                                                                $statusValue = '<span class="label label-success" >' . $label->label_learnPass . '</span>';
                                                            }
                                                        ?>
                                                            <a href="<?= $learnlink ?>" <?= $learnalert != '' ? 'onclick="' . $learnalert . '"' : ''; ?>>
                                                                <li class="list-group-item ">
                                                                    <span class="pull-right">
                                                                        <span id="lblduration-<?= $les->id ?>"></span> <span class="btn btn-warning detailmore"><?php echo $label->label_gotoLesson; ?> <i class="fa fa-play-circle"></i> </span></span>
                                                                    <span class="vdocourse list__course"><?= $les->getRefileName() ?> </span>&nbsp;<?= $statusValue ?>
                                                                    <div class="hidden">
                                                                        <video id="video_player<?= $les->id ?>" width="320" height="240" controls>
                                                                            <source src="<?php echo $les->filename; ?>" type="video/mp4">
                                                                        </video>
                                                                        <div id="meta"></div>
                                                                    </div>
                                                                </li>
                                                            </a>
                                                            <script type="text/javascript">
                                                                var vid = document.getElementById("video_player" + <?= $les->id ?>);
                                                                vid.onloadedmetadata = function() {
                                                                    getDuration(<?= $les->id ?>);
                                                                };
                                                            </script>
                                                        <?php
                                                        }
                                                    } else if ($lessonListValue->type == 'scorm') {
                                                        foreach ($lessonListValue->fileScorm as $les) {
                                                            if (!$prelearn) {
                                                                $learnlink = 'javascript:void(0);';
                                                                $learnalert = 'alertswalpretest();';
                                                            } elseif ($can_next_step != 2) {
                                                                $learnlink = $this->createUrl('/course/courselearn', array('id' => $lessonListValue->id,'gen'=>$gen_id, 'file' => $les->id));
                                                                $learnalert = '';
                                                            } else {
                                                                $learnlink = 'javascript:void(0);';
                                                                $learnalert = 'alertswalpretest();';
                                                            }
                                                            $learnFiles = Helpers::lib()->checkLessonFile($les, $learnModel->learn_id);
                                                            if ($learnFiles == "notLearn") {
                                                                $statusValue = '<span class="label label-default" >' . $label->label_notLearn . '</span>';
                                                            } else if ($learnFiles == "learning") {
                                                                $statusValue = '<span class="label label-warning" >' . $label->label_learning . '</span>';
                                                            } else if ($learnFiles == "pass") {
                                                                $statusValue = '<span class="label label-success" >' . $label->label_learnPass . '</span>';
                                                            }
                                                        ?>
                                                            <a href="<?= $learnlink ?>" <?= $learnalert != '' ? 'onclick="' . $learnalert . '"' : ''; ?>>
                                                                <li class="list-group-item ">
                                                                    <?php if ($step == 2) { ?>
                                                                        <!-- <div class="pt-now"> You are here</div> -->
                                                                    <?php } ?>
                                                                    <span class="pull-right">
                                                                        <span id="lblduration-<?= $les->id ?>"></span> <span class="label label-default"><?php echo $label->label_gotoLesson; ?> <i class="fa fa-play-circle"></i> </span></span>
                                                                    <span class="list__course"><?= $les->filename; ?></span>&nbsp;<?= $statusValue ?>
                                                                    <div class="hidden">
                                                                        <video id="video_player<?= $les->id ?>" width="320" height="240" controls>
                                                                            <source src="<?php echo $uploadFolder . $les->filename; ?>" type="video/mp4">
                                                                        </video>
                                                                        <div id="meta"></div>
                                                                    </div>
                                                                </li>
                                                            </a>
                                                        <?php
                                                        }
                                                    } else if ($lessonListValue->type == 'ebook') {
                                                        foreach ($lessonListValue->fileEbook as $les) {
                                                            if (!$prelearn) {
                                                                $learnlink = 'javascript:void(0);';
                                                                $learnalert = 'alertswalpretest();';
                                                            } elseif ($can_next_step != 2) {
                                                                $learnlink = $this->createUrl('/course/courselearnebook', array('id' => $lessonListValue->id,'gen'=>$gen_id, 'file' => $les->id));
                                                                $learnalert = '';
                                                            } else {
                                                                $learnlink = 'javascript:void(0);';
                                                                $learnalert = 'alertswalpretest();';
                                                            }
                                                            $learnFiles = Helpers::lib()->checkLessonFile($les, $learnModel->learn_id);
                                                            if ($learnFiles == "notLearn") {
                                                                $statusValue = '<span class="label label-default" >' . $label->label_notLearn . '</span>';
                                                            } else if ($learnFiles == "learning") {
                                                                $statusValue = '<span class="label label-warning" >' . $label->label_learning . '</span>';
                                                            } else if ($learnFiles == "pass") {
                                                                $statusValue = '<span class="label label-success" >' . $label->label_learnPass . '</span>';
                                                            }
                                                        ?>
                                                            <a href="<?= $learnlink ?>" <?= $learnalert != '' ? 'onclick="' . $learnalert . '"' : ''; ?>>
                                                                <li class="list-group-item ">
                                                                    <?php if ($step == 2) { ?>
                                                                        <!-- <div class="pt-now"> You are here</div> -->
                                                                    <?php } ?>
                                                                    <span class="pull-right">
                                                                        <span id="lblduration-<?= $les->id ?>"></span> <span class="label label-default"><?php echo $label->label_gotoLesson; ?> <i class="fa fa-play-circle"></i> </span></span>
                                                                    <span class="list__course"><?= $les->filename; ?></span>&nbsp;<?= $statusValue ?>
                                                                    <div class="hidden">
                                                                        <video id="video_player<?= $les->id ?>" width="320" height="240" controls>
                                                                            <source src="<?php echo $uploadFolder . $les->filename; ?>" type="video/mp4">
                                                                        </video>
                                                                        <div id="meta"></div>
                                                                    </div>
                                                                </li>
                                                            </a>
                                                        <?php
                                                        }
                                                    } else if ($lessonListValue->type == 'audio') {
                                                        foreach ($lessonListValue->fileAudio as $les) {
                                                            if (!$prelearn) {
                                                                $learnlink = 'javascript:void(0);';
                                                                $learnalert = 'alertswalpretest();';
                                                            } else {
                                                                $criteriaPre = new CDbCriteria;
                                                                $criteriaPre->compare('lesson_id', $lessonListValue->id);
                                                                $criteriaPre->compare('gen_id', $gen_id);
                                                                $criteriaPre->compare('user_id', Yii::app()->user->id);
                                                                $criteriaPre->compare('type', 'pre');
                                                                $criteriaPre->compare('active', 'y');
                                                                $modelPreScore = Score::model()->findAll($criteriaPre);
                                                                $flagCheckPre = true;
                                                                if ($modelPreScore) {
                                                                    $checkPrePass = array();
                                                                    foreach ($modelPreScore as $key => $scorePre) {
                                                                        $checkPrePass[] = $scorePre->score_past;
                                                                    }
                                                                    if (count($modelPreScore) < 1) {
                                                                        if (!in_array("y", $checkPrePass)) {
                                                                            $flagCheckPre = false;
                                                                        }
                                                                    }
                                                                }

                                                                if (!$flagCheckPre) {
                                                                    $learnlink = 'javascript:void(0);';
                                                                    $learnalert = 'alertswalpretest();';
                                                                } elseif ($can_next_step != 2) {
                                                                    $learnlink = $this->createUrl('/course/courselearn', array('id' => $lessonListValue->id,'gen'=>$gen_id, 'file' => $les->id));
                                                                    $learnalert = '';
                                                                } else {
                                                                    $learnlink = 'javascript:void(0);';
                                                                    $learnalert = 'alertswalpretest();';
                                                                }
                                                            }
                                                            $learnFiles = Helpers::lib()->checkLessonFile($les, $learnModel->learn_id);
                                                            if ($learnFiles == "notLearn") {
                                                                $statusValue = '<span class="label label-default" >' . $label->label_notLearn . ' </span>';
                                                            } else if ($learnFiles == "learning") {
                                                                $statusValue = '<span class="label label-warning" >' . $label->label_learning . '</span>';
                                                            } else if ($learnFiles == "pass") {
                                                                $statusValue = '<span class="label label-success" >' . $label->label_learnPass . '</span>';
                                                            }
                                                        ?>
                                                            <div class="stepcoursediv">
                                                                <div> <span class="stepcourse"><?php echo $label->label_step; ?> <?= $idx++; ?> </span><?php echo $label->label_gotoLesson; ?></div>
                                                            </div>
                                                            <a href="<?= $learnlink ?>" <?= $learnalert != '' ? 'onclick="' . $learnalert . '"' : ''; ?>>
                                                                <li class="list-group-item">
                                                                    <?php if ($step == 2) { ?>
                                                                        <!-- <div class="pt-now"> You are here</div> -->
                                                                    <?php } ?>
                                                                    <span class="pull-right">
                                                                        <span id="lblduration-<?= $les->id ?>"></span> <span class="btn btn-warning detailmore"><?php echo $label->label_gotoLesson; ?> <i class="fa fa-play-circle"></i> </span></span>
                                                                    <span class="vdocourse list__course"><?= $les->getRefileName() ?> </span>&nbsp;<?= $statusValue ?>
                                                                    <div class="hidden">
                                                                        <video id="video_player<?= $les->id ?>" width="320" height="240" controls>
                                                                            <source src="<?php echo $uploadFolder . $les->filename; ?>" type="video/mp4">
                                                                        </video>
                                                                        <div id="meta"></div>
                                                                    </div>
                                                                </li>
                                                            </a>
                                                        <?php
                                                        }
                                                    } else if ($lessonListValue->type == 'pdf') {
                                                        foreach ($lessonListValue->filePdf as $les) {
                                                            if ($isChecklesson) {
                                                                if (!$prelearn) {
                                                                    $learnlink = 'javascript:void(0);';
                                                                    $learnalert = 'alertswalpretest();';
                                                                } elseif ($can_next_step != 2) {
                                                                    $learnlink = $this->createUrl('/course/courselearn', array('id' => $lessonListValue->id,'gen'=>$gen_id, 'file' => $les->id));
                                                                    $learnalert = '';
                                                                } else {
                                                                    $learnlink = 'javascript:void(0);';
                                                                    $learnalert = 'alertswalpretest();';
                                                                }
                                                            } else {
                                                                $learnlink = 'javascript:void(0);';
                                                                $learnalert = 'alertswal();';
                                                            }
                                                            $learnFiles = Helpers::lib()->checkLessonFile($les, $learnModel->learn_id);
                                                            if ($learnFiles == "notLearn") {
                                                                $statusValue = '<span class="label label-default" >' . $label->label_notLearn . '</span>';
                                                            } else if ($learnFiles == "learning") {
                                                                $statusValue = '<span class="label label-warning" >' . $label->label_learning . '</span>';
                                                            } else if ($learnFiles == "pass") {
                                                                $statusValue = '<span class="label label-success" >' . $label->label_learnPass . '</span>';
                                                            }
                                                        ?>
                                                            <div class="stepcoursediv">
                                                                <div> <span class="stepcourse"><?php echo $label->label_step; ?> <?= $idx++; ?> </span><?php echo $label->label_gotoLesson; ?>
                                                                </div>
                                                            </div>
                                                            <a href="<?= $learnlink ?>" <?= $learnalert != '' ? 'onclick="' . $learnalert . '"' : ''; ?>>
                                                                <li class="list-group-item ">
                                                                    <?php if ($step == 2) { ?>
                                                                        <!-- <div class="pt-now"> You are here</div> -->
                                                                    <?php } ?>
                                                                    <span class="pull-right">
                                                                        <span id="lblduration-<?= $les->id ?>"></span> <span class="btn btn-warning detailmore"><?php echo $label->label_gotoLesson; ?> <i class="fa fa-play-circle"></i> </span></span>
                                                                    <span class="list__course"><?= $les->getRefileName(); ?></span>&nbsp;<?= $statusValue ?>
                                                                    <!-- <div class="hidden">
                                                                                                    <video id="video_player<?= $les->id ?>" width="320" height="240" controls>
                                                                                                        <source src="<?php //echo $uploadFolder . $les->filename;
                                                                                                                        ?>" type="video/mp4">
                                                                                                        </video>
                                                                                                        <div id="meta"></div>   
                                                                                                    </div> -->
                                                                </li>
                                                            </a>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($checkPostTest) {
                                                        $isPostTest = Helpers::isPosttestState($lessonListValue->id,$gen_id);
                                                        if ($isPostTest) {
                                                            if ($lessonStatus != 'pass') {
                                                                $link = 'javascript:void(0);';
                                                                $alert = 'alertswal();';
                                                            } elseif ($lessonStatus == 'pass' && $can_next_step != 2) {
                                                                $link = $this->createUrl('question/preexams', array('id' => $lessonListValue->id,'gen'=>$gen_id, 'type' => 'post'));
                                                                $alert = '';
                                                            } else {
                                                                $link = 'javascript:void(0);';
                                                                $alert = 'alertswal();';
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
                                                            $criteriaScoreAll->condition = ' type = "post" AND lesson_id="' . $lessonListValue->id . '" AND user_id="' . Yii::app()->user->id . '" and active = "y"' . " AND gen_id='" . $gen_id . "'";
                                                            $scoreAll = Score::model()->findAll($criteriaScoreAll);
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
                                                                $postStatus = Helpers::lib()->CheckTestAll($lessonListValue, "post", $scorePost);


                                                                $CheckPreTestAnsTextAreaLessonPost = Helpers::lib()->CheckPreTestAnsTextAreaLesson($lessonListValue, "post",$scorePost->score_id);

                                                                if ($CheckPreTestAnsTextAreaLessonPost) {
                                                                   
                                                            ?>

                                                                    <li class="list-group-item">
                                                                        <?php if($course->hidden_score == "y") { ?>
                                                                            <?php echo $label->label_resultTestPost; ?> <?= $keys + 1 ?>
                                                                            <span class="pull-right prepost text-warning">  
                                                                                <?= $langId == 1 ? "Pending check" : "รอตรวจคำตอบ"  ?>
                                                                            </span>
                                                                        <?php }else { ?>
                                                                            <?php echo $label->label_resultTestPost; ?> <?= $keys + 1 ?><span class="pull-right <?= $colorText ?> prepost"><?= $postStatus->value['score']; ?>/<?= $postStatus->value['total']; ?> <?php echo $label->label_point; ?></span>
                                                                        <?php } ?>
                                                                    </li>
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
                                                                $link = $this->createUrl('question/preexams', array('id' => $lessonListValue->id,'gen'=>$gen_id, 'type' => 'post'));
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
                                                        <!-- <li class="list-group-item">ไม่มีข้อสอบหลังเรียน</li> -->
                                                    <?php } ?>
                                                    <!--                                                        <li class="list-group-item">แบบทดสอบ <?= $lessonListValue->id ?> <span class="pull-right"><a href="<?php echo $this->createUrl('/quiz/preexams', array('id' => $lessonListValue->id,'gen'=>$gen_id)); ?>" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ทำแบบทดสอบ</a></span></li>-->

                                                    <?php
                                                    if ($lessonListValue->header_id) {

                                                        if ($checkPostTest) { //ถ้ามีข้อสอบหลังเรียน
                                                            if ($isPostTest) { //ถ้ายังไม่ทำข้อสอบ
                                                                $link_questionnair = 'javascript:void(0);';
                                                                $alert_questionnair = 'alertswal_test();';
                                                            } elseif ($isPostTest && $can_next_step != 2) { //ถ้าทำข้อสอบแล้ว
                                                                $link_questionnair = $this->createUrl('questionnaire/index', array('id' => $lessonListValue->id));
                                                                $alert_questionnair = '';
                                                            } else {
                                                                $link_questionnair = 'javascript:void(0);';
                                                                $alert_questionnair = 'alertswal_test();';
                                                            }
                                                        } else { //ถ้าไม่มีสอบหลังเรียน
                                                            $isLearnPass = Helpers::checkLessonPass($lessonListValue);
                                                            if ($isLearnPass != 'pass') { //ถ้าเรียนยังไม่ผ่าน
                                                                $link_questionnair = 'javascript:void(0);';
                                                                $alert_questionnair = 'alertswal();';
                                                            } elseif ($isLearnPass == 'pass' && $can_next_step != 2) { //ถ้าเรียนผ่านแล้ว
                                                                $link_questionnair = $this->createUrl('questionnaire/index', array('id' => $lessonListValue->id));
                                                                $alert_questionnair = '';
                                                            } else {
                                                                $link_questionnair = 'javascript:void(0);';
                                                                $alert_questionnair = 'alertswal();';
                                                            }
                                                        }
                                                        $lessonQuestionAns = Helpers::lib()->checkLessonQuestion($lessonListValue);
                                                    ?>
                                                        <div class="stepcoursediv">
                                                            <div> <span class="stepcourse"><?php echo $label->label_step; ?> <?= $idx++; ?> </span><?php echo $label->label_survey; ?></div>
                                                        </div>
                                                        <li class="list-group-item">
                                                            
                                                            <?php echo $label->label_questionnaire; ?>
                                                            <span class="pull-right">
                                                                <?php if (!$lessonQuestionAns) { ?>
                                                                    <a href="<?php echo $link_questionnair ?>" <?= $alert_questionnair != '' ? 'onclick="' . $alert_questionnair . '"' : ''; ?> class="btn btn-warning">
                                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $label->label_Doquestionnaire; ?></a>
                                                                <?php } else { ?>
                                                                    <a class="btn btn-warning detailmore" href="javascript:void(0)" data-toggle="collapse" data-target="#collapseSurvay"> <?php echo $label->label_detailSurvey; ?></a>
                                                                <?php } ?>
                                                            </span>
                                                        </li>
                                                        <div class="panel-collapse collapse " id="collapseSurvay" role="tabpanel" aria-labelledby="headingOne">
                                                            <ul class="list-group">
                                                                <?php
                                                                if ($lessonQuestionAns) {
                                                                    $titleArray = array(
                                                                        '1' => '1',
                                                                        '2' => '2',
                                                                        '3' => '3',
                                                                        '4' => '4',
                                                                        '5' => '5',
                                                                    );
                                                                ?>
                                                                    <!-- <div class="panel-collapse collapse" id="showAnswerPanel_<?= $surveyCnt ?>" role="tabpanel" aria-labelledby="headingOne"> -->
                                                                    <div class="stepcoursediv"><span class="stepcourse"><?php echo $label->label_surveyName; ?> <?php echo $lessonListValue->header->survey_name ?></span> </div>
                                                                    <div class="box-content-body panel-body">
                                                                        <?php
                                                                        $currentQuestionaire = QSection::model()->findByAttributes(array('survey_header_id' => $lessonListValue->header_id));
                                                                        if (isset($currentQuestionaire)) {
                                                                        ?>
                                                                            <div class="box-content-body">
                                                                                <h4><?php echo $label->label_headerSurvey; ?> <?= $currentQuestionaire->section_title ?></h4>
                                                                            </div>
                                                                            <div class="box-content-body panel-body">
                                                                                <?php
                                                                                if (isset($currentQuestionaire->questions)) {
                                                                                    foreach ($currentQuestionaire->questions as $keys => $QQuestion) {
                                                                                        if ($QQuestion->input_type_id == 5 || $QQuestion->input_type_id == 1) {
                                                                                            echo ($keys + 1) . '. ' . $QQuestion->question_name;
                                                                                            echo '<ul>';
                                                                                            foreach ($QQuestion->choices as $QChoices) {
                                                                                                $currentAnswer = QAnswers::model()->find(array(
                                                                                                    'condition' => 'user_id = "' . Yii::app()->user->id . '" AND choice_id ="' . $QChoices->option_choice_id . '" AND quest_ans_id ="' . $lessonQuestionAns->id . '"' . " AND gen_id='" . $gen_id . "'",
                                                                                                ));

                                                                                                if ($currentAnswer->choice_id == $QChoices->option_choice_id) {
                                                                                                    echo '<li>';
                                                                                                    if ($QQuestion->input_type_id == 1) {
                                                                                                        echo $currentAnswer->answer_text;
                                                                                                    } else {
                                                                                                        echo $currentAnswer->answer_textarea;
                                                                                                    }
                                                                                                    echo ' </li>';
                                                                                                }
                                                                                            }
                                                                                            echo '</ul>';
                                                                                        } else if ($QQuestion->input_type_id == 2 || $QQuestion->input_type_id == 3) {
                                                                                            echo ($keys + 1) . '. ' . $QQuestion->question_name;
                                                                                            echo '<ul>';
                                                                                            foreach ($QQuestion->choices as $QChoices) {
                                                                                                $currentAnswer = QAnswers::model()->find(array(
                                                                                                    'condition' => 'user_id = "' . Yii::app()->user->id . '" AND choice_id ="' . $QChoices->option_choice_id . '" AND quest_ans_id ="' . $lessonQuestionAns->id . '"' . " AND gen_id='" . $gen_id . "'",
                                                                                                ));

                                                                                                if ($currentAnswer->choice_id == $QChoices->option_choice_id) {
                                                                                                    echo '<li>';
                                                                                                    echo $QChoices->option_choice_name;
                                                                                                    echo ' </li>';
                                                                                                }
                                                                                            }
                                                                                            echo '</ul>';
                                                                                        } else { ?>
                                                                                            <?= ($keys + 1) . '. ' . $QQuestion->question_name; ?>
                                                                                            <table class="table table-bordered">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <td style="vertical-align: middle;" class="left padleft" rowspan="2"><?= $QQuestion->question_name ?></td>

                                                                                                        <td class="center" <?= ($QQuestion->question_range) ? 'colspan="' . $QQuestion->question_range . '"' : null ?>><?php echo  $label->label_SatisfactionLv; ?></td>
                                                                                                    </tr>
                                                                                                    <tr class="info">
                                                                                                        <?php
                                                                                                        if ($QQuestion->question_range > 0) {
                                                                                                            $j = 5;
                                                                                                            for ($i = 1; $i <= $QQuestion->question_range; $i++) {
                                                                                                        ?>
                                                                                                                <td class="center padleft" style="width: 75px;"><?= $titleArray[$j] ?></td>
                                                                                                        <?php
                                                                                                                $j--;
                                                                                                            }
                                                                                                        }
                                                                                                        ?>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <?php
                                                                                                if ($QQuestion->choices) {
                                                                                                    foreach ($QQuestion->choices as $QChoices) {
                                                                                                        // $currentAnswer
                                                                                                        $currentAnswer = QAnswers::model()->find(array(
                                                                                                            'condition' => 'user_id = "' . Yii::app()->user->id . '" AND choice_id ="' . $QChoices->option_choice_id . '" AND quest_ans_id ="' . $lessonQuestionAns->id . '"' . " AND gen_id='" . $gen_id . "'",
                                                                                                        ));
                                                                                                ?>
                                                                                                        <tr>
                                                                                                            <td><?= $QChoices->option_choice_name ?></td>
                                                                                                            <?php
                                                                                                            if ($QQuestion->question_range > 0) {
                                                                                                                $j = 5;
                                                                                                                for ($i = 1; $i <= $QQuestion->question_range; $i++) {
                                                                                                            ?>
                                                                                                                    <td class="center"><input type="radio" disabled <?= ($currentAnswer->answer_numeric == $j) ? 'checked' : null ?> /></td>
                                                                                                            <?php
                                                                                                                    $j--;
                                                                                                                }
                                                                                                            }

                                                                                                            ?>
                                                                                                        </tr>
                                                                                                <?php
                                                                                                    }
                                                                                                }
                                                                                                ?>
                                                                                            </table>
                                                                                <?php
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <!-- </div> -->
                                                                <?php
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                    <?php
                                                    }
                                                    if ($lessonListValue->fileDocs) :
                                                    ?>
                                                        <div class="stepcoursediv">
                                                            <div> <span class="stepcourse"><?php echo $label->label_DocsDowload; ?> </span></div>
                                                        </div>
                                                        <?php foreach ($lessonListValue->fileDocs as $filesDoc => $doc) {
                                                            if ($isChecklesson && $can_next_step != 2) {
                                                                $linkDownload =  $this->createUrl('/course/download', array('id' => $doc->id));
                                                                $onClickDownload =  '';
                                                            } else {
                                                                $linkDownload =  'javascript:void(0);';
                                                                $onClickDownload =  'onclick="alertSequence();"';
                                                            }
                                                        ?>
                                                            <li class="list-group-item "><a href="<?= $linkDownload; ?>"> <span class="list-course-number"><?= $filesDoc + 1 ?>. </span> <span class="list__course"><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: #ee0f10;"></i>&nbsp;&nbsp;<?= $doc->getRefileName() ?></span> <span class="pull-right"><i class="fa fa-download"></i> <?php echo  $label->label_download; ?></span></a></li>
                                                    <?php
                                                        }
                                                    endif;
                                                    ?>


                                                    </ul>
                                            </div>
                                        <?php } ?>

                                        <!-- Course question  -->
                                        <?php
                                        $ckPassAll = true;
                                        foreach ($lessonList as $key => $value) {
                                            $state = Helpers::lib()->CheckPostTestAll($value,$gen_id);
                                            if (!$state) {
                                                $ckPassAll = false;
                                            }
                                            // var_dump($state);
                                        }
                                        $criteria = new CDbCriteria;
                                        $criteria->condition = ' course_id="' . $course->course_id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL AND active="y"' . " AND gen_id='" . $gen_id . "'" . ' AND type="post"';
                                        $criteria->order = 'create_date ASC';
                                        $BestFinalTestScore = Coursescore::model()->findAll($criteria);
                                        $checkCourseTest = Helpers::lib()->checkCoursePass($course->course_id,$gen_id); //Chekc Lesson all pass to test course exam
                                        $checkHaveCourseTest = Helpers::lib()->checkHaveCourseTestInManage($course->course_id);
                                        $CourseSurvey = CourseTeacher::model()->findAllByAttributes(array('course_id' => $course->course_id));
                                        ?>
                                        <?php
                                        if ($checkHaveCourseTest) {
                                            // var_dump($checkHaveCourseTest);
                                            // var_dump($checkCourseTest);
                                            // var_dump(count($BestFinalTestScore));
                                            // var_dump($course->cate_amount);
                                            // var_dump($ckPassAll);
                                            // var_dump($can_next_step);
                                            // $checkCourseTest = 'pass';
                                            if ($checkCourseTest == 'pass' && count($BestFinalTestScore) < $course->cate_amount && $ckPassAll && $can_next_step != 2) { //มีสิทธิสอบและยังสามารถสอบได้อีก
                                                $pathCourseTest = $this->createUrl('coursequestion/preexams', array('id' => $course->course_id,'gen'=>$gen_id, 'type' => 'course'));
                                                $alertCourseTest = '';
                                            } else {
                                                $pathCourseTest = 'javascript:void(0);';
                                                $alertCourseTest = 'onclick="alertswalCourse()"';
                                            }
                                        } else {
                                            $pathCourseTest = 'javascript:void(0);';
                                            $alertCourseTest = 'onclick="alertswalNoCourse()"';
                                        }
                                        // var_dump($checkCourseTest);
                                        ?>
                                        <!-- || $CourseSurvey -->
                                        <?php if ($checkHaveCourseTest) {?>
                                            
                                            <div class="panel-heading headcourse final-test">
                                                <a role="button" data-toggle="collapse" data-target="#collapseFinal<?= $key ?>" data-parent="#accordion" aria-expanded="true">
                                                    <li>
                                                        <span class="stepcourse"> <?= $checkHaveCourseTest ? $final : ''; ?> <?= $checkHaveCourseTest && $CourseSurvey ? '&' : ''; ?> <?= $CourseSurvey ? $Questionnaire : '' ?><?= $course->course_title ?> <?= $course->getGenName($gen_id); ?></span>
                                                        <span class="pull-right"><i class="fa fa-angle-down"></i></span>
                                                    </li>
                                                </a>
                                            </div>
                                        <?php } ?>
                                        
                                        <?php $CheckPreTestAnsTextAreaCoursePost = Helpers::lib()->CheckPreTestAnsTextAreaCourse($_GET['id'], "post");

                                        // var_dump($CheckPreTestAnsTextAreaCoursePost); exit();
                                        ?>

                                        <?php //var_dump($BestFinalTestScore); exit(); 
                                        ?>

                                        <!-- Check count test -->
                                        <div id="collapseFinal<?= $key ?>">
                                            <?php if ($BestFinalTestScore) {  ?>
                                                <?php foreach ($BestFinalTestScore as $key => $course_score) { ?>
                                                    <?php //$CheckPreTestAnsTextAreaCoursePost = Helpers::lib()->CheckPreTestAnsTextAreaCourse($course->course_id, "post"); 
                                                    ?>

                                                    <?php if (count($BestFinalTestScore) < $course->cate_amount) { ?>
                                                        <?php if ($course_score->score_past == 'n') {
                                                            //อาจจะยังไม่ตรวจ หรือ ตรวจแล้ว แต่คะแนนไม่ผ่าน
                                                        ?>
                                                            <?php
                                                            if ($CheckPreTestAnsTextAreaCoursePost) {
                                                            ?>
                                                                <li class="list-group-item ">
                                                                    <?php if($course->hidden_score == "y") { ?>
                                                                            <?= $label->label_resultFinal; ?> <?= $key + 1; ?><span class="pull-right prepost text-warning">  
                                                                                        <?= $langId == 1 ? "Pending check" : "รอตรวจคำตอบ"  ?>
                                                                                    </span>
                                                                    <?php }else{ ?>
                                                                        <a href="javascript:void(0);"><span class="list__course"><?= $label->label_resultFinal; ?> <?= $key + 1; ?></span>
                                                                            <span class="pull-right  text-danger prepost">
                                                                                <?= $course_score->score_number ?>/<?= $course_score->score_total ?>
                                                                                <?= $label->label_point; ?>
                                                                            </span>
                                                                        </a>
                                                                    <?php } ?>
                                                                </li>
                                                            <?php
                                                            } else {
                                                                $course_wait_cer = 2;
                                                            ?>
                                                                <li class="list-group-item ">
                                                                    <a href="javascript:void(0);"><span class="list__course"><?= $label->label_resultFinal; ?> <?= $key + 1; ?></span>
                                                                        <span class="pull-right  text-danger prepost"> <?= $label->label_course_wait; ?>
                                                                            <!-- 888 -->
                                                                        </span></a>
                                                                </li>

                                                            <?php
                                                            }
                                                            ?>
                                                        <?php } else { ?>
                                                            <?php
                                                            $logcourseques = Courselogques::model()->find("score_id='" . $course_score->score_id . "' ");

                                                            // ตรวจแล้ว แต่ยังไม่ยืนยัน คะแนนผ่าน
                                                            if (($logcourseques->confirm == 1 && $logcourseques->check == 1 && $logcourseques->ques_type == 3) || ($logcourseques->ques_type != 3)) {
                                                            ?>
                                                                <li class="list-group-item ">
                                                                    <?php if($course->hidden_score == "y") { ?>
                                                                        <?= $label->label_resultFinal; ?> <?= $key + 1; ?><span class="pull-right prepost text-warning">  
                                                                                    <?= $langId == 1 ? "Pending check" : "รอตรวจคำตอบ"  ?>
                                                                                </span>
                                                                    <?php }else{ ?>
                                                                        <a href="javascript:void(0);"><span class="list__course"><?= $label->label_resultFinal; ?> <?= $key + 1; ?></span>
                                                                        <span class="pull-right  <?php if ($course_score->score_past == "y") {
                                                                                                        echo "text-success";
                                                                                                    } else {
                                                                                                        echo "text-danger";
                                                                                                    } ?> prepost"> <?= $course_score->score_number ?>/<?= $course_score->score_total ?> <?= $label->label_point; ?></span></a>

                                                                    <?php } ?>
                                                                </li>
                                                            <?php
                                                            } else {
                                                                $course_wait_cer = 2;
                                                            ?>
                                                                <li class="list-group-item ">
                                                                    <a href="javascript:void(0);"><span class="list__course"><?= $label->label_resultFinal; ?> <?= $key + 1; ?></span>
                                                                        <span class="pull-right  <?php if ($course_score->score_past == "y") {
                                                                                                        echo "text-success";
                                                                                                    } else {
                                                                                                        echo "text-danger";
                                                                                                    } ?> prepost"> <?= $label->label_course_wait; ?>
                                                                            <!-- 999 -->
                                                                        </span></a>
                                                                </li>
                                                            <?php
                                                            }
                                                            ?>
                                                        <?php } ?>
                                                        <?php } else {
                                                        // สอบครบจำนวนแล้ว
                                                        if ($CheckPreTestAnsTextAreaCoursePost) {
                                                        ?>
                                                            <li class="list-group-item ">
                                                                <a href="javascript:void(0);"><span class="list__course"><?= $label->label_resultFinal; ?> <?= $key + 1; ?></span>
                                                              
                                                                    <?php if($course->hidden_score == "y") { ?>
                                                                        <span class="pull-right prepost text-warning">  
                                                                            <?= $langId == 1 ? "Pending check" : "รอตรวจคำตอบ"  ?>
                                                                        </span>
                                                                    <?php }else{ ?>
                                                                        <span class="pull-right
                                                                            <?php if ($course_score->score_past == "y") {
                                                                                echo "text-success";
                                                                            } else {
                                                                                echo "text-danger";
                                                                            } ?> prepost"> <?= $course_score->score_number ?>/<?= $course_score->score_total ?> <?= $label->label_point; ?>
                                                                         </span>
                                                                    <?php } ?>
                                                                  

                                                                 
                                                                </a>
                                                            </li>
                                                        <?php
                                                        } else {
                                                            $course_wait_cer = 2;
                                                        ?>
                                                            <li class="list-group-item ">
                                                                <a href="javascript:void(0);"><span class="list__course"><?= $label->label_resultFinal; ?> <?= $key + 1; ?></span>
                                                                    <span class="pull-right  <?php if ($course_score->score_past == "y") {
                                                                                                    echo "text-success";
                                                                                                } else {
                                                                                                    echo "text-danger";
                                                                                                } ?> prepost"> <?= $label->label_course_wait; ?>
                                                                        <!-- 000 -->
                                                                    </span></a>
                                                            </li>
                                                        <?php
                                                        }
                                                        ?>


                                                    <?php } ?>
                                                <?php } ?>


                                                <?php if ($step == 4) { ?>
                                                    <!-- <li class="list-group-item "> -->
                                                    <!-- <div class="pt-now"> You are here</div> -->
                                                    <!-- <a href="<?= $pathCourseTest ?>" <?= $alertCourseTest ?> >
                                                        <span class="list__course"><?= $label->label_testFinalTimes; ?> <?= $key + 2; ?></span>
                                                        <span class="btn btn-warning detailmore pull-right"><?= $label->label_gotoLesson ?>
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>
                                                    </li> -->
                                                <?php } ?>


                                            <?php } // if($BestFinalTestScore 

                                            $criteria = new CDbCriteria;
                                            $criteria->condition = ' course_id="' . $course->course_id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL AND score_past="y" AND active="y"' . " AND gen_id='" . $gen_id . "'" . ' AND type="post"';
                                            $criteria->order = 'create_date ASC';
                                            $BestFinalTestScore_pass = Coursescore::model()->findAll($criteria);

                                            // && empty($BestFinalTestScore_pass) ตัวบอกว่า ไม่มีคะแนนสอบ
                                          
                                            if ($checkHaveCourseTest && $CheckPreTestAnsTextAreaCoursePost == true && count($BestFinalTestScore) < $course->cate_amount && empty($BestFinalTestScore_pass)) { ?>
                                               <li class="list-group-item ">
                                                    <?php if ($step == 4) { ?>
                                                        <!-- <div class="pt-now"> You are here</div> -->
                                                    <?php } ?>
                                                    <a href="<?= $pathCourseTest ?>" <?= $alertCourseTest ?>>
                                                        <span class="list__course"><?= $label->label_testFinalTimes; ?> <?= count($BestFinalTestScore) + 1; ?></span>
                                                        <!-- <span class="list__course"><?= $label->label_testFinalTimes; ?> <?= $key + 2; ?>5555</span> -->
                                                        <span class="btn btn-warning detailmore pull-right"><?= $clickFinal ?>
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i></span></a>
                                                </li>
                                            <?php } ?>


                                            <!-- end Course question  -->
                                            <?php
                                            $PaQuest = false;
                                            if ($CourseSurvey) {
                                                $passQuest = QQuestAns_course::model()->find(array(
                                                    'condition' => 'user_id = "' . Yii::app()->user->id . '" AND course_id ="' . $course->course_id . '"' . " AND gen_id='" . $gen_id . "'",
                                                ));
                                                $countSurvey = count($passQuest);
                                                if ($passQuest) {
                                                    $PaQuest = true;
                                                }
                                            } else {
                                                $PaQuest = true;
                                            }
                                            if ($checkCourseTest == 'pass') { //Lesson All pass
                                                if ($checkHaveCourseTest) {
                                                    $criteria = new CDbCriteria;
                                                    $criteria->compare('course_id', $course->course_id);
                                                    $criteria->compare('gen_id', $gen_id);
                                                    $criteria->compare('type', "post");
                                                    $criteria->compare('user_id', Yii::app()->user->id);
                                                    $criteria->compare('score_past', 'y');
                                                    $criteria->compare('active', 'y');
                                                    $criteria->order = 'score_id';
                                                    $courseScorePass = Coursescore::model()->findAll($criteria);
                                                    if ($courseScorePass) {
                                                        if ($PaQuest) { //ทำแบบสอบถามแล้ว
                                                            $step = 0;
                                                            $pathSurvey = $this->createUrl('course/questionnaire', array('id' => $course->course_id,'gen'=>$gen_id));
                                                        } else {
                                                            $pathSurvey = $this->createUrl('questionnaire_course/index', array('id' => $CourseSurvey[0]->id,'gen'=>$gen_id));
                                                        }
                                                    } else { //ยังทำแบบทดสอบหลักสูตรไม่ผ่าน
                                                        $pathSurvey = 'javascript:void(0);';
                                                        $alrtSurvey = 'onclick="alertswalCourse()"';
                                                    }
                                                } else {
                                                    if ($PaQuest) { //ทำแบบสอบถามแล้ว
                                                        $step = 0;
                                                        $pathSurvey = $this->createUrl('course/questionnaire', array('id' => $course->course_id,'gen'=>$gen_id));
                                                    } else {
                                                        $pathSurvey = $this->createUrl('questionnaire_course/index', array('id' => $CourseSurvey[0]->id,'gen'=>$gen_id));
                                                    }
                                                }
                                            } else {
                                                $pathSurvey = 'javascript:void(0);';
                                                $alrtSurvey = 'onclick="alertswalCourse()"';
                                            }


                                            ?>


                                        </div>

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

<div class="modal fade" id="course-uploadfile" tabindex="-1" role="dialog" aria-labelledby="course-uploadfile">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">แนบเอกสารหลักสูตร</h4>
            </div>
            <div class="modal-body body-pay">

                <form action="<?php echo $this->createUrl('course/courseuploaddocument') ?>" id="frmsavedocument" name="frmsavedocument" method="post" class="needs-validation" enctype="multipart/form-data">
                    <p class="text-danger">
                        <i class="fa fa-info-circle"></i> เอกสารที่แนบ : <?= isset($note) ? $note->note : '-' ;?>
                    </p>
                    <input type="hidden" name="course_id" value="<?= $course->course_id ?>">
                    <input type="hidden" name="gen" value="<?= $gen_id ?>">
                    <div class="row">
                        <!-- form เก่า -->
                        <div class="col-sm-12">
                            <!-- <div class="pay-course">
                                <h4>เอกสารแนบ </h4>
                                <input type="file" multiple name="file_document[]" accept="image/png , image/jpg , image/jpeg , application/pdf" id="file_document" class="form-control" style="height:40px;">
                            </div> -->
                        </div>
                        <!-- form เก่า -->

                        <!-- form html ใหม่  -->
                        <div class="col-sm-12">
                            <div id="documentattch">
                                <!-- <div class="pay-course" id="row1">
                                 
                                    <label for="txt1" class="txtFile"> เอกสารแนบที่ 1</label>
                                    <div class='flex-upload'>
                                        <input type='file' name='file_document[]' accept='image/png , image/jpg , image/jpeg , application/pdf' class='form-control upload-h40' size='20' name='txt[]'>
                                        &nbsp;
                                        <a href='#' class='btn-remove btn'> ลบ</a>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <!-- form html ใหม่  -->

                        <!-- form fuction เพิ่มลบได้   -->
                        <div class="col-sm-12">
                            <input type="hidden" id="document-group" value="1">
                           
                        </div>
                        <div class="col-sm-12">
                            <a href="#" class="btn btn-add" onClick="addFormField(); return false;"><i class="fas fa-plus"></i> เพิ่มเอกสาร</a>
                        </div>
                        <!-- form fuction เพิ่มลบได้   -->

                </form>

                <script>
                <?php if (count($courseDocument) > 0){?>
                            filesToField();
                <?php }else{ ?>
                            addFormField();
                <?php } ?>
                
                    async function filesToField(){
                         var numItems = <?= count($courseDocument)?>;
                         if(numItems > 1){
                            <?php foreach ($courseDocument as $keyfile => $file) { ?>
                                        addFormField();
                             <?php } ?>
                         }else{
                            addFormField();
                         }
                     
                        await addFileToField()
                    }

                    function addFileToField(){
                        var numItems = <?= count($courseDocument)?>;
                        var values = $("input[name='file_document[]']")
                            .map(function(){return $(this).val();}).get();
                        values = values.filter(i => i != '');
                        <?php foreach ($courseDocument as $keyfile => $file) { ?>
                                    var fileInput = document.querySelectorAll('input[name="file_document[]"]')[<?= $keyfile ?>];
                                    var detail = $("<a id='detailFile"+<?=$keyfile+1?>+"' target='_blank' href='<?= Yii::app()->baseUrl ?>/uploads/coursedocument/<?= $course->course_id ?>/<?= Yii::app()->user->id ?>/<?= $file->file_address ?>' class='btn-primary btn'><i class='fa fa-search' aria-hidden='true'></i></a> &nbsp;").insertAfter(fileInput);
                                    $("<input type='hidden' id='fileId"+<?=$keyfile+1?>+"' name='fileId[]' value='"+'<?= $file->id.'-'.$file->file_name ?>'+"'>").insertAfter(detail);
                                    
                                    var txtFile = $("#row"+<?= $keyfile+1 ?>+" > .txtFile");
                                    <?php if ($file->confirm_status == 'y') { ?>
                                        $("<span id='statusupload' class='text-success'>&nbsp;&nbsp;(อนุมัติ)</span>").insertAfter(txtFile);
                                    <?php } else if($file->confirm_status == 'n') { ?>
                                        $("<span id='statusupload' class='text-warning'>&nbsp;&nbsp;(รอการตรวจสอบ)</span>").insertAfter(txtFile);
                                    <?php } else if($file->confirm_status == 'x')  { ?>
                                        $("<span id='statusupload' class='text-danger'>&nbsp;&nbsp;(ไม่อนุมัติ)</span>").insertAfter(txtFile);
                                    <?php } ?>

                                    // Create a new File object
                                    var myFile = new File(['Hello World!'], "<?= $file->file_name ?>", {
                                        name:'test',
                                        lastModified: new Date(),
                                    });

                                    // Now let's create a FileList
                                    var dataTransfer = new DataTransfer();
                                    dataTransfer.items.add(myFile);
                                    fileInput.files = dataTransfer.files;
                                    // Help Safari out
                                    if (fileInput.webkitEntries.length) {
                                        fileInput.dataset.file = `${dataTransfer.files[0].name}`;
                                    }
                        <?php } ?>
                    }
                
                    function addFormField() {
                        // // var id = document.getElementById("document-group").value;
                        var id = $( ".txtFile" ).length+1;
                        $("#documentattch").append(
                            "<div class='pay-course' id='row" +
                            id +
                            "'><label for='txt" +
                            id +
                            "'class='txtFile'>เอกสารแนบที่ " +
                            id +'</label>'+
                            "<div class='flex-upload'><input onchange='changeOldFile(\"" +id+"\")' type='file' name='file_document[]' accept='image/png , image/jpg , image/jpeg , application/pdf' class='upload-h40 form-control' size='20' name='txt[]' id='txt" +
                            id +
                            "'>&nbsp;&nbsp<a href='#' class='btn-remove btn' onClick='removeFormField(\"#row" +
                            id +
                            "\"); return false;'>ลบ</a></div><div>"
                        );
                        // id = id - 1 + 2;
                        // document.getElementById("document-group").value = id;
                    }

                    async function removeFormField(id) {
                        $(id).remove();
                        await resetTxtFile();
                    }

                    function resetTxtFile(){
                        var id = 0;
                        $("#documentattch > .pay-course").each(function (i)
                        {    
                            id = i+1;
                            $(this).attr("id","row"+id);
                            $(this).find( ".txtFile" ).attr("for","txt"+id);
                            $(this).find( ".txtFile" ).text("เอกสารแนบที่ "+id);
                        });
                    }

                    function changeOldFile(id){
                        var detail = '#detailFile'+id;
                        var file = '#fileId'+id;
                        if ($(detail).length ) {
                            $(detail).remove();
                        }
                        $('#statusupload').remove();

                        if ($(file).length ) {
                            id = id - 1;
                            const myFileArray = $(file).val().split("-");
                            var filename = $('input[name="file_document[]"]').eq(id).val().split('\\').pop();
                            $(file).val(myFileArray[0]+'-'+filename);
                        }
                    }
                </script>

            </div>
            <hr>
            <button type="button" onclick="myupload()" id="b3" class="btn btn-booking">อัพโหลดเอกสาร</button>
            <!-- start หมายเหตุขึ้นบอกสถานะ เมื่ิอเจ้าหน้าที่กดสถานะไม่ผ่าน -->
            <?php if($courseTemp->status_document == 'x'){?>
                <div class="text-danger"><i class="fas fa-times-circle"></i>&nbsp;หมายเหตุ : <?= isset($courseTemp->note_document)? $courseTemp->note_document : 'เอกสารไม่ผ่าน - ไม่มีรายละเอียด' ?></div>
            <?php }?>
          
            <!-- end -->
        </div>
    </div>
</div>

<div class="modal fade" id="course-booking" tabindex="-1" role="dialog" aria-labelledby="course-booking">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">ชำระเงิน</h4>
            </div>
            <div class="modal-body body-pay">

                <form action="<?php echo $this->createUrl('course/bookingsave') ?>" id="frmsavepay" name="frmsavepay" method="post" class="needs-validation" enctype="multipart/form-data">

                    <div class="pay-course">
                        <h4>ธนาคารที่โอนเข้า</h4>
                        <?php
                        $modelbank = BankNameRelations::model()->findAll(array(
                            'condition' => 'course_id = "' . $course->course_id . '"'
                        ));
                        ?>

                        <?php foreach ($modelbank as $key => $valueb) {
                        ?>
                            <div class="row row-pay align-items-center">

                                <input type="radio" id="test-<?= $valueb->banks->id ?>" name="chkbank" class="custom-control-input custom" value="<?= $valueb->banks->id ?>">
                                <img class="mx-2" src="<?php echo Yii::app()->baseUrl; ?>/uploads/bank/<?= $valueb->banks->id ?>/<?= $valueb->banks->bank_images ?>" width="80" alt="">

                                <div class="account-bank">
                                    <h4 class="">ธนาคาร : <span class="text-main"><?= $valueb->banks->bank_name ?></span></h4>
                                    <h4 class="">ชื่อบัญชี : <span class="text-main"><?= $valueb->banks->account_name ?></span></h4>
                                    <h4 class="">หมายเลขบัญชี : <span class="text-main"><?= $valueb->banks->account_number ?></span></h4>

                                </div>

                            </div>
                        <?php } ?>
                    </div>

                    <input type="hidden" name="course_id" value="<?= $course->course_id ?>">

                    <div class="pay-course">
                        <div class="row">
                            <div class="col-lg-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">จำนวนเงินที่โอน</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="money" placeholder="">
                                        <div class="input-group-addon">บาท</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pay-course">
                        <div class="row">
                            <div class="col-lg-4 col-xs-12">
                                <div class="form-group">
                                    <label for="">วันเวลาที่โอน</label>
                                    <input type="datetime-local" class="form-control" name="date_slip" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pay-course">
                        <h4>อัพโหลดหลักฐานการชำระเงิน</h4>
                        <input type="file" name="file_payment" accept="image/*" id="file_payment" class="form-control" style="height:40px;">
                    </div>

                    <div class="pay-course">
                        <label for="">หมายเหตุ</label>
                        <textarea name="" id="" cols="30" rows="3" class="form-control"></textarea>
                    </div>

                    <?php if(isset($courseTemp->note_payment) || $courseTemp->status_payment == 'x'){?>
                            <div class="text-danger"><i class="fas fa-times-circle"></i>&nbsp;หมายเหตุ-ไม่ผ่านอนุมัติ : <?= isset($courseTemp->note_payment)? $courseTemp->note_payment : 'การชำระเงินไม่ผ่าน - ไม่มีรายละเอียด' ?></div>
                    <?php } ?>
                </form>

                <button type="button" onclick="mybooking('pay')" id="b3" class="btn btn-booking">ยืนยันการชำระเงิน</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="course-checkfile" tabindex="-1" role="dialog" aria-labelledby="course-checkfile">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">ตรวจสอบเอกสารหลักสูตร</h4>
            </div>
            <div class="modal-body body-pay">
                <div class="pay-course">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ลำดับ</th>
                                <th scope="col">ชื่อไฟล์เอกสาร</th>
                                <th scope="col">เอกสาร</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courseDocument as $keyfile => $file) { ?>

                                <tr>
                                    <th scope="row"><?= $keyfile + 1 ?></th>
                                    <td><?= $file->file_name ?></td>
                                    <td><a class="btn btn-primary" target="_blank" href="<?= Yii::app()->baseUrl ?>/uploads/coursedocument/<?= $course->course_id ?>/<?= Yii::app()->user->id ?>/<?= $file->file_address ?>">ตรวจสอบเอกสาร</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="showtime" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <?php
                $dateEndLearnUser = date('Y-m-d', strtotime($logtime->end_date));
                $dayCourseEnd = date('Y-m-d', strtotime($course->course_date_end));
                if ($dateEndLearnUser > $dayCourseEnd) {
                    $dateEndLearnUser = $dayCourseEnd;
                }
                ?>
                <center>
                    <i class="fas fa-exclamation-triangle" style="font-size:6em; color: #F8BB86; padding-top: 15px;padding-bottom: 15px;"></i>
                    <h2 style="color: #575757;"><?= $label->label_swal_regis ?></h2>
                    <h2><?= $label->label_course ?> "<?= $course->course_title ?> <?= $course->getGenName($gen_id); ?>" <?= $label->label_swal_success ?></h2>
                    <p><?php // echo $label->label_swal_alltimelearn 
                        ?>
                        <?php //echo  $course->course_day_learn 
                        ?>
                        <?php // echo $label->label_day 
                        ?></p>
                    <?php if (Yii::app()->user->id) { ?>
                        <p>
                            <?= $label->label_swal_since ?>

                            <?= Helpers::lib()->DateLangTms($course->course_date_start, Yii::app()->session['lang']) ?>
                            <?= $label->label_swal_to ?>

                            <?= Helpers::lib()->DateLangTms($course->course_date_end, Yii::app()->session['lang']) ?></p>



                        <p><?= $label->label_remaintime ?> <?= $diff ?> <?= $label->label_day ?></p>
                    <?php }  ?>

                    <div style="padding-top: 20px; padding-bottom: 20px;">
                        <button type="button" onclick="confirmModel(<?= $course->course_id ?>)" class="btn btn-success" data-dismiss="modal" style="padding: 15px 32px; height: auto"><?= Yii::app()->session['lang'] == 1 ? 'OK' : 'ตกลง' ?></button>
                    </div>
                </center>
            </div>
        </div>

    </div>
</div>
</section>
<script>
    function mybooking($type = null) {
        var cou_ti = "<?= $course->course_title ?>";
        Swal.fire({
            title: 'ยืนยันการชำระเงิน',
            text: cou_ti,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.value) {
                if ($type != null) {
                    console.log(document.getElementById("file_payment").files.length == 0);
                    if (document.getElementById("file_payment").files.length == 0) {
                        swal("กรุณาอัพโหลดหลักฐานการชำระเงิน", "", "error");
                        return false;
                    } else {
                        document.getElementById("frmsavepay").submit();
                    }
                }
            }
        })
    }

    function myupload() {
        const lengthFileField = $( ".txtFile" ).length;
        var values = $("input[name='file_document[]']")
              .map(function(){return $(this).val();}).get();
        values = values.filter(i => i != '');
        const lengthFileUpload =  values.length;

        if(lengthFileField == lengthFileUpload){
            var cou_ti = "<?= $course->course_title ?>";
                Swal.fire({
                title: 'ยืนยันการอัพโหลดเอกสาร',
                text: cou_ti,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
            }).then((result) => {
                if (result.value) {
                    document.getElementById("frmsavedocument").submit();
                }
            })
        }else{
            swal("อัพโหลดเอกสารไม่ครบ", "กรุณาอัพโหลดเอกสารอีกครั้ง", "warning");
        }



        // console.log($('#file_document').prop('files'));
  
  
        // if ($("#file_document")[0].files.length > 0) {
        //     var cou_ti = "<?= $course->course_title ?>";
        //     Swal.fire({
        //         title: 'ยืนยันการอัพโหลดเอกสาร',
        //         text: cou_ti,
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'ยืนยัน',
        //         cancelButtonText: 'ยกเลิก',
        //     }).then((result) => {
        //         if (result.value) {
        //             document.getElementById("frmsavedocument").submit();
        //         }
        //     })
        // } else {
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'กรุณาเลือกไฟล์เอกสาร',
        //         text: 'อย่างน้อย 1',
        //     })
        // }

    }

    <?php
    if (!empty($logtime) && empty($_SESSION["alertConfirm" . $course->course_id])) { ?>
        $(window).load(function() {

            $('#showtime').appendTo("body").modal('show');

        });
    <?php } ?>

    function confirmModel(id) {
        <?php
        session_start();
        $_SESSION["alertConfirm" . $course->course_id] = 'done';
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
        //   Swal.fire({
        //     icon: 'error',
        //     title: 'Oops...',
        //     text: 'Something went wrong!',
        //     footer: '<a href>Why do I have this issue?</a>'
        // })
    }

    function alertswalNocert() {
        swal('<?= $label->label_swal_warning ?>', 'หลักสูตรนี้ไม่มีใบประกาศนียบัตร กรุณาติดต่อผู้ดูแลระบบ', "error");
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

    function checkPermissionBeforeLearn(course, type) {
        $.post("<?= $this->createUrl("CourseStart/Permission") ?>", {
                course: course
            },
            function(respon) {
                // var jsonRespon = JSON.parse(respon);
                // if (type == '36') {
                //     if (jsonRespon.status) {
                //         switch (jsonRespon.status) {
                //             case 99:
                //             swal({

                //                 // title: '<?= $label->label_swal_warning ?>',
                //                 title: '<?= $label->label_course . ': ' . $course->course_title ?>',
                //                 text: jsonRespon.errormsg,
                //                 type: "warning",
                //                 showCancelButton: false,
                //                 confirmButtonColor: "#DD6B55",
                //                 confirmButtonText: '<?= $label->label_confirm ?>',
                //                 closeOnConfirm: false
                //             },
                //             function () {
                //                 showNotice(jsonRespon.coursetype);
                //             });
                //             break;
                //             case 1:
                //             swal({
                //                 title: '<?= $label->label_alert_welcome ?>',
                //                 text: jsonRespon.errormsg,
                //                 type: "success",
                //                 showCancelButton: false,
                //                 confirmButtonColor: "#DD6B55",
                //                 confirmButtonText: '<?= $label->label_confirm ?>',
                //                 closeOnConfirm: false
                //             },
                //             function () {
                //                 showNotice(jsonRespon.coursetype);
                //             });
                //             break;
                //         }
                //     }
                // } else {
                //     if (jsonRespon.status) {
                //         switch (jsonRespon.status) {
                //             case 99:
                //             swal({
                //                 title: '<?= $label->label_course . ': ' . $course->course_title ?>',
                //                 text: jsonRespon.errormsg,
                //                 type: "warning",
                //                 showCancelButton: false,
                //                 confirmButtonColor: "#DD6B55",
                //                 confirmButtonText: '<?= $label->label_confirm ?>',
                //                 closeOnConfirm: true
                //             },
                //             function () {
                //             });
                //             break;
                //             case 1:
                //             swal({
                //                 title: '<?= $label->label_alert_welcome ?>',
                //                 text: jsonRespon.errormsg,
                //                 type: "success",
                //                 showCancelButton: false,
                //                 confirmButtonColor: "#DD6B55",
                //                 confirmButtonText: '<?= $label->label_confirm ?>',
                //                 closeOnConfirm: true
                //             },
                //             function () {
                //             });
                //             break;
                //         }
                //     }
                // }
            }
        );
    }

    $(window).load(function() {
        // console.log($('#loader1'));
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
        //check permission and show pop-up
        checkPermissionBeforeLearn('<?= $course->course_id ?>', '<?= $course->cate_id ?>');

        /* jQueryKnob */

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

    // Start Step

    // End Step
    // function lang(){
    //   if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
    //     $leng = "Length";
    //     $min = "Minutes";
    //     this.getDuration($leng);
    // }else{  
    //     $leng = "ความยาว";
    //     $min = "นาที";
    // }
    // }
</script>


<script type="text/javascript">
    let arr = [];
</script>
<?php foreach ($lessonModel as $keyles => $lesjs) {
    foreach ($lesjs->files as $lesfiless) {
?>
        <script type="text/javascript">
            setTimeout(() => {
                var id_les = '<?= $lesfiless->id ?>';
                var myVideoPlayer = document.getElementById('video_player' + id_les);
                var duration = myVideoPlayer.duration;
                var time = '';

                if (!isNaN(duration)) {
                    var sec_num = parseInt(duration);

                    arr.push(sec_num);
                }
            }, 10000);
        </script>
<?php }
} ?>

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
            if (hours < 10) {
                hours = hours;
            }
            if (minutes < 10) {
                minutes = minutes;
            }
            if (seconds < 10) {
                seconds = seconds;
            }

            $(".pre-loading").hide();
            $(".LoaderNone").show();

            if (hours == 0) {
                $(".houHide").hide();
            }
            if (minutes == 0) {
                $(".minHide").hide();
            }
            if (seconds == 0) {
                $(".secHide").hide();
            }
            $(".houShow").html(hours);
            $(".minShow").html(minutes);
            $(".secShow").html(seconds);

        }, 2000);
    }, 11000);
</script>

<script>

    function alertLockDocument(){
        swal("ขณะนี้หลักสูตรกำลังถูกล็อค", "อัพโหลดเอกสารไม่ครบ กรุณาอัพโหลดเอกสารเพิ่มเติม", "warning");
    }

    function alertIncomDocuments(){
        swal("ไม่สามารถดาวน์โหลดได้", "เอกสารไม่ครบ หรือยังไม่ผ่านการอนุมัติ", "warning");
    }
</script>