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
if (empty(Yii::app()->session['lang'])) {
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
} else {
    $langId = Yii::app()->session['lang'];
    $flag = false;
}
if (Yii::app()->session['lang'] == 2) {
    $courseconfirm = "ยืนยันการจองหลักสูตร";
    $confirm = "ยืนยัน";
    $cancel = "ยกเลิก";
} else {
    $courseconfirm = "Course Confirmation";
    $confirm = "Confirm";
    $cancel = "Cancel";
}
?>

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
    $Contact = 'Contact';
    $txtShow["OnlineClassroom"] = 'Online classroom';
    $txtShow["Or"] = 'Or';
    $txtShow["ContactNumber"] = 'Contact Number';

    $txtShowPayment['Approve'] = "Approve";
    $txtShowPayment['Pending'] = "Pending";
    $txtShowPayment['PleasePay'] = "Please pay";
    $txtShowPayment['PleaseAttactDocument'] = "Please attach documents";
    $txtShowPayment['Disapproved'] = "Disapproved";
    $txtShowPayment['PaymentStatus'] = "Payment status";
    $txtShowPayment['DocumentStatus'] = "Document attachment status";
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
    $CourseInstructor = 'อาจารย์ผู้สอน';
    $CourseApprover = 'ผู้อนุมัติหลักสูตร';
    $Time = 'เวลา';
    $Lessons = 'บทเรียน';
    $CourseEvaluation = 'การประเมินผลหลักสูตร';
    $CourseCert = 'ใบประกาศนียบัตร';
    $Hr = 'ชั่วโมง';
    $Print = "พิมพ์";
    $Join = 'เข้าร่วม';
    $Contact = 'ช่องทางการติดต่อสอบถาม';
    $txtShow["OnlineClassroom"] = 'ห้องเรียนออนไลน์';
    $txtShow["Or"] = 'หรือ';
    $txtShow["ContactNumber"] = 'เบอร์โทรติดต่อ';

    $txtShowPayment['Approve'] = "อนุมัติ";
    $txtShowPayment['Pending'] = "รอการอนุมัติ";
    $txtShowPayment['PleasePay'] = "กรุณาชำระเงิน";
    $txtShowPayment['PleaseAttactDocument'] = "กรุณาแนบเอกสาร";
    $txtShowPayment['Disapproved'] = "ไม่อนุมัติ";
    $txtShowPayment['PaymentStatus'] = "สถานะการชำระเงิน";
    $txtShowPayment['DocumentStatus'] = "สถานะของการแนบเอกสาร";
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
<!-- <link href="https://facesimilarity.static.dakok.net/dakok-detect/chunk-dakok-detect.js" rel="preload" as="script">
<link href="https://facesimilarity.static.dakok.net/dakok-detect/chunk-dakok-detect.css" rel="preload" as="style">
<link href="https://facesimilarity.static.dakok.net/dakok-detect/dakok-detect.js" rel="preload" as="script">
<link href="https://facesimilarity.static.dakok.net/dakok-detect/chunk-dakok-detect.css" rel="stylesheet"> -->
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
                        <?= $Period ?> <?= $logtime->course_day ?> <?= $day ?> <?= (!empty($course)) ? "(" . Helpers::lib()->covert24HourTo12Hour($course->start_date, $langId) . Helpers::lib()->CuttimeLang($course->start_date, $langId) . " - " . Helpers::lib()->covert24HourTo12Hour($course->end_date, $langId) . Helpers::lib()->CuttimeLang($course->end_date, $langId) . ")" : ""; ?>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="thumbmail-course-detail">
                                    <?php if ($course->ms_teams_picture != null) { ?>
                                        <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/msteams/<?= $course->id ?>/thumb/<?= $course->ms_teams_picture ?>" class="w-100 ">
                                    <?php } else { ?>
                                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/thumbnail-course.png" class="w-100 ">
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="text-left">
                                <h3><?= $course->name_ms_teams ?> </h3>
                            </div>

                            <div class="course-progress">

                                <div class="text-center">
                                    <a href="#tab-content" onclick="$('#change_tab2').click();" class="btn btn-success"><?= $lastStatus ?></a>

                                </div>
                                <div class="course-admin">
                                    <?php if ($course->instructor_name != null || $course->instructor_name != "") { ?>
                                        <h4><?= $CourseInstructor ?> : <span><?= $course->instructor_name ?></span></h4>
                                    <?php } ?>
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
                                                    $textPayment = $txtShowPayment['Approve'];
                                                    $classPayment = "text-success";
                                                } elseif ($courseTemp->status_payment == "w") {
                                                    $textPayment = $txtShowPayment['Pending'];
                                                    $classPayment = "text-warning";
                                                } elseif ($courseTemp->status_payment == "n") {
                                                    $textPayment = $txtShowPayment['PleasePay'];
                                                    $classPayment = "text-warning";
                                                } else {
                                                    $textPayment = $txtShowPayment['Disapproved'];
                                                    $classPayment = "text-danger";
                                                }
                                                ?>
                                                <h4><?= $txtShowPayment['PaymentStatus'] ?> : <span class="<?= $classPayment ?>"><?= $textPayment ?></span></h4>
                                                <div class="text-center mt-20">
                                                    <?php if (($courseTemp->file_payment == null && $courseTemp->status_payment == "n") || $courseTemp->status_payment == "x" || $courseTemp->status_payment == "n") { ?>
                                                        <a data-toggle="modal" data-target="#course-booking" class="btn btn-booking-outline"><i class="fas fa-file-invoice"></i>&nbsp;<?= $langId == 1 ? "Proof of payment" : "แนบหลักฐานการชำระเงิน" ?></a>
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
                                                    $textDocument = $txtShowPayment['Approve'];
                                                    $classDocument = "text-success";
                                                } elseif ($courseTemp->status_document == "w") {
                                                    $textDocument = $txtShowPayment['Pending'];
                                                    $classDocument = "text-warning";
                                                } elseif ($courseTemp->status_document == "n") {
                                                    $textDocument = $txtShowPayment['PleaseAttactDocument'];
                                                    $classDocument = "text-warning";
                                                } else {
                                                    $textDocument = $txtShowPayment['Disapproved'];
                                                    $classDocument = "text-danger";
                                                }
                                                ?>
                                                <h4><?= $txtShowPayment['DocumentStatus'] ?> : <span class="<?= $classDocument ?>"><?= $textDocument ?></span></h4>
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

                                <div class="col-md-6 col-xs-6">
                                    <div class="c-item">
                                        <small><?= $Lessons ?></small>
                                        <div class="text-center mt-20">
                                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/book-icon.png">
                                            <small class="text-center detail-value"><?= count($lessonList) . ' ' . $Lessons ?></small>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $coruse_percents =  Helpers::lib()->percent_MsTeams($course->id, 0);

                                if ($coruse_percents >= 100) {

                                    $certDetail = CertificateNameRelationsMsTeams::model()->find(array('condition' => 'ms_teams_id=' . $course->id));
                                    if (empty($certDetail)) {
                                        $pathPassed = 'javascript:void(0);';
                                        $pathPassed_Onclick = 'onClick="alertswalNocert()"';
                                    } else {
                                        $targetBlank = 'target="_blank"';
                                        $statePrintCert = true;
                                        $pathPassed = $this->createUrl('virtualclassroom/PrintCertificate', array('id' => $course->id));
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

                                $CheckHaveCer = Helpers::lib()->CheckHaveCerMsTeams($course->id);
                                ?>

                                <?php if ($CheckHaveCer) { ?>
                                    <?php if ($courseTemp->lock_document == 'y') { ?>
                                        <!--มีการล็อค-->
                                        <div class="col-md-6 col-xs-6">
                                            <div class="c-item">
                                                <small><?= $CourseCert ?></small>
                                                <div class="text-center mt-20">
                                                    <a onclick="alertLockDocument()" href="javascript:void(0)">
                                                        <div class="text-center">
                                                            <i class="" aria-hidden="true"><img src="<?= $img_tophy ?>"></i>
                                                            <small class="mt-20"><?= $label->label_printCert ?></small>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <!--ไม่มีการล็อค-->
                                        <?php if ($course->price == 'y') {  ?>
                                            <!--คอร์ดไม่ฟรี-->
                                            <?php if ($courseTemp->status_document == 'y' &&  $courseTemp->status_payment == 'y') { ?>
                                                <!--เอกสารครบ-->
                                                <div class="col-md-6 col-xs-6">
                                                    <div class="c-item">
                                                        <small><?= $CourseCert ?></small>
                                                        <div class="text-center mt-20">
                                                            <a href="<?php echo $pathPassed; ?>" <?= $pathPassed_Onclick; ?> <?php echo $targetBlank . " " . $certEvnt; ?>>
                                                                <div class="text-center">
                                                                    <i class="" aria-hidden="true"><img src="<?= $img_tophy ?>"></i>
                                                                    <small class="mt-20"><?= $label->label_printCert ?></small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <!--เอกสารไม่ครบ-->
                                                <div class="col-md-6 col-xs-6">
                                                    <div class="c-item">
                                                        <small><?= $CourseCert ?></small>
                                                        <div class="text-center mt-20">
                                                            <a onclick="alertIncomDocuments()" href="javascript:void(0)">
                                                                <div class="text-center">
                                                                    <i class="" aria-hidden="true"><img src="<?= $img_tophy ?>"></i>
                                                                    <small class="mt-20"><?= $label->label_printCert ?></small>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <div class="col-md-6 col-xs-6">
                                                <div class="c-item">
                                                    <small><?= $CourseCert ?></small>
                                                    <div class="text-center mt-20">
                                                        <a href="<?php echo $pathPassed; ?>" <?= $pathPassed_Onclick; ?> <?php echo $targetBlank . " " . $certEvnt; ?>>
                                                            <div class="text-center">
                                                                <i class="" aria-hidden="true"><img src="<?= $img_tophy ?>"></i>
                                                                <small class="mt-20"><?= $label->label_printCert ?></small>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>

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
                               <?= $txtShow["OnlineClassroom"] ?> : <?= $course->name_ms_teams ?>
                            </div>
                            <div class="col-md-2 col-sm-12 col-xs-12 mt-xs-2">
                                <?php $setting = Setting::model()->find(); 
                                     if($setting->settings_confirmface_zoom == 0){ ?>
                                        <a onclick="sendNotiToAppAuthenticator();checkNotiResponse();notificationApp();" target="_blank" class="btn btn-warning pull-right"><i class="fa fa-pencil-square-o" aria-hidden="true">
                                     <?php }else { ?>
                                        <?php  if($course->status_ms_teams == 1){ ?>
                                                    <a target="_blank" data-toggle="modal" data-target="#captueZoom" class="btn btn-warning pull-right" id="in-zoom"><i class="fa fa-pencil-square-o" aria-hidden="true">
                                        <?php }else{  ?>
                                                    <a onclick="sendNotiToAppAuthenticator();checkNotiResponse();notificationApp();" target="_blank" class="btn btn-warning pull-right"><i class="fa fa-pencil-square-o" aria-hidden="true">
                                        <?php } ?>
                                       
                                     <?php } ?>
                                    </i> <?= $Join ?></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="course-detail">
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation">
                                <a href="#course-info" aria-controls="course-info" role="tab" id="change_tab1" data-toggle="tab"><?php echo $label->label_detail; ?></a>
                            </li>
                            <li role="presentation">
                                <a href="#course-unit" aria-controls="course-unit" role="tab" id="change_tab2" data-toggle="tab"><?php echo $label->label_Content; ?></a>
                            </li>
                            <li role="presentation" class="active">
                                <a href="#course-contact" aria-controls="course-contact" role="tab" id="change_tab3" data-toggle="tab"><?= $Contact ?></a>
                            </li>

                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content" id="tab-content">

                            <div role="tabpanel" class="tab-pane" id="course-info">
                                <li class="list-group-item">

                                    <?php echo htmlspecialchars_decode($course->detail_ms_teams); ?>

                                    <div class="text-left">
                                        <a onclick="$('#change_tab2').click();" class="btn btn-warning">Next</a>
                                    </div>
                                </li>
                            </div>


                            <div role="tabpanel" class="tab-pane active" id="course-contact">
                                <li class="list-group-item">

                                    <div class="contact-linetel">
                                        <h4><?= $Contact ?></h4>
                                        <div class="row">
                                            <div class="col-sm-6 col-md-5 col-lg-4">
                                                <div class="line-detail">
                                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/qrcode-line.jpg">
                                                    <div class="text-center text-muted mb-1"><?= $txtShow["Or"] ?></div>
                                                    <div class="text-center">
                                                        <a href="https://lin.ee/UYCvmnD" target="_blank" class="btn btn-addline"><i class="fab fa-line"></i> Add Line</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-5 col-lg-4">
                                                <div class="tel-detail">
                                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/tel.jpg">
                                                    <div class="text-center mb-1">
                                                        <?= $txtShow["ContactNumber"] ?> : <a class="text-main" href="tel:023936660">023936660 </a>
                                                    </div>
                                                    <div class="text-center" style="visibility: hidden;">
                                                        <a href="#" target="_blank" class="btn btn-addline"><i class="fab fa-line"></i>&nbsp;</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="course-unit">
                                <ol class="course-ol">
                                    <div class="panel panel-default">

                                        <?php
                                        foreach ($lessonList as $key => $lessonListValue) {
                                            if (!$flag) {

                                                $lessonListChildren  = LessonMsTeams::model()->find(array('condition' => 'parent_id = ' . $lessonListValue->id, 'order' => 'lesson_no'));
                                                if ($lessonListChildren) {
                                                    $lessonListValue->title = $lessonListChildren->title;
                                                    $lessonListValue->description = $lessonListChildren->description;
                                                    $lessonListValue->content = $lessonListChildren->content;
                                                    $lessonListValue->image = $lessonListChildren->image;
                                                }
                                            }

                                            // var_dump($lessonListValue);
                                            $idx = 1;
                                            $checkPreTest = Helpers::checkHavePreTestInManageMsTeams($lessonListValue->id);

                                            $checkPostTest = Helpers::checkHavePostTestInManageMsTeams($lessonListValue->id);

                                            $checkLessonPass = Helpers::lib()->checkLessonPass_Percent_MsTeams($lessonListValue);

                                            $postStatus = Helpers::lib()->CheckTestMsTeams($lessonListValue, "post");

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

                                            <div class="panel-collapse collapse in" id="collapse-<?= $lessonListValue->id ?>" role="tabpanel" aria-labelledby="headingOne">
                                                <?php if ($checkPreTest) { ?>
                                                    <div class="stepcoursediv">
                                                        <div> <span class="stepcourse"><?php echo $label->label_step; ?> <?= $idx++; ?> </span><?php echo $label->label_testPre; ?></div>
                                                    </div>
                                                    <ul class="list-group">
                                                        <?php

                                                        $isPreTest = Helpers::isPretestStateMsteams($lessonListValue->id);

                                                        // alertswalExams
                                                        if ($lessonListValue->status_exams_pre == 1) {

                                                            if ($can_next_step  != 2) {
                                                                $ckLinkTest = $this->createUrl('/questionmsteams/preexams', array('id' => $lessonListValue->id, 'type' => 'pre'));
                                                                $ckLinkTest_onClick = '';
                                                            } else {
                                                                $ckLinkTest = 'javascript:void(0);';
                                                                $ckLinkTest_onClick = 'onclick="alertSequence();"';
                                                            }
                                                        } else {
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
                                                            $scoreAll = ScoreMsTeams::model()->findAll($criteriaScoreAll);
                                                            foreach ($scoreAll as $keyx => $score_ck) {

                                                                if ($score_ck->score_past == 'y') {
                                                                    $flagPreTestPass = true;
                                                                    $colorText = 'text-success';
                                                                } else {
                                                                    $colorText = 'text-danger';
                                                                }
                                                                $preStatus = Helpers::lib()->CheckTestAllMsTeams($lessonListValue, "pre", $score_ck);


                                                                $CheckPreTestAnsTextAreaLesson = Helpers::lib()->CheckPreTestAnsTextAreaLessonMsTeams($lessonListValue, "pre");

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
                                                                if ($lessonListValue->status_exams_pre == 1) { ?>
                                                                    ?>
                                                                    <?php echo $label->label_testPre; ?> <?= count($scoreAll) + 1; ?> <span class="pull-right"><a href="<?php echo $this->createUrl('/questionmsteams/preexams', array('id' => $lessonListValue->id, 'type' => 'pre')); ?>" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $label->label_DoTest; ?></a></span>

                                                                <?php } else { ?>

                                                                    <?php echo $label->label_testPre; ?> <?= count($scoreAll) + 1; ?> <span class="pull-right"><a href="javascript:void(0);" onclick="alertswalExams();" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $label->label_DoTest; ?></a></span>

                                                                <?php } ?>


                                                            </li>
                                                        <?php } ?>
                                                        <?php
                                                    } else {
                                                        $prelearn = true;
                                                    }

                                                    if ($checkPostTest) {
                                                        $isPostTest = Helpers::isPosttestStateMsteams($lessonListValue->id);

                                                        if ($isPostTest) {
                                                            if ($lessonListValue->status_exams_post == 1) {

                                                                if ($prelearn) {
                                                                    $link = $this->createUrl('questionmsteams/preexams', array('id' => $lessonListValue->id));
                                                                    $alert = '';
                                                                } else {
                                                                    $link = 'javascript:void(0);';
                                                                    $alert = 'alertswal();';
                                                                }
                                                            } else {
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
                                                            $scoreAll = ScoreMsTeams::model()->findAll($criteriaScoreAll);
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
                                                                $postStatus = Helpers::lib()->CheckTestAllMsTeams($lessonListValue, "post", $scorePost);

                                                                $CheckPreTestAnsTextAreaLessonPost = Helpers::lib()->CheckPreTestAnsTextAreaLessonMsTeams($lessonListValue, "post");

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

                                                                if ($lessonListValue->status_exams_post == 1) {

                                                                    $link = $this->createUrl('questionmsteams/preexams', array('id' => $lessonListValue->id));
                                                                    $alert = '';
                                                                } else {
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
                                                    <?php }

                                                    $filedoc_old = FileDocMsTeams::model()->findAll('active="y" and lesson_teams_id = ' . $lessonListValue->id);

                                                    if ($filedoc_old) :
                                                    ?>
                                                        <div class="stepcoursediv">
                                                            <div> <span class="stepcourse"><?php echo $label->label_DocsDowload; ?> </span></div>
                                                        </div>
                                                        <?php foreach ($filedoc_old as $filesDoc => $doc) {
                                                            $linkDownload =  $this->createUrl('/virtualclassroom/download', array('id' => $doc->id));
                                                            $onClickDownload =  '';

                                                        ?>
                                                            <li class="list-group-item "><a href="<?= $linkDownload; ?>" <?= $onClickDownload ?>> <span class="list-course-number"><?= $filesDoc + 1 ?>. </span> <span class="list__course"><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: #ee0f10;"></i>&nbsp;&nbsp;<?= $doc->getRefileName() ?></span> <span class="pull-right"><i class="fa fa-download"></i> <?php echo  $label->label_download; ?></span></a></li>
                                                    <?php
                                                        }
                                                    endif;
                                                    ?>


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

<div class="modal fade" id="course-booking" tabindex="-1" role="dialog" aria-labelledby="course-booking">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">จ่ายเงินเพื่อจองหลักสูตร</h4>
            </div>
            <div class="modal-body body-pay">

                <form action="<?php echo $this->createUrl('course/bookingmsteamssave') ?>" id="frmsavepay" name="frmsavepay" method="post" class="needs-validation" enctype="multipart/form-data">
                    <div class="pay-course">
                        <h4>ธนาคารที่โอนเข้า</h4>
                        <?php
                        $modelbank = BankNameRelations::model()->findAll(array(
                            'condition' => 'ms_teams_id = "' . $course->id . '"'
                        ));

                        if (isset($_GET['tempoldid'])) {
                            $msOld = MsteamsTemp::model()->findByPk($_GET['tempoldid']);
                        }

                        foreach ($modelbank as $key => $valueb) {

                        ?>
                            <div class="row row-pay align-items-center">

                                <input <?= isset($_GET['tempoldid']) && $msOld->bank_id == $valueb->banks->id ? 'checked' : "" ?> <?= isset($_GET['tempoldid']) && $valueb->banks->id != null ? 'disabled' : "" ?> type="radio" id="test-<?= $valueb->banks->id ?>" name="chkbank" class="custom-control-input custom" value="<?= $valueb->banks->id ?>">
                                <img class="mx-2" src="<?php echo Yii::app()->baseUrl; ?>/uploads/bank/<?= $valueb->banks->id ?>/<?= $valueb->banks->bank_images ?>" width="80" alt="">

                                <div class="account-bank">
                                    <h4 class="">ธนาคาร : <span class="text-main"><?= $valueb->banks->bank_name ?></span></h4>
                                    <h4 class="">ชื่อบัญชี : <span class="text-main"><?= $valueb->banks->account_name ?></span></h4>
                                    <h4 class="">หมายเลขบัญชี : <span class="text-main"><?= $valueb->banks->account_number ?></span></h4>

                                </div>

                            </div>
                        <?php } ?>
                    </div>

                    <input type="hidden" name="course_id" value="<?= $course->id ?>">
                    <input type="hidden" name="type_price" value="<?= $type_pri ?>">
                    <input type="hidden" name="tempoldid" value="<?= $_GET['tempoldid']; ?>">

                    <div class="pay-course">
                        <div class="row">
                            <div class="col-lg-3 col-xs-12">
                                <div class="form-group">
                                    <label for="">จำนวนเงินที่โอน</label>
                                    <div class="input-group">
                                        <input <?= isset($_GET['tempoldid']) && $msOld->money != null ? 'disabled' : "" ?> type="text" value="<?= isset($_GET['tempoldid']) && $msOld->money != null ? $msOld->money : "" ?>" class="form-control" name="money" placeholder="">
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
                                    <?php if (isset($_GET['tempoldid']) && $msOld->date_slip != null) { ?>
                                        <input type="text" value="<?= $msOld->date_slip ?>" disabled class="form-control" name="date_slip">
                                    <?php } else { ?>
                                        <input type="datetime-local" value="" class="form-control" name="date_slip" placeholder="">
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pay-course">
                        <h4>อัปโหลดหลักฐานการชำระเงิน</h4>
                        <input type="file" name="file_payment" id="file_payment" class="form-control" style="height:40px;">
                    </div>

                    <?php if (isset($courseTemp->note_payment) || $courseTemp->status_payment == 'x') { ?>
                        <div class="text-danger"><i class="fas fa-times-circle"></i>&nbsp;หมายเหตุ-ไม่ผ่านอนุมัติ : <?= isset($courseTemp->note_payment) ? $courseTemp->note_payment : 'การชำระเงินไม่ผ่าน - ไม่มีรายละเอียด' ?></div>
                    <?php } ?>

                </form>

                <button type="button" onclick="mybooking('pay')" id="b3" class="btn btn-booking">ยืนยันการจอง</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="course-uploadfile" tabindex="-1" role="dialog" aria-labelledby="course-uploadfile">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">แนบเอกสารเพื่อจองหลักสูตร</h4>
            </div>
            <div class="modal-body body-pay">
                <p class="text-danger">
                    <i class="fa fa-info-circle"></i> หมายเหตุ : <?= isset($note) ? $note->note : '-'; ?>
                </p>
                <form action="<?php echo $this->createUrl('course/msteamsuploaddocument') ?>" id="frmsavedocument" name="frmsavedocument" method="post" class="needs-validation" enctype="multipart/form-data">

                    <input type="hidden" name="msteams_id" value="<?= $course->id ?>">
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="documentattch">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <input type="hidden" id="document-group" value="1">

                        </div>
                        <div class="col-sm-12">
                            <a href="#" class="btn btn-add" onClick="addFormField(); return false;"><i class="fas fa-plus"></i> เพิ่มเอกสาร</a>
                        </div>
                    </div>
                    <!-- <div class="pay-course">
                        <h4>เอกสารแนบ</h4>
                        <input type="file" multiple name="file_document[]" accept="image/png , image/jpg , image/jpeg , application/pdf" id="file_document" class="form-control" style="height:40px;">
                    </div> -->
                </form>
                <script>
                    <?php if (count($courseDocument) > 0) { ?>
                        filesToField();
                    <?php } else { ?>
                        addFormField();
                    <?php } ?>

                    async function filesToField() {
                        var numItems = <?= count($courseDocument) ?>;
                        if (numItems > 1) {
                            <?php foreach ($courseDocument as $keyfile => $file) { ?>
                                addFormField();
                            <?php } ?>
                        } else {
                            addFormField();
                        }

                        await addFileToField()
                    }

                    function addFileToField() {
                        var numItems = <?= count($courseDocument) ?>;
                        <?php foreach ($courseDocument as $keyfile => $file) { ?>
                            var fileInput = document.querySelectorAll('input[name="file_document[]"]')[<?= $keyfile ?>];
                            var detail = $("<a id='detailFile" + <?= $keyfile + 1 ?> + "' target='_blank' href='<?= Yii::app()->baseUrl ?>/uploads/msteamsdocument/<?= $course->id ?>/<?= Yii::app()->user->id ?>/<?= $file->file_address ?>' class='btn-primary btn'><i class='fa fa-search' aria-hidden='true'></i></a> &nbsp;").insertAfter(fileInput);
                            $("<input type='hidden' id='fileId" + <?= $keyfile + 1 ?> + "' name='fileId[]' value='" + '<?= $file->id . '-' . $file->file_name ?>' + "'>").insertAfter(detail);

                            var txtFile = $("#row" + <?= $keyfile + 1 ?> + " > .txtFile");
                            <?php if ($file->confirm_status == 'y') { ?>
                                $("<span id='statusupload' class='text-success'>&nbsp;&nbsp;(อนุมัติ)</span>").insertAfter(txtFile);
                            <?php } else if ($file->confirm_status == 'w') { ?>
                                $("<span id='statusupload' class='text-warning'>&nbsp;&nbsp;(รอการตรวจสอบ)</span>").insertAfter(txtFile);
                            <?php } else if ($file->confirm_status == 'x') { ?>
                                $("<span id='statusupload' class='text-danger'>&nbsp;&nbsp;(ไม่อนุมัติ)</span>").insertAfter(txtFile);
                            <?php } ?>

                            // Create a new File object
                            var myFile = new File(['Hello World!'], "<?= $file->file_name ?>", {
                                name: 'test',
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
                        var id = $(".txtFile").length + 1;
                        $("#documentattch").append(
                            "<div class='pay-course' id='row" +
                            id +
                            "'><label for='txt" +
                            id +
                            "'class='txtFile'>เอกสารแนบที่ " +
                            id + '</label>' +
                            "<div class='flex-upload'><input onchange='changeOldFile(\"" + id + "\")' type='file' name='file_document[]' accept='image/png , image/jpg , image/jpeg , application/pdf' class='upload-h40 form-control' size='20' name='txt[]' id='txt" +
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

                    function resetTxtFile() {
                        var id = 0;
                        $("#documentattch > .pay-course").each(function(i) {
                            id = i + 1;
                            $(this).attr("id", "row" + id);
                            $(this).find(".txtFile").attr("for", "txt" + id);
                            $(this).find(".txtFile").text("เอกสารแนบที่ " + id);
                        });
                    }

                    function changeOldFile(id) {
                        var detail = '#detailFile' + id;
                        var file = '#fileId' + id;
                        if ($(detail).length) {
                            $(detail).remove();
                        }
                        $('#statusupload').remove();

                        if ($(file).length) {
                            id = id - 1;
                            const myFileArray = $(file).val().split("-");
                            var filename = $('input[name="file_document[]"]').eq(id).val().split('\\').pop();
                            $(file).val(myFileArray[0] + '-' + filename);
                        }
                    }
                </script>

                <button type="button" onclick="myupload('upload')" id="b3" class="btn btn-booking">อัพโหลดเอกสาร</button>
                <?php if ($courseTemp->status_document == 'x') { ?>
                    <div class="text-danger"><i class="fas fa-times-circle"></i>&nbsp;หมายเหตุ : <?= isset($courseTemp->note_document) ? $courseTemp->note_document : 'เอกสารไม่ผ่าน - ไม่มีรายละเอียด' ?></div>
                <?php } ?>
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
                                    <td><a class="btn btn-primary" target="_blank" href="<?= Yii::app()->baseUrl ?>/uploads/msteamsdocument/<?= $course->id ?>/<?= Yii::app()->user->id ?>/<?= $file->file_address ?>">ตรวจสอบเอกสาร</a></td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

</section>
<script>
    function confirmModel(id) {
        <?php
        session_start();
        $_SESSION["alertConfirm" . $course->id] = 'done';
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
    function mybooking($type = null) {
        var cou_ti = "<?= $course->name_ms_teams ?>";
        Swal.fire({
            title: '<?= $courseconfirm ?>',
            text: cou_ti,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?= $confirm ?>',
            cancelButtonText: '<?= $cancel ?>',
        }).then((result) => {
            if (result.value) {
                if ($type != null) {
                    if (document.getElementById("file_payment").files.length == 0) {
                        swal("กรุณาอัปโหลดหลักฐานการชำระเงิน", "", "error");
                        return false;
                    } else {
                        document.getElementById("frmsavepay").submit();
                    }

                } else {
                    document.getElementById("frmsave").submit();
                }
            }
        })
    }

    function myupload($type = null) {
        const lengthFileField = $(".txtFile").length;
        var values = $("input[name='file_document[]']")
            .map(function() {
                return $(this).val();
            }).get();
        values = values.filter(i => i != '');
        const lengthFileUpload = values.length;

        if (lengthFileField == lengthFileUpload) {
            var cou_ti = "<?= $teams->name_ms_teams ?>";
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
        } else {
            swal("อัพโหลดเอกสารไม่ครบ", "กรุณาอัพโหลดเอกสารอีกครั้ง", "warning");
        }

        // if($("#file_document")[0].files.length > 0){
        //     var cou_ti = "<?= $teams->name_ms_teams ?>";
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
        // }else{
        //     Swal.fire({
        //       icon: 'error',
        //       title: 'กรุณาเลือกไฟล์เอกสาร',
        //       text: 'อย่างน้อย 1',
        //   })
        // }

    }

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


<?php
$user =  User::model()->findbyPk(Yii::app()->user->id);
?>

<style>
    #video {
        display: block;
    }

    .id-frame {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url("<?php echo Yii::app()->theme->baseUrl; ?>/idcard/img/face-d.png") !important;
        background-size: 50%;
        background-position: center center;
        background-repeat: no-repeat;
    }

    #VideoBox {
        /* display: none; */
        width: fit-content;
        margin: auto;
        position: relative;
    }
</style>

<div class="modal fade" id="captueZoom">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title"><i class="fa fa-sign-in" aria-hidden="true"></i> ถ่ายภาพใบหน้า </h4>
            </div>
            <div class="modal-body">

                <section class="content-page">
                    <div class="">
                        <div class="row justify-content-center">
                            <div class="col-lg- col-sm-12 col-xs-12">
                                <!-- NOTE: Add overflow hidden for hide overflow camera frame -->
                                <div class=" p-3" style="overflow: hidden;">
                                    <h3 class="text-center mb-1"><?= $langId == 1 ? "Verify your face" : "ยืนยันภาพใบหน้าของคุณ" ?></h3>
                                    <br>
                                    <div id="idcardWrapper" class="no-photo no-mobile">
                                        <div class="">
                                            <div class="">
                                                <div class="facelogin" id="cameraPhotoWrapper">
                                                    <div style="display: flex;align-content: center;justify-content: center; width: fit-content;margin: auto;position: relative;" id="cameraContainer">
                                                        <!-- <dakok-detect></dakok-detect>                     -->
                                                        <video id="videos" width="520" height="360" controls autoplay playsinline muted></video>
                                                        <canvas id="canvas" class="preview-camera preview-main" width="520" height="360" style="display:none;"></canvas>
                                                        <div class="id-frame"></div>
                                                    </div>
                                                </div>
                                                <div class="mt-2 mb-4 pt-3 pb-4">
                                                    <div class="form-group text-center">
                                                        <label for="profile">Name: <?= $user->profile->firstname; ?></label>
                                                        <br>
                                                        <br>

                                                        <?php
                                                        $form = $this->beginWidget(
                                                            'CActiveForm',
                                                            array(
                                                                'id' => 'capture-virtualclassroom',
                                                                'htmlOptions' => array('enctype' => 'multipart/form-data', 'name' => 'form1'),
                                                            )
                                                        );
                                                        ?>

                                                        <input type="file" accept="image/jpg"  name="face_image_1" id="face_image_1" style="display: none;">
                                                        <input type="file" accept="image/jpg"  name="face_image_2" id="face_image_2" style="display: none;">
                                                        <input type="file" accept="image/jpg"  name="face_image_3" id="face_image_3" style="display: none;">
                                                        <!-- <input type="hidden" name="current_image" id="current_image"> -->
                                                        <input type="text" hidden name="msteams" id="msteams" value="<?= $course->id ?>">
                                                        <input type="text" hidden name="zoom" id="zoom" value="<?= $course->url_join_meeting ?>">
                                                        <!-- <input type="file" id="file_image" name="file_image"> -->
                                                        <!-- <h5>ระบบจะทำการ Log out : <h5/>
                                                        <h4 id="time" style="color:rgb(221, 51, 51);">02:00</h4> -->
                                                        <div id="face-warn" style="display: block;">
                                                            กำลังตรวจจับใบหน้า กรุณาขยับใบหน้า
                                                        </div>

                                                        <div class="col take-camera-desktop mt-1">
                                                            <button type="button" id="capture-photo" class="btn btn-primary">ถ่ายภาพ</button>
                                                            <button type="button" id="clear-photo" class="btn btn-danger">เริ่มใหม่</button>
                                                            <br><br>
                                                            <button onclick="login()" class="take-photo take-camera-desktop btn btn-warning mb-1" id="submit-button" disabled="true">
                                                                <i class="fas fa-camera"></i>
                                                                &nbsp;
                                                                <?= $langId == 1 ? "Confirm" : "ยืนยัน" ?>
                                                            </button>
                                                        </div>
                                                        <?php
                                                        $this->endWidget();
                                                        ?>
                                                        <!-- <div class="other-login">
                                                            <h4 class="text-muted">หรือยืนยันใบหน้าผ่าน App เพื่อยันยันตน</h4>
                                                            <div class="auth-app">
                                                                <a href="#" class="btn btn-appauth">
                                                                    ไปยัง App Authenticator <i class="fas fa-mobile-alt"></i>
                                                                </a>
                                                            </div>
                                                        </div> -->

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <canvas id="myCanvas" width="400" height="350" hidden></canvas>
                    </div>

                </section>

            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">ปิด</button>
            </div> -->
        </div>
    </div>
</div>


<!-- <script src="https://facesimilarity.static.dakok.net/dakok-detect/chunk-dakok-detect.js"></script>
<script src="https://facesimilarity.static.dakok.net/dakok-detect/dakok-detect.js"></script> -->
<script>
    const output = document.getElementById("current_image")
    const warn = document.getElementById("face-warn")
    const btn = document.getElementById("submit-button")
    const inputField = document.getElementById("iOSInput");


    const login = () => {
        // $("#preview").css("display", "none");
        // $("#capture-photo").prop('disabled', false);
        // $("#clear-photo").trigger("click");
        // $("#capturePreview").attr("src","");
        // $("#submit-button").prop('disabled', true);
        $("#captueZoom").modal('hide');
        // $("#submit-button").submit();

        // Draws current image from the video element into the canvas
        // ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        // const dataURL = canvas.toDataURL('image/png');
        // document.getElementById("current_image").value = document.getElementById("dakok-detect-result").value;
    }



    // setInterval(async () => {
    //     const result = document.getElementById("dakok-detect-result")
    //     if (result.value.length > 0) {
    //         output.value = result.value
    //         warn.style.display = 'none';
    //         btn.disabled = false;
    //     }
    // }, 380)
</script>
<script>
    function alertLockDocument() {
        swal("ขณะนี้หลักสูตรกำลังถูกล็อค", "อัพโหลดเอกสารไม่ครบ กรุณาอัพโหลดเอกสารเพิ่มเติม", "warning");
    }

    function alertIncomDocuments() {
        swal("ไม่สามารถดาวน์โหลดได้", "เอกสารไม่ครบ หรือยังไม่ผ่านการอนุมัติ", "warning");
    }

    // var timeMinutes = 60 * 2
    // countDownTimeOut(timeMinutes);
    function countDownTimeOut(duration) {
        var timer = duration,
            minutes, seconds;
        var x = setInterval(function() {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display = $('#time');
            display.text(minutes + ":" + seconds);
            if (--timer < 0) {
                clearInterval(x);
                window.location.href = "<?= $this->createUrl('login/logout'); ?>";
            }
        }, 1000);
    }
    var zoom = $("#zoom").val();
    window.checkZoom = 0;
    let notiresponse ;
    function checkNotiResponse() {
        if(statusMsteams == 1){
                notiresponse = setInterval(function() {
                var user_id = <?= Yii::app()->user->getId() ?>;
                $.ajax({
                    url: "<?= $this->createUrl('/reciveimageapi/GetResponse'); ?>",
                    type: "POST",
                    data: {
                        user_id
                    },
                    success: function(data) {
                        if (data.trim() == 'true') {
                            if (typeof window.checkZoom !== 'undefined') {
                                window.checkZoom = 1;
                            }

                            $("#captueZoom").modal('hide');
                            clearInterval(notiresponse);
                        }

                        if (window.checkZoom == 1) {
                            window.open(zoom, '_blank');
                            delete window.checkZoom;
                        }
                    }
                });
            }, 5000);
        } 
    }

    var timeNoti = <?= isset($course->duration_authen) ? $course->duration_authen : 10 ?> *  60 * 1000;
    var statusMsteams = <?= $course->status_ms_teams ?>;
    let timerID ;
    const sendNotiToAppAuthenticator = async () => {
        if(statusMsteams == 1){
            user_id = <?= Yii::app()->user->getId() ?>;
            course_id = <?= $course->id ?>;
            lesson_id = 0;
            zoom_url = $("#zoom").val();
            $.ajax({
                url: "<?= $this->createUrl('virtualclassroom/SendNotiToApiAuthen'); ?>",
                type: "POST",
                data: {
                    user_id: user_id,
                    course_id: course_id,
                    lesson_id: lesson_id,
                    zoom_url:zoom_url
                },
                success: function(data) {

                }
            });

            timerID = await setInterval(function() {
                sendNotiToAppAuthenticator();
                checkNotiResponse();
            }, timeNoti);

        }
    }


    var checkStopSendNoti = setInterval(function() {
        if(statusMsteams == 1){
            var course_id = <?= $course->id ?>;
            $.ajax({
                url: "<?= $this->createUrl('virtualclassroom/CheckStopSendNoti'); ?>",
                type: "POST",
                data: {
                    course_id: course_id,
                },
                success: function(data) {
                    if (data.trim() == 'true') {
                        clearInterval(timerID);
                        clearInterval(notiresponse);
                        clearInterval(checkStopSendNoti);
                        statusMsteams = 0;
                        
                        $('#in-zoom').removeAttr("data-toggle").removeAttr("data-target");
                        $('#in-zoom').attr('onClick','notificationApp()');
                    }
                }
            });
        }else{
            clearInterval(checkStopSendNoti);  
        }
    }, 5000);

    let video = document.querySelector('video[id="videos"]');
    let click_button = document.querySelector("#capture-photo");
    let canvas = document.querySelector("#canvas");
    let clear_button = document.querySelector("#clear-photo");
    $("#clear-photo").prop('disabled', true);
    $("#preview").css("display", "none");


    if (navigator.mediaDevices.getUserMedia) {

        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(function(stream) {
                videoCap = document.querySelector('video[id="videos"]');
                videoCap.play();
                videoCap.srcObject = stream;
                webcamStreamCap = stream;
            })
            .catch(function(err0r) {
                alert(err0r);
            });

    } else {
        alert("getUserMedia not supported");
    }

    // navigator.mediaDevices.getUserMedia({ video: true, audio: false })
    // .then((stream) => {
    //   video.srcObject = stream;
    //   video.play();
    // })
    // .catch((err) => {
    //   console.error(`An error occurred: ${err}`);
    // });


    click_button.addEventListener('click', function() {
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        let image_data_url = canvas.toDataURL('image/jpeg');
        // console.log(image_data_url);
        var  user_id = <?= Yii::app()->user->getId() ?>;
        // document.getElementById("current_image").value = image_data_url;
        dataURLtoFile(image_data_url,user_id.toString(),"#face_image_1");
        dataURLtoFile(image_data_url,user_id.toString(),"#face_image_2");
        dataURLtoFile(image_data_url,user_id.toString(),"#face_image_3");
        // notificationApp

        $(".preview-main").css("display", "");
        $(".id-frame").css("display", "none");
        $("#capture-photo").prop('disabled', true);
        $("#clear-photo").prop('disabled', false);
        $("#submit-button").prop('disabled', false);
        // $("#capturePreview").attr("src", image_data_url);
        // $("#capture-photo").prop('disabled', true);
        // $("#clear-photo").prop('disabled', false);
        // $("#submit-button").prop('disabled', false);


    });


    clear_button.addEventListener('click', function() {
        $(".preview-main").css("display", "none");
        $(".id-frame").css("display", "");
        $("#capture-photo").prop('disabled', false);
        $("#clear-photo").prop('disabled', true);
        $("#submit-button").prop('disabled', true);
        // $(".preview-main").css("display", "none");
        // $("#capture-photo").prop('disabled', false);
        // $("#clear-photo").prop('disabled', true);
        // $("#capturePreview").attr("src", "");
        // $("#submit-button").prop('disabled', true);
    });

    function notificationApp(){
        if(statusMsteams == 1){
            Swal.fire(
                'ยืนยันตัวตน',
                'กรุณายืนยันตัวตนบน LMS Authenticator App <br /> เพื่อเข้าสู่ห้องเรียนเรียน',
                'warning'
            );
        }else{
            Swal.fire(
                'คอร์สเรียนจบแล้ว',
                'ไม่สามารถเข้าสู่คอร์สเรียน Zoom ได้',
                'error'
            );
        }
    }

    function dataURLtoFile(dataurl, filename,id) {
        var arr = dataurl.split(','),
            mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]), 
            n = bstr.length, 
            u8arr = new Uint8Array(n);
            
        while(n--){
            u8arr[n] = bstr.charCodeAt(n);
        }
        
        var file =  new File([u8arr], filename, {type:mime});

        var fileInput = document.querySelector(id)
        var dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        fileInput.files = dataTransfer.files;
        // Help Safari out
        if (fileInput.webkitEntries.length) {
            fileInput.dataset.file = `${dataTransfer.files[0].name}`;
        }
    }
</script>