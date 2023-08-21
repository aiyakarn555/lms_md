<?php
$baseUrl = Yii::app()->baseUrl;
$themeBaseUrl = Yii::app()->theme->baseUrl;
$folder = explode("_", $course->course_id);
$imageShow = Yii::app()->request->baseUrl . '/uploads/courseonline/' . $folder[0] . '/original/' . $course->course_picture;
$teacher = Teacher::model()->findByPk($course->course_lecturer);
$checkLearnAll = Helpers::lib()->checkLearnAll_Questionnaire($lessonList,'pass');

?>
<link href="<?php echo $themeBaseUrl; ?>/css/jquery.wizard.css" rel="stylesheet" type="text/css">
<script src="<?php echo $themeBaseUrl; ?>/js/jquery.wizard.js"></script>
<!-- Container -->
<div id="container">

    <!-- Start Page Banner -->
    <div class="page-banner">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="text-white"><?php echo $course->course_title; ?> <?= $course->getGen($course->course_id); ?></h2>
                    <p class="grey lighten-1">โดย วิทยากร 
                    <a href="#"><?php echo (isset($teacher->teacher_name)) ? $teacher->teacher_name : '-'; ?></a>
                    </p>
                </div>
                <div class="col-md-6">
                    <ul class="breadcrumbs">
                        <li><a href="<?php echo $this->createUrl('site/index'); ?>">หน้าแรก</a></li>
                        <li><a href="<?php echo $this->createUrl('category/index'); ?>">หลักสูตร DBD Academy</a></li>
                        <li>รายละเอียดหลักสูตร</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Banner -->


    <!-- Start Content -->
    <div id="content">
        <div class="container">
        <!-- Start Step -->
                      <div class="row bg-white pd-1em">
                            <!-- Start Render Partial -->
                            <?php
                            $this->renderPartial('menu-step', array(
                                'course' => $course,
                            ));
                            ?>
                      </div>
                      <!-- End Step -->
            <div class="row blog-post-page">
                <div class="col-md-9 blog-box bg-white pd-2em">

                    

                    <!-- Classic Heading -->
                    <h4 class="classic-title"><span>บทเรียน</span></h4>

                    <div class="row">

                        <?php
                        foreach ($lessonList as $lessonListKey => $lessonListValue) {
                            $checkPreTest = Helpers::checkHavePreTestInManage($lessonListValue->id);
                            $checkPostTest = Helpers::checkHavePostTestInManage($lessonListValue->id);
                            // var_dump($checkPostTest);exit();
                            $lessonStatus = Helpers::lib()->checkLessonPass($lessonListValue);
                            $checkLessonPass = Helpers::lib()->checkLessonPass_Percent($lessonListValue);
                            $postStatus = Helpers::lib()->CheckTest($lessonListValue,"post");
                            // var_dump($postStatus);
                            $chk_test_type = Helpers::lib()->CheckTestCount('pass', $lessonListValue->id, true , false,"post");
                            ?>
                            <!-- Start Service Icon 1 -->
                            <div class="col-md-12 service-box service-icon-left-more">
                                <div class="row">
                                <div class="col-md-7">
                                    <a href="<?php echo $this->createUrl('course/learning', array('id' => $course->course_id, 'lesson_id' => $lessonListValue->id)); ?>">
                                    <div class="service-icon">
                                        <?php
                                        if ($chk_test_type != true) {
                                            $percent_learn = $checkLessonPass->percent-10;
                                        }else{
                                            $percent_learn = $checkLessonPass->percent;
                                        }
                                        ?>
                                        <input type="text" class="knob" value="<?=$percent_learn;?>" data-skin="tron" data-thickness="0.2"
                                               data-width="60" data-height="60" data-fgColor="<?=$postStatus->option['color'];?>"
                                               data-readonly="true">
                                        <!-- <i class="fa fa-circle icon-medium"></i> -->
                                    </div>
                                    <div class="service-content">
                                        
                                        <h4><?php echo $lessonListValue->title; ?></h4>
                                        <p><?php echo $lessonListValue->description; ?></p>
                                        <p><?php
                                            if ($checkLessonPass->status == "notLearn") { ?>
                                                <label style="color: <?=$checkLessonPass->color;?>">ยังไม่เข้าเรียน</label>
                                                <?php
                                            } else if ($checkLessonPass->status == "learning") {
                                                ?>
                                                <label style="color: <?=$checkLessonPass->color;?>">กำลังเรียน</label>
                                                <?php
                                            } else if ($checkLessonPass->status == "pass") {
                                                if ($chk_test_type == true) {
                                                    ?>
                                                    <label style="color: <?=$checkLessonPass->color;?>">ผ่านบทเรียน</label>
                                                    <?php
                                                } else {

                                                    ?>
                                                    <label style="color: <?=$postStatus->option['color'];?>"><?= $postStatus->value['text'].$postStatus->value['status']; ?></label>
                                                    <?php
                                                }
                                            }
                                            ?>

                                    </div>
                                </a>
                                </div>
                                <div class="col-md-5">
                                    <div class="row center border-side">
                                            <div class="col-md-6" style="background-color: rgba(248, 165, 27, 0.5);border: 4px solid #fff;">
                                                <?php 
                                                    if($checkPreTest){
                                                        $isPreTest = Helpers::isPretestState($lessonListValue->id);
                                                        if($isPreTest) {
                                                ?>
                                                <div style="padding: 38px 0;">
                                                <a href="<?php echo $this->createUrl('course/learning', array('id' => $course->course_id, 'lesson_id' => $lessonListValue->id)); ?>" class="btn btn-primary btn-sm">ทำข้อสอบก่อนเรียน</a>
                                                </div>
                                                <?php
                                                        } else {
                                                            $preStatus = Helpers::lib()->CheckTest($lessonListValue,"pre"); 
                                                            ?>
                                                <ul class="list-unstyled">
                                                    <li><strong>ผลสอบก่อนเรียน</strong></li>
                                                    <li><h3 class="text-success"><?= $preStatus->value['score']; ?> คะแนน</h3></li>
                                                    <div class="line"></div>
                                                    <li>คะแนนเต็ม <?= $preStatus->value['total']; ?></li>
                                                </ul>
                                                            <?php
                                                        }
                                                    } else {
                                                ?>
                                                <div style="padding: 38px 0;">
                                                <a href="javascript:void(0);" class="">ไม่มีข้อสอบก่อนเรียน</a>
                                                </div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <div class="col-md-6" style="background-color: rgba(248, 165, 27, 0.5);border: 4px solid #fff;">
                                                <?php 
                                                    if($checkPostTest) { 
                                                        $isPostTest = Helpers::isPosttestState($lessonListValue->id);
                                                        if($isPostTest) {
                                                            if($lessonStatus != 'pass') {
                                                                $link = 'javascript:void(0);';
                                                                $alert = 'alertswal();';
                                                            } else {
                                                                $link = $this->createUrl('question/index', array('id' => $lessonListValue->id));
                                                                $alert = '';
                                                            }
                                                            ?>
                                                <div style="padding: 38px 0;">
                                                <a href="<?= $link ?>" <?= $alert != '' ? 'onclick="'.$alert.'"' : ''; ?> class="btn btn-primary btn-sm">ทำข้อสอบหลังเรียน</a>
                                                </div>
                                                            <?php
                                                        } else {
                                                            $postStatus = Helpers::lib()->CheckTest($lessonListValue,"post");
                                                ?>
                                                <ul class="list-unstyled">
                                                    <li><strong>ผลสอบหลังเรียน</strong></li>
                                                    <li><h3 class="text-success"><?= $postStatus->value['score']; ?> คะแนน</h3></li>
                                                    <div class="line"></div>
                                                    <li>คะแนนเต็ม <?= $postStatus->value['total']; ?></li>
                                                </ul>
                                                <?php }
                                                    } else { 
                                                ?>
                                                <a href="javascript:void(0);" class="">ไม่มีข้อสอบหลังเรียน</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            </div>
                            <!-- End Service Icon 1 -->
                            <?php
                        }
                        ?>
                    </div>


                </div>




                <div class="col-md-3 sidebar right-sidebar bg-white50 pd-1em">
                    <div class="row mb-1em">
                        <div class="col-md-12">
                            <a href="javascript:history.go(-1)" class="btn btn-warning center-block"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                                ย้อนกลับ</a>
                        </div>
                    </div>

                    <!-- Toggle -->
                    <!-- Sidebar -->
                    <?php
                    echo $this->renderPartial('_right_course', array(
                        'lessonCurrent'=>$lessonCurrent,
                        'lessonList'=>$lessonList,
                        'course'=>$course,
                        'courseTec'=>$courseTec,
                        'model_cate'=>$model_cate,
                    ));
                    ?>
                    <!--End sidebar-->
                    <!-- End Toggle -->
                </div>


            </div>

        </div>
    </div>
    <!-- End content -->

</div>
<!-- End Container -->

<!-- Go To Top Link -->
<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>
<div id="loader1">
    <div class="spinner">
      <div class="dot1"></div>
      <div class="dot2"></div>
    </div>
  </div>

<script>

    function alertswal(){
        swal("คำเตือน", "กรุณาเรียนให้ผ่านก่อนสอบหลังเรียน", "error");
    }

    function showNotice(coursetype) {
        if(coursetype != null && coursetype == '36') {
            swal({
                title: "คำเตือน",
                text: "หากช่วงเวลาการเข้าระบบ (Login) พร้อมกันในหลายวิชา <br> กรมฯ จะนับ CPD ให้ท่าน<span style='color: red;'>เพียงวิชาเดียว</span>เท่านั้น",
                type: "info",
                html: true,
                showCancelButton: false,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ยืนยัน",
                closeOnConfirm: true
                },function() {
                    //do something
                });
        } else {
            console.log(coursetype);
        }
    }

    function checkPermissionBeforeLearn(course, type) {
        $.post("<?= $this->createUrl("CourseStart/Permission") ?>", { course: course },
            function(respon) {
                var jsonRespon = JSON.parse(respon);
                if(type == '36') {
                    if(jsonRespon.status) {
                        switch (jsonRespon.status) {
                            case 99:
                                swal({
                                    title: "คำเตือน",
                                    text: jsonRespon.errormsg,
                                    type: "warning",
                                    showCancelButton: false,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText: "ยืนยัน",
                                    closeOnConfirm: false
                                    },
                                    function(){
                                        showNotice(jsonRespon.coursetype);
                                    });
                                break;
                            case 1:
                                swal({
                                    title: "ยินดีต้อนรับ",
                                    text: jsonRespon.errormsg,
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText: "ยืนยัน",
                                    closeOnConfirm: false
                                    },
                                    function(){
                                        showNotice(jsonRespon.coursetype);
                                    });
                                break;
                        }
                    }
                } else {
                    if(jsonRespon.status) {
                        switch (jsonRespon.status) {
                            case 99:
                                swal({
                                    title: "คำเตือน",
                                    text: jsonRespon.errormsg,
                                    type: "warning",
                                    showCancelButton: false,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText: "ยืนยัน",
                                    closeOnConfirm: true
                                    },
                                    function(){
                                    });
                                break;
                            case 1:
                                swal({
                                    title: "ยินดีต้อนรับ",
                                    text: jsonRespon.errormsg,
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonColor: "#DD6B55",
                                    confirmButtonText: "ยืนยัน",
                                    closeOnConfirm: true
                                    },
                                    function(){
                                    });
                                break;
                        }
                    }
                }
            }
        );
    }

    $(window).load(function() {
        console.log($('#loader1'));
    });
    $(function () {

        $('#loader1').hide();
       //check permission and show pop-up
        checkPermissionBeforeLearn('<?= $course->course_id ?>', '<?= $course->cate_id ?>');

        /* jQueryKnob */

        $(".knob").knob({
            draw: function () {
                // "tron" case
                if (this.$.data('skin') == 'tron') {
                    var a = this.angle(this.cv)  // Angle
                        , sa = this.startAngle          // Previous start angle
                        , sat = this.startAngle         // Start angle
                        , ea                            // Previous end angle
                        , eat = sat + a                 // End angle
                        , r = true;

                    this.g.lineWidth = this.lineWidth;

                    this.o.cursor
                    && (sat = eat - 0.3)
                    && (eat = eat + 0.3);

                    if (this.o.displayPrevious) {
                        ea = this.startAngle + this.angle(this.value);
                        this.o.cursor
                        && (sa = ea - 0.3)
                        && (ea = ea + 0.3);
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


</script>