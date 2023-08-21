<?php
if (empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1) {
    $langId = Yii::app()->session['lang'] = 1;
    $Personal_Information = 'Personal Information';
    $Course_Status = 'Course Status';
    $Start='Start';
    $Stop='Stop';
} else {
    $langId = Yii::app()->session['lang'];
    $Personal_Information = 'ข้อมูลส่วนบุคคล';
    $Course_Status = 'ข้อมูลหลักสูตร';
    $Start='วันเริ่มต้น';
    $Stop='วันสิ้นสุด';
}
?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $label->label_statusLearn ?></li>
        </ol>
    </nav>
</div>

<section class="dashboard">
    <div class="container">
        <div class="row g-0 position-relative">
            <div class=" col-md-3 col-lg-3 col-xs-12">
                <ul class="sidebar-account">
                    <li class=""><a class="text-decoration-none" href="<?php echo $this->createUrl('/registration/Update'); ?>"><?= $Personal_Information ?></a></li>
                    <li class="active"><?= $Course_Status ?></p>
                </ul>
            </div>

            <div class="col col-md-9 col-lg-9">
                <div class="row g-5">
                    <?php

                    foreach ($start_course as $key => $value) {
                        if (isset($value->course)) {
                            if ($langId != 1) {
                                $CourseTH =  CourseOnline::model()->find(array('condition' => 'active = "y" AND lang_id = 2 AND parent_id = ' . $value->course_id));
                                if (!isset($CourseTH)) {
                                    continue;
                                } else {
                                    $value->course->course_picture = $CourseTH->course_picture;
                                    $value->course->course_title = $CourseTH->course_title;
                                }
                            }

                            $url = Yii::app()->createUrl('course/detail/', array('id' => $value->course_id));

                    ?>
                            <div class="col-sm-6 col-lg-4">
                                <div class="card card-course" style="margin-bottom: 10px">
                                    <a href="<?= $url ?>">

                                        <?php

                                        if (isset($CourseTH)) {
                                            $course_id = $CourseTH->course_id;
                                        } else {
                                            $course_id = $value->course_id;
                                        }

                                        $gen_id = $value->course->getGenID($value->course->course_id);
                                        if (!empty($value->course->course_picture) && file_exists(YiiBase::getPathOfAlias('webroot') . '/uploads/courseonline/' . $course_id . '/original/' . $value->course->course_picture)) {
                                            echo "<img class='card-img-top' src='" . Yii::app()->createUrl("uploads/courseonline") . '/' . $course_id . '/original/' . $value->course->course_picture . "'>";
                                        } else {
                                            echo "<img class='card-img-top' src='" . Yii::app()->theme->baseUrl . "/images/course-image.png'>";
                                        } ?>
                                    </a>
                                    <div class="card-body" style="padding:10px;">
                                        <h4 class="course-card-title  text-4 text-main "><?= $value->course->course_title ?><a href="#"></a></h4>
                                        <div class="progress-bottom">

                                            <?php 
                                            if ($langId == 2) {
                                                $date_start =  Helpers::changeFormatDateTHshort($value->course->course_date_start);
                                                $date_stop = Helpers::changeFormatDateTHshort($value->course->course_date_end);
                                                $course_id = $value->course->course_id;
                                                // var_dump($M_C->course_id);exit();
                                            } else {
                                                $date_start = Helpers::changeFormatDateENnew($value->course->course_date_start);
                                                $date_stop = Helpers::changeFormatDateENnew($value->course->course_date_end);
                                                $course_id = $value->course->course_id;
                                                // var_dump($value->course->course_id);exit();
                                                
                                            }
                                            $LogStartcourse = LogStartcourse::Model()->find(array('condition' => 'course_id =' . $course_id . ' AND user_id =' . Yii::app()->user->id));
                                            $passcourse = Passcours::Model()->find(array('condition' => 'passcours_cours = ' . $course_id . ' AND passcours_user =' . Yii::app()->user->id));

                                            if($langId == 2){
                                                if (!empty($passcourse)) { // ผ่าน
                                                    $status_user = 'success'; // สีเขียว
                                                    $status_text = 'เรียนผ่านแล้ว';
                                                } else if (date('Y-m-d H:i:s') > $value->course->course_date_end) { //ต่อให้เคยเรียน แต่ก็ให้ขึ้นหมดเวลา
                                                    $status_user = 'danger'; //สีแดง
                                                    $status_text = 'หมดเวลาเรียน';
                                                } else if (!empty($LogStartcourse) && empty($passcourse)) { //กำลังเรียน แต่ยังไม่ผ่าน
                                                    $status_user = 'warning'; // สีส้ม
                                                    $status_text = 'กำลังเรียน';
                                                } else if (date('Y-m-d H:i:s') > $value->course->course_date_end && empty($passcourse)) { //หมดเวลาสมัครเรียน
                                                    $status_user = 'danger'; //สีแดง
                                                    $status_text = 'หมดเวลาเรียน';
                                                } else { // ยังไม่เริ่ม
                                                    $status_user = ''; //สีน้ำเงิน
                                                }
                                            }else{
                                                if (!empty($passcourse)) { // ผ่าน
                                                    $status_user = 'success'; // สีเขียว
                                                    $status_text = 'Passed';
                                                } else if (date('Y-m-d H:i:s') > $value->course->course_date_end) { //ต่อให้เคยเรียน แต่ก็ให้ขึ้นหมดเวลา
                                                    $status_user = 'danger'; //สีแดง
                                                    $status_text = 'Expired';
                                                } else if (!empty($LogStartcourse) && empty($passcourse)) { //กำลังเรียน แต่ยังไม่ผ่าน
                                                    $status_user = 'warning'; // สีส้ม
                                                    $status_text = 'In Progress';
                                                } else if (date('Y-m-d H:i:s') > $value->course->course_date_end && empty($passcourse)) { //หมดเวลาสมัครเรียน
                                                    $status_user = 'danger'; //สีแดง
                                                    $status_text = 'Expired';
                                                } else { // ยังไม่เริ่ม
                                                    $status_user = ''; //สีน้ำเงิน
                                                }
                                            }
                                            ?>
                                            <!-- <span class="badge badge-warning">กำลังเรียน</span>
                                            <span class="badge badge-danger">หมดเวลาเรียน</span>
                                            <span class="badge badge-success">เรียนผ่านแล้ว</span> -->

                                            <span class="badge badge-<?php echo $status_user ?>"><?php echo $status_text ?></span>
                                           
                                        </div>
                                        <div class="progress progress-sm progress-border-radius mt-4 ">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= Helpers::lib()->percent_CourseGen($value->course->course_id, $gen_id) ?>%;">
                                            </div>
                                        </div>
                                        <p class="text-dark "><?= Helpers::lib()->percent_CourseGen($value->course->course_id, $gen_id) ?>%</p>
                                        <div class="exp-course dashboard-exp">
                                            <!-- <p class=""> วันเริ่มต้น : 10 Jun. 2021</p>
                                            <p class=""> วันสิ้นสุด : 10 Jun. 2021</p> -->
                                            <p class=""> <?= $Start ?> : <?= $date_start; ?></p>
                                            <p class=""> <?= $Stop ?> : <?= $date_stop; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } ?>

                </div>
            </div>
        </div>
    </div>
</section>