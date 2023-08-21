<style type="text/css">
    ul.course-all {
        list-style: disc;
        -webkit-padding-start: 0px !important;
    }
    .sidebar .widget-popular-posts .widget-content span {
    color: none;
    }
    .sideBarFinalTestBtn { line-height: 24px; width: 100%; margin: 0 auto; font-size: 22px; }
    .passFinalTest { color: #8BC34A; }
    .notPassFinalTest { color: #f44336;  }
    .pd-content {
        padding-top: 0.5em;
        padding-bottom: 0.5em;
    }
    .navbar-fixed-bottom, .navbar-fixed-top {
        z-index: 9999999;
    }
</style>
<?php 
$questionnaireChk = 0;
$lessonNum = 0;
$userid = Yii::app()->user->id;
            if($userid) {
                $model = User::model()->findByPk($userid);
                $profile = $model->profile;
            } else {
                $model = new User;
            }
?>

<div class="modal fade" id="modal-CPD-accounting">
  <div class="modal-dialog">
    <?php
      $form = $this->beginWidget('UActiveForm', array(
          'id'=>'cpd-learning-form',
          'action'=>Yii::app()->createUrl('//cpdlearning/create'),
          'enableAjaxValidation'=>true,
          'enableClientValidation'=>true,
          'clientOptions'=>array(
              'validateOnSubmit'=>true,
              'validateOnChange'=>false,
          ),
          'htmlOptions' => array(
              'enctype'=>'multipart/form-data'
          ),
      ));
    ?>
    <div class="modal-content"> 
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle text-white" aria-hidden="true"></i></button> -->
                <h4 class="modal-title text-white"><i class="fa fa-lock" aria-hidden="true"></i>
                    การยืนยันหลักสูตรพิเศษ</h4>
            </div>
            <div class="modal-body"
                 style="padding: 4em 0;background: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/books.png);">
                <div class="row" id="form-login">
                    <div class="col-md-8 col-md-offset-2">             
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;padding: 0.5em">
                            <?php 
                            $cpd=new CpdLearning;
                            $registor = new RegistrationForm;
                            $registor->id = $model->id;
                            echo Controller::ImageShowUser(Yush::SIZE_THUMB, $cpd, $cpd->pic_id_card, $registor, array('class' => 'picture-src', 'id' => 'wizardPicturePreview')); ?>
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                            <div class="form-group">
                            <label><p>กรุณาตรวจสอบข้อมูลส่วนตัว</p></label><br>
                            <?php echo $form->labelEx($model,'bookkeeper_id') ?>
                            <?php echo $form->textField($model,'bookkeeper_id',array('class'=>'form-control')) ?>
                            <label><p>กรุณาเลือกรูปบัตรประชาชน</p></label><br>
                              <span class="btn btn-success btn-small btn-file"><span class="fileinput-new">เลือกรูปภาพ</span><span class="fileinput-exists">เปลี่ยน</span><?php echo $form->fileField($cpd, 'pic_file', array('id' => 'wizard-picture')); ?></span>
                              <a href="#" class="btn btn-danger btn-small fileinput-exists" data-dismiss="fileinput">ลบ</a>
                              <span><h5 style="color: red">รองรับไฟล์รูปนามสกุล jpg, png, gif เท่านั้น</h5></span>
                            <?php echo $form->textField($cpd,'course_id',array(
                                    'hidden'=>'hidden','id'=>'accounting'
                                )) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php echo CHtml::submitButton('ยืนยัน', array('class' => 'btn btn-sm', 'style' => 'font-size:20px;')); ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            </div>
      </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<div class="modal fade" id="modal-CPD-exam">
  <div class="modal-dialog">
    <?php
      $form = $this->beginWidget('UActiveForm', array(
          'id'=>'cpd-learning-form',
          'action'=>Yii::app()->createUrl('//cpdlearning/create'),
          'enableAjaxValidation'=>true,
          'enableClientValidation'=>true,
          'clientOptions'=>array(
              'validateOnSubmit'=>true,
              'validateOnChange'=>false,
          ),
          'htmlOptions' => array(
              'enctype'=>'multipart/form-data'
          ),
      ));
    ?>
    <div class="modal-content"> 
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle text-white" aria-hidden="true"></i></button> -->
                <h4 class="modal-title text-white"><i class="fa fa-lock" aria-hidden="true"></i>
                    การยืนยันหลักสูตรพิเศษ</h4>
            </div>
            <div class="modal-body"
                 style="padding: 4em 0;background: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/books.png);">
                <div class="row" id="form-login">
                    <div class="col-md-8 col-md-offset-2">             
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;padding: 0.5em">
                            <?php 
                            $cpd=new CpdLearning;
                            $registor = new RegistrationForm;
                            $registor->id = $model->id;
                            echo Controller::ImageShowUser(Yush::SIZE_THUMB, $cpd, $cpd->pic_id_card, $registor, array('class' => 'picture-src', 'id' => 'wizardPicturePreview')); ?>
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                            <div class="form-group">
                            <label><p>กรุณาตรวจสอบข้อมูลส่วนตัว</p></label><br>
                            <?php echo $form->labelEx($model,'auditor_id') ?>
                            <?php echo $form->textField($model,'auditor_id',array('class'=>'form-control')) ?>
                            <label><p>กรุณาเลือกรูปบัตรประชาชน</p></label><br>
                              <span class="btn btn-success btn-small btn-file"><span class="fileinput-new">เลือกรูปภาพ</span><span class="fileinput-exists">เปลี่ยน</span><?php echo $form->fileField($cpd, 'pic_file', array('id' => 'wizard-picture')); ?></span>
                              <a href="#" class="btn btn-danger btn-small fileinput-exists" data-dismiss="fileinput">ลบ</a>
                              <span><h5 style="color: red">รองรับไฟล์รูปนามสกุล jpg, png, gif เท่านั้น</h5></span>
                            <?php echo $form->textField($cpd,'course_id',array(
                                    'hidden'=>'hidden','id'=>'exam'
                                )) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php echo CHtml::submitButton('ยืนยัน', array('class' => 'btn btn-sm', 'style' => 'font-size:20px;')); ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            </div>
      </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<div class="modal fade" id="modal-CPD-accounting-exam">
  <div class="modal-dialog">
    <?php
      $form = $this->beginWidget('UActiveForm', array(
          'id'=>'cpd-learning-form',
          'action'=>Yii::app()->createUrl('//cpdlearning/create'),
          'enableAjaxValidation'=>true,
          'enableClientValidation'=>true,
          'clientOptions'=>array(
              'validateOnSubmit'=>true,
              'validateOnChange'=>false,
          ),
          'htmlOptions' => array(
              'enctype'=>'multipart/form-data'
          ),
      ));
    ?>
    <div class="modal-content"> 
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle text-white" aria-hidden="true"></i></button> -->
                <h4 class="modal-title text-white"><i class="fa fa-lock" aria-hidden="true"></i>
                    การยืนยันหลักสูตรพิเศษ</h4>
            </div>
            <div class="modal-body" style="padding: 4em 0;background: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/books.png);">
                <div class="row" id="form-login">
                    <div class="col-md-8 col-md-offset-2">             
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;padding: 0.5em">
                            <?php 
                            $cpd=new CpdLearning;
                            $registor = new RegistrationForm;
                            $registor->id = $model->id;
                            echo Controller::ImageShowUser(Yush::SIZE_THUMB, $cpd, $cpd->pic_id_card, $registor, array('class' => 'picture-src', 'id' => 'wizardPicturePreview')); ?>
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                            <div class="form-group">
                            <label><p>กรุณาตรวจสอบข้อมูลส่วนตัว</p></label><br>
                            <?php echo $form->labelEx($model,'auditor_id') ?>
                            <?php echo $form->textField($model,'auditor_id',array('class'=>'form-control')) ?>
                            <?php echo $form->labelEx($model,'bookkeeper_id') ?>
                            <?php echo $form->textField($model,'bookkeeper_id',array('class'=>'form-control')) ?>
                            <label><p>กรุณาเลือกรูปบัตรประชาชน</p></label><br>
                              <span class="btn btn-success btn-small btn-file"><span class="fileinput-new">เลือกรูปภาพ</span><span class="fileinput-exists">เปลี่ยน</span><?php echo $form->fileField($cpd, 'pic_file', array('id' => 'wizard-picture')); ?></span>
                              <a href="#" class="btn btn-danger btn-small fileinput-exists" data-dismiss="fileinput">ลบ</a>
                              <span><h5 style="color: red">รองรับไฟล์รูปนามสกุล jpg, png, gif เท่านั้น</h5></span>
                            <?php echo $form->textField($cpd,'course_id',array(
                                    'hidden'=>'hidden','id'=>'accounting-exam'
                                )) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php echo CHtml::submitButton('ยืนยัน', array('class' => 'btn btn-sm', 'style' => 'font-size:20px;')); ?>
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
            </div>
      </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<div class="panel-group">
    <!-- Start สรุปผลการเรียน -->
    <div class="course-popular">
    <div class="page-header">
        <h3><span class="inline"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/course-popular.png" class="img-responsive" alt=""></span> <?= $label->label_resultFinal ?></h3>
    </div>
    
    <div class="panel panel-default text-center border-row-bottom">
<!--        <div class="panel-heading">
            <h3 class="panel-title">
                <a data-toggle="collapse" data-parent="#toggle" href="#collapse-9">
                    <i class="fa fa-angle-down control-icon"></i>
                    <i class="fa fa-pie-chart"></i> ผลการสอบ Final
                </a>
            </h3>
            
        </div>-->

        <div id="collapse-9" class="panel-collapse collapse in pd-1em" style="    padding: 1em;">
          <?php 
            $courseTec = CourseTeacher::model()->findAllByAttributes(array('course_id'=>$course->course_id));
            $chkCourse = Helpers::lib()->checkCoursePass($course->course_id);
            $chkHaveCourseTest = Helpers::lib()->checkHaveCourseTestInManage($course->course_id);
//            $checkCourseTest = Helpers::lib()->checkTestCourse($course);
            $chkQ = Helpers::lib()->checkCourseQuesALl($course->course_id);
            $chkQuesAndNotHave = Helpers::lib()->checkCourseQuestion($course->course_id);
            $checkTypeCourse = Helpers::lib()->checkTypeCourse($course->cate_id);
            $notShowScore = '<input type="text" class="knob" value="0" data-skin="tron" data-thickness="0.2" data-width="65" data-height="65" data-fgColor="#28cbff" data-readonly="true">';
            
            $criteria = new CDbCriteria;
            $criteria->condition = ' course_id="' . $course->course_id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL and active ="y"';
            $criteria->order = 'create_date ASC';

            $allFinalTest = Coursescore::model()->findAll($criteria);
          
          ?>
            <?php if($allFinalTest) {
                $passed = false;
                foreach($allFinalTest as $ii => $FinalTest) {
                    $percent = number_format(($FinalTest->score_number/$FinalTest->score_total)*100,0);
                    $score_number = ($FinalTest->score_number>0)?$FinalTest->score_number:0;
                    $score_total = ($FinalTest->score_total>0)?$FinalTest->score_total:0;
                    $score_status = ($percent>=60)?'<i class="fa fa-check" aria-hidden="true"></i>'. $label->label_Pass:'<i class="fa fa-close" aria-hidden="true"></i>'.$label->label_Fail;
                    if($FinalTest->score_past == 'y') {
                        $passed = true;
                    }
            ?>
                <div class="pd-content row">
                    <div class="col-md-12">
                        <p style="font-size: 18px;padding: 4px 10px;line-height: 20px;background: #03737d;color: #fff;font-weight: 900;"><?= $label->label_testFinalTimes ?> <?= $ii+1 ?></p>
                    </div>
                    <div class="col-md-12" style="padding-top: 15px;">
                        <div class="col-md-6">
                            <div class="center">
                                <input type="text" class="knob" value="<?= $percent ?>" data-skin="tron" data-thickness="0.2" data-width="100%" data-height="100%" data-fgColor="#28cbff" data-readonly="true" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h1 class="center"><?= $score_number ?> / <?= $score_total ?></h1>
                            <hr style="margin-top: 5px; margin-bottom: 5px;">
                            <h5 class="center sideBarFinalTestBtn <?= ($percent>=60)?'passFinalTest':'notPassFinalTest' ?>"><?= $score_status ?></h5>
                        </div>
                    </div>
                </div>
            <?php }

                } else {
                    $checkQuestinaireOnCourse = CourseTeacher::model()->findAllByAttributes(array('course_id' => $course->course_id));
                    $checkAnswerYet = false;
                    if($checkQuestinaireOnCourse) {
                        $num = 0;
                        foreach($checkQuestinaireOnCourse as $cnt => $survey) {
                            $findQuestAnswer = QQuestAns_course::model()->findByAttributes(array(
                                        'user_id' => Yii::app()->user->id,
                                        'header_id' => $survey->survey_header_id,
                                        'course_id' => $course->course_id,
                                    ));
                            if($findQuestAnswer) {
                                $num++;
                            }
                        }
                        if($num == count($checkQuestinaireOnCourse)) {
                            $checkAnswerYet = true;
                        }
                    }
                    if($checkAnswerYet && ($chkCourse=='pass')) {
                        ?>
                        <div class="pd-content row" style="border-bottom: none;">
                          <a href="<?php echo $this->createUrl('/course/final', array('id' => $course->course_id)); ?>">
                            <div class="col-md-12" style="padding-top: 15px;">
                                <div class="col-md-12">
                                    <i class="fa fa-pencil fa-5x text-success"></i>
                                    <h1 class="center"><?= $label->label_permisToTestFinal ?></h1>
                                    <hr style="margin-top: 5px; margin-bottom: 5px;">
                                </div>
                            </div>
                          </a>
                        </div>
                        <?php
                    } else { ?>
                        <div class="pd-content row" style="border-bottom: none;">
                            <div class="col-md-12" style="padding-top: 15px;">
                                <div class="col-md-12">
                                    <i class="fa fa-warning fa-5x text-danger"></i>
                                    <h1 class="center"><?= $label->label_NoPermisToTestFinal ?></h1>
                                    <hr style="margin-top: 5px; margin-bottom: 5px;">
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                }
                if(!$passed && count($allFinalTest) == 1) {
                        ?>
                        <div class="pd-content row">
                        <a class="btn btn-default" href="<?= $this->createUrl('coursequestion/index', array('id' => $course->course_id)) ?>" target="_self"><i class="fa fa-pencil-square"></i> <?= $label->label_testFinalTimes ?> 2</a>
                        </div>
                        <?php
                    }
                if($checkTypeCourse) {
                  if(!$passed && count($allFinalTest) == 2) {
                        ?>
                        <!-- <div class="pd-content row">
                        <a  href="javascript:void(0)" onclick="comfirmResetLearn(<?= $course->id ?>)" class="btn btn-danger center-block mt-05em btn-sm"><i class="fa fa-times-circle" aria-hidden="true"></i> ยกเลิกการเรียน</a>
                        </div> -->
                        <?php
                  }
                } else {
                        ?>
                        <!-- <div class="pd-content row">
                        <a  href="javascript:void(0)" onclick="comfirmResetLearn(<?= $course->id ?>)" class="btn btn-danger center-block mt-05em btn-sm"><i class="fa fa-times-circle" aria-hidden="true"></i> ยกเลิกการเรียน</a>
                        </div> -->
                        <?php
                }
//                if($passed) {
                        ?>
<!--                        <div class="pd-content row">
                        <a class="btn btn-default" href="<?= $this->createUrl('course/certificate', array('id' => $course->course_id)) ?>" target="_self"><i class="fa fa-print"></i> พิมพ์หนังสือรับรอง CPD</a>
                        </div>-->
                        <?php
//                    }
            ?>
            <!-- if need reverse copy from _right_course_bk.php -->
        </div>
    </div>
    </div>
    <!-- End สรุปผลการเรียน -->

    <!-- move to _right_course_bk.php -->
    <!-- แบบสอบถาม -->
    <!-- move to _right_course_bk.php -->

    <!-- Start Toggle 3 -->
    <!-- <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#toggle" href="#collapse-7">
                    <i class="fa fa-angle-up control-icon"></i>
                    <i class="fa fa-user"></i> ผู้สอน
                </a>
            </h4>
        </div>
        <div id="collapse-7" class="panel-collapse collapse in">
            <?php

            foreach ($courseTec as $key => $value) {
                $data = Teacher::model()->findByPk($value->teacher_id);
                ?>
                <div class="panel-body">
                    <div class="img-teacher">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/client-thumb/4.png"
                             alt="" class="center-block">
                    </div>
                    <dl class="dl-horizontal">
                        <dt>ชื่อวิทยากร :</dt>
                        <dd><?= $data->teacher_name ?></dd>
                        <dt>ตำแหน่ง :</dt>
                        <dd><?= $data->teacher_position ?></dd>
                        <?php
                        if(Helpers::lib()->checkLearnAll($lessonList,"pass")){
                            ?>
                            <?php
                            echo CHtml::link('<i class="fa fa-bar-chart"></i>ทำแบบสอบถาม', array('//questionnaire_course/index', 'id' => $value->id),array('class'=>'btn btn-default center-block'));
                            ?>
                            <?php
                        }
                        ?>
                    </dl>
                </div>

            <?php } ?>
        </div>
    </div> -->
    <!-- End Toggle 3 -->
    <!--  -->
    <?php 
                $criteria=new CDbCriteria;
                $criteria->compare('active',"y");
                $criteria->compare('status',"1");
                $criteria->compare('recommend',"y");
                $courseRecommend = CourseOnline::model()->findAll($criteria);
                if($courseRecommend):
                ?>
                <!-- <div class="course-popular">
                    <div class="page-header">
                        <h3><span class="inline"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/course-popular.png" class="img-responsive" alt=""></span> หลักสูตรแนะนำ</h3>
                    </div>
                    <div class="well">
                        <ul class="list-unstyled">
                            <?php 

                            foreach ($courseRecommend as $key => $value) { ?>
                            <li><a href="<?php echo $this->createUrl('/course/detail', array('id' => $value->course_id)); ?>">
                                <span class="pull-right"><strong style="font-size: 19px;"><?php echo ($value->course_title) ?></strong></span>
                                <div class="popular-img" style="background-image: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/book.png);"></div>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div> -->
    <?php endif; ?>
    <!--  -->
</div>

<script type="text/javascript">
$(document).ready(function(){
  $(".course-all-carousel").owlCarousel({
    items : 1,
    navigation : true,
    pagination: false,
  });
});
</script>

<script>
  function comfirmIdCard(detail,cpd_id,cpd_pic,bookkeeper_id,auditor_id){

  swal({
    html: true,
    title: "กรุณาตรวจสอบข้อมูลส่วนตัวและรูปบัตรประชาชน",
    <?php if($profile->type_user == 2) { ?>
      text: "ข้อมูลส่วนตัวและรูปบัตรประชาชนของคุณ ถูกต้องหรือไม่ ?<br>"+
      "<strong>รหัสผู้ทำบัญชี: </strong>"+bookkeeper_id,
    <?php } else if($profile->type_user == 3) { ?>
      text: "ข้อมูลส่วนตัวและรูปบัตรประชาชนของคุณ ถูกต้องหรือไม่ ?<br>"+
      "<strong>เลขทะเบียนผู้สอบบัญชี: </strong>"+auditor_id,
    <?php } else if($profile->type_user == 4) { ?>
      text: "ข้อมูลส่วนตัวและรูปบัตรประชาชนของคุณ ถูกต้องหรือไม่ ?<br>"+
      "<strong>เลขทะเบียนผู้สอบบัญชี: </strong>"+auditor_id+"<br>"+
      "<strong>รหัสผู้ทำบัญชี: </strong>"+bookkeeper_id,
    <?php } ?>
    showCancelButton: true,
    imageUrl: "<?php echo Yii::app()->request->baseUrl; ?>/uploads/cpdlearning/"+cpd_id+"/original/"+cpd_pic,
    imageSize: "200x200",
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "ถูกต้อง!",
    cancelButtonText: "ไม่ถูกต้อง!",
    closeOnConfirm: false,
    closeOnCancel: true
  },
  function(isConfirm){
    if (isConfirm) {
      window.location.href = "<?= $this->createUrl('/course/detail/'); ?>"+'/'+detail;
      // swal("Deleted!", "Your imaginary file has been deleted.", "success");
    } else {
      window.location.href = "<?= $this->createUrl('/cpdlearning/cpddelete/'); ?>"+'/'+cpd_id;
    }

  });
}
</script>

<script>
  function AlertCardID(val){
    // $(window).load(function () {
            $('#modal-CPD').modal({backdrop: 'static', keyboard: false});
            // 
            <?php if($profile->type_user == 2) { ?>
            $('#modal-CPD-accounting').modal('show');
            document.getElementById("accounting").value = val;
            <?php } else if($profile->type_user == 3) { ?>
            $('#modal-CPD-exam').modal('show');
            document.getElementById("exam").value = val;
            <?php } else if($profile->type_user == 4) { ?>
            $('#modal-CPD-accounting-exam').modal('show');
            document.getElementById("accounting-exam").value = val;
            <?php } ?>
        // });
  }
  function comfirmResetLearn(course_id){

    swal({
        html: true,
        title: "กรุณายืนยันการรีเซ็ตการเรียน",
        text: "คุณต้องการรีเซ็ตการเรียนวิชานี้ใช่หรือไม่ ?",
        showCancelButton: true,
        imageSize: "200x200",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "ตกลง!",
        cancelButtonText: "ย้อนกลับ!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm){
        if (isConfirm) {
        window.location.href = "<?= $this->createUrl('/course/resetLearn/'); ?>"+'/'+course_id;
        // swal("Deleted!", "Your imaginary file has been deleted.", "success");
        } else {
        return false;
        }

    });
}
</script>