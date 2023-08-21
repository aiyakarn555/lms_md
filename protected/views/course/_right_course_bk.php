<style type="text/css">
    ul.course-all {
        list-style: disc;
        -webkit-padding-start: 0px !important;
    }
    .sidebar .widget-popular-posts .widget-content span {
    color: none;
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
                 style="padding: 4em 0;background: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/books.png"
                 );
            ">
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
                 style="padding: 4em 0;background: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/books.png"
                 );
            ">
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
            <div class="modal-body"
                 style="padding: 4em 0;background: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/books.png"
                 );
            ">
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
    <div class="panel panel-default text-center border-row-bottom">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#toggle" href="#collapse-9">
                    <i class="fa fa-angle-down control-icon"></i>
                    <i class="fa fa-pie-chart"></i> ผลการสอบ Final
                </a>
            </h4>
        </div>
        <div id="collapse-9" class="panel-collapse collapse in pd-1em">
          <?php 
            $courseTec = CourseTeacher::model()->findAllByAttributes(array('course_id'=>$course->course_id));
            $chkCourse = Helpers::lib()->checkCoursePass($course->course_id);
            $chkHaveCourseTest = Helpers::lib()->checkHaveCourseTestInManage($course->course_id);
            $checkCourseTest = Helpers::lib()->checkTestCourse($course);
            $chkQ = Helpers::lib()->checkCourseQuesALl($course->course_id);
            $chkQuesAndNotHave = Helpers::lib()->checkCourseQuestion($course->course_id);
            $notShowScore = '<input type="text" class="knob" value="0" data-skin="tron" data-thickness="0.2" data-width="65" data-height="65" data-fgColor="#28cbff" data-readonly="true">';
          ?>
            <div class="row pd-content">
                <div class="col-md-5">
                    <?php 
                    if(!$chkQuesAndNotHave) {
                      echo $notShowScore;
                    } else if($chkHaveCourseTest){
                      if($chkCourse == 'pass'){
                        if($checkCourseTest->value['boolean']){
                          echo '<input type="text" class="knob" value="'.$checkCourseTest->value['percent'].'" data-skin="tron" data-thickness="0.2" data-width="65" data-height="65" data-fgColor="#28cbff" data-readonly="true">';
                        } else {
                          echo $notShowScore;
                        }
                      } else {
                        echo $notShowScore;
                      }
                    } else {
                      echo $notShowScore;
                    }
                    ?>
                    
                </div>
                <div class="col-md-7">
                    <?php 
                    echo '<p>แบบทดสอบ Final</p>';
                    echo '<hr style="margin-top: 10px; margin-bottom: 5px;">';
                    if(!$chkQuesAndNotHave) {
                      echo 'ยังไม่ทำแบบสอบถาม';
                    } else if($chkHaveCourseTest){
                      if($chkCourse == 'pass'){
                        if($checkCourseTest->value['boolean']){
                          echo '<h1 class="center">'.$checkCourseTest->value['score'].' / '.$checkCourseTest->value['total'].$checkCourseTest->value['status'].'</h1>';
                        } else {
                          echo 'ยังไมทำแบบทดสอบ';
                        }
                      } else {
                        echo '<p>แบบทดสอบ Final</p>';
                        echo '<hr style="margin-top: 10px; margin-bottom: 5px;">';
                        echo 'ยังไม่มีสิทธ์ทำแบบทดสอบ';
                      }
                    } else {
                      echo '<p>แบบทดสอบ Final</p>';
                      echo '<hr style="margin-top: 10px; margin-bottom: 5px;">';
                      echo 'ไม่มีข้อสอบหลักสูตร';
                    }
                    ?>
                    <!-- <p>แบบทดสอบ Final</p>
                    <hr style="margin-top: 10px; margin-bottom: 5px;">
                    <h1 class="center">40 / 100</h1> -->
                </div>
            </div>
            <div class="row pd-content">
                <div class="col-md-12 center">
                <?php 
                  if(!$chkQuesAndNotHave) {
                    echo '<a href="javascript:void(0);" class="btn btn-warning btn-sm btn-block" role="button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ยังไม่มีสิทธ์ทำแบบทดสอบ</a>';
                  } else if($chkHaveCourseTest){
                    if($chkCourse == 'pass'){
                          echo '<a href="'.$this->createUrl("coursequestion/index", array("id" => $course->id)).'" class="btn btn-warning btn-sm btn-block" role="button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> สอบ Final</a>';
                      } else {
                        echo '<a href="javascript:void(0);" class="btn btn-warning btn-sm btn-block" role="button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ยังไม่มีสิทธ์ทำแบบทดสอบ Final</a>';
                      }
                  } else {
                    echo '<a href="javascript:void(0);" class="btn btn-warning btn-sm btn-block" role="button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> ไม่มีแบบทดสอบ Final</a>';
                  }
                ?>
                    <!-- <a href="#" class="btn btn-success btn-sm btn-block" role="button"><i class="fa fa-print" aria-hidden="true"></i> พิมพ์ใบประกาศ</a> -->
                </div>
            </div>
            
                
        </div>
    </div>
    <!-- End สรุปผลการเรียน -->

    <!-- Start ความรู้เบื้องต้นด้านพาณิชอิเล็กทรอนิกส์ -->
    <div class="panel panel-default text-center border-row-bottom">
    <?php 
              foreach ($lessonList as $lessonListKey => $lessonListValue) {
                $lessonNum++;
                $checkLessonPass = Helpers::lib()->checkLessonPass_Percent($lessonListValue);
                $checkPreTest = Helpers::checkHavePreTestInManage($lessonListValue->id);
                $checkPostTest = Helpers::checkHavePostTestInManage($lessonListValue->id);
                $chk_test_type = Helpers::lib()->CheckTestCount('pass', $lessonListValue->id, true , false,"post");
                ?>
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#toggle" href="#collapse-second">
                    <i class="fa fa-angle-down control-icon"></i>
                    <i class="fa fa-line-chart" aria-hidden="true"></i> <?php echo $lessonListValue->title; ?>
                </a>
            </h4>
        </div>
        <div id="collapse-second" class="panel-collapse collapse in pd-1em">
        
          <div class="row pd-content">
                <div class="col-md-12">
                <ul class="list-unstyled text-left">
                  <li>ผลสอบก่อนเรียน
                  <?php 
                    if($checkPreTest) { 
                      $isPreTest = Helpers::isPretestState($lessonListValue->id);
                      if($isPreTest) {  
                        echo '<strong class="pull-right text-primary">ยังไม่ทำแบบทดสอบ';
                      } else { 
                      $preStatus = Helpers::lib()->CheckTest($lessonListValue,"pre");
                      echo '<strong class="pull-right text-success">'.$preStatus->value['score'].' จาก '. $preStatus->value['total'].' คะแนน';
                      } 
                    } else { 
                      echo '<strong class="pull-right text-danger">ไม่มีแบบทดสอบ';
                    } 
                  ?>
                  </strong></li>
                  <li>สถานะการเรียน
                  <?php
                    if ($checkLessonPass->status == "notLearn") {
                      echo '<strong class="pull-right text-primary">ยังไม่เข้าเรียน';
                    } else if ($checkLessonPass->status == "learning") {
                      echo '<strong class="pull-right text-danger">กำลังเรียน';
                    } else if ($checkLessonPass->status == "pass") {
                      if ($chk_test_type == true) {
                        $questionnaireChk++;
                        echo '<strong class="pull-right text-success">ผ่านบทเรียน';
                      } else {
                        echo '<strong class="pull-right text-danger">ยังไม่สอบหลังเรียน';
                      }
                    }
                  ?>
                  </strong></li>
                  <li>ผลสอบหลังเรียน
                  <?php 
                    if($checkPostTest){
                      $isPostTest = Helpers::isPosttestState($lessonListValue->id);
                      if($isPostTest) {
                        echo '<strong class="pull-right text-primary">ยังไม่ทำแบบทดสอบ';
                      } else {
                        $postStatus = Helpers::lib()->CheckTest($lessonListValue,"post");
                        echo '<strong class="pull-right text-success">'.$postStatus->value['score'].' จาก '. $postStatus->value['total'].' คะแนน';
                      }
                    } else {
                      echo '<strong class="pull-right text-danger">ไม่มีแบบทดสอบ';
                    }
                  ?>
                  </strong></li>
                </ul>
                </div>
          </div>
          
        </div>
        <?php
              }
            ?>
    </div>
    <!-- End ความรู้เบื้องต้นด้านพาณิชอิเล็กทรอนิกส์ -->

    <!-- Start แบบสอบถาม -->
    <?php 
      if($lessonNum == $questionnaireChk) { 
        $i = 1;
    ?>
    <div class="panel panel-default">
        <div class="panel-heading" style="position: relative;">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#toggle" href="#collapse-questionnaire">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แบบสอบถาม
                </a>
            </h4>
            <div style="top: 0;margin: 16px 0px;right: 8px;"><center>
              <?php 
                if($chkQ) {
                      echo 'ทำแบบสอบถามหลักสูตรเรียบร้อย';
                    }
                foreach ($courseTec as $key => $value) {
                  $questAns = QQuestAns_course::model()->find("user_id='" . Yii::app()->user->id . "' AND course_id='" . $course->course_id . "' AND header_id='" . $value->survey_header_id . "' AND teacher_id='" . $value->teacher_id . "'");
                  if (!$questAns) {
                  ?>
              <a class="btn btn-warning btn-sm" href="<?php echo $this->createUrl('questionnaire_course/index', array('id' => $value->id)); ?>" role="button">ทำแบบสอบถามที่ <?= $i ?></a>
                  <?php 
                  $i++;
                  }
                }
                if(!$courseTec){
                  echo 'ไม่มีแบบสอบถามหลักสูตร';
                }
              ?>
            </center></div>
             
        </div>
        <div id="collapse-questionnaire" class="panel-collapse collapse in">
        </div>
    </div>
    <?php } ?>
    <!-- End แบบสอบถาม -->
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
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#toggle" href="#collapse-8">
                    <i class="fa fa-angle-up control-icon"></i>
                    <i class="fa fa-book"></i> หลักสูตรทั้งหมด
                </a>
            </h4>
        </div>
        <div id="collapse-8" class="panel-collapse collapse in pd-1em">
            <div class="widget widget-popular-posts">
            <?php 
        foreach ($model_cate as $key => $cate) {
            ?>
            <h4><?= $cate->cate_title ?> <span class="head-line"></span></h4>

              <div class="latest-posts-classic course-all-carousel touch-carousel" data-appeared-items="2">

              
            <?php
            $course = CourseOnline::model()->findAllByAttributes(array('cate_id'=>$cate->cate_id,'status'=>1));
            $i = 0;
            foreach ($course as $key => $value) {
              if(!Yii::app()->user->isGuest) {
              $userid = Yii::app()->user->id;
              $cpd = CpdLearning::model()->findByAttributes(array('user_id'=>$userid,'course_id'=>$value->course_id,'active'=>1));
                if($cpd->pic_id_card){
                  $id_card_cpd = 'have';
                }else {
                  $id_card_cpd = 'no';
                }
              }

              $checkLessonPass = Helpers::lib()->checkCourseLearnStatus($value->course_id);
              if($checkLessonPass == 'pass'){
                $class = 'text-success';
                $status = 'เรียนผ่าน';
              } else if($checkLessonPass == 'learning') {
                $class = 'text-primary';
                $status = 'กำลังเรียน';
              } else {
                $class = 'text-danger';
                $status = 'ยังไม่เรียน';
              }
              if($i == 0){
                ?>
                <div class="post-row item">
                <?php
              }
              ?>
              
                  <div class="widget-thumb">
                    <?php echo Controller::ImageShowUser(Yush::SIZE_THUMB, $value, $value->course_picture, $value, array('class' => 'picture-src', 'id' => 'wizardPicturePreview')); ?>
                  </div>
                  <div class="widget-content">
                    <h5><a  <?php if($profile->type_user == 1) { ?>
              href="<?= $this->createUrl('/course/detail/', array('id' => $value->course_id)); ?>"
                  <?php } else if(( ($cate->special_category == 'y') && ($id_card_cpd == 'no') )) { ?>
              href="javascript:void(0)" onclick="AlertCardID(<?= $value->course_id ?>);"
                  <?php } else if($cpd) { ?>
              href="javascript:void(0)" onclick="comfirmIdCard(<?= $value->course_id ?>,<?= $cpd->id ?>,'<?= $cpd->pic_id_card ?>','<?= $model->bookkeeper_id ?>','<?= $model->auditor_id?>');"
                  <?php } else { ?>
              href="<?= $this->createUrl('/course/detail/', array('id' => $value->course_id)); ?>"
                  <?php } ?>
              ><?= htmlspecialchars_decode(iconv_substr($value->course_title,0,40,'utf-8')).'..' ?></a></h5>
                    <p class="<?= $class ?>"><?= $status ?></p>
                  </div>
                  <div class="clearfix"></div>
                  <?php 
                  $i++;
                  if($i == 2 || end($course) == $value){
                  ?>
              </div>
              <?php
              $i = 0;
            }
              }
            ?>
            
            </div>
            <hr>
            <?php
        }
    ?>
            </div>
        </div>
    </div>
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
</script>