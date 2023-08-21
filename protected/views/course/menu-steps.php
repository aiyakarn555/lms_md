<?php 
if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
    $langId = Yii::app()->session['lang'] = 1;
    $flag = true;
}else{  
    $langId = Yii::app()->session['lang'];
    $flag = false;
}
$course_type = (isset($course_type))? $course_type:'lms';

$criteria = new CDbCriteria;
$criteria->compare('course_id',$course->course_id);
$schedules = Schedule::model()->findAll($criteria);
if($schedules){
    $course_type = 'tms';
}else{
    $course_type = 'lms';
}
?>
<div class="bs-example" id="lessonId">
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading headstat">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span style="color: #fff;"><?=  $label->label_statuslearn ?></span> <span class="pull-right"><i class="fa fa-caret-down" aria-hidden="true" aria-expanded="true"></i></span></a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="panel-body">
                    <!-- <div class="row">
                      <div class="col-md-2 col-sm-2 col-xs-4 text-center">
                        <h3 class="font-weight-bold textstate"><?=  $label->label_courseViewAll ?></h3>
                        <a href=""><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/progressbar/all.png"  class="img-responsive allprogress" alt="" ></a>
                    </div>
                    <div  class="col-sm-8">
                        <div class="col-md-3 col-sm-4 col-xs-8 tablesson">


                            <ul class="nav nav-tabs tabs-left textstate">
                                <?php foreach ($lessonList as $key => $value) { ?>
                                <?php 
                                if(!$flag){
                                    $lessonListChildren = Lesson::model()->find(array('condition' => 'parent_id = ' . $value->id));
                                    if($lessonListChildren){
                                        $value->title = $lessonListChildren->title;
                                    }
                                }

                                 ?>
                                <li class="<?=($key == 0)?'active':''?>"><a href="#lesson<?=$value->id?>" data-toggle="tab" style="font-size: 14px;" ><?= $value->title?></a></li>
                                <?php } //end foreach ?>

                            </ul>
                        </div>

                        <div class="col-md-9 col-sm-8 col-xs-12">

                            <div class="tab-content">
                               
                                <?php foreach ($lessonList as $key => $value) { ?>
        
                                <?php   
                                $checkPreTest = Helpers::checkHavePreTestInManage($value->id);
                                $checkPostTest = Helpers::checkHavePostTestInManage($value->id); 
                                $checkLesson = Helpers::checkLessonPass($value);
                                // var_dump($checkLesson);
                                $progress = 0;
                                if ($checkPreTest) {                                    
                                    $score_pre = Helpers::CheckPassLessontest($value->id,'pre');
                                    $progress = (!empty($score_pre))? '20':$progress;
                                }else{
                                    $progress = 20;
                                }

                                $img_learn = 'studyf';
                                $text_learn = $label->label_notInLearn;
                                if ($checkLesson) {
                                    if ($checkLesson == "pass") {
                                        $progress = $progress+25;
                                        $img_learn = 'studyt';
                                        $text_learn = $label->label_lessonPass; 
                                    }elseif ($checkLesson == "learning") {
                                        $progress = $progress+25;
                                        $img_learn = 'studyfo';
                                        $text_learn = $label->label_learning;  
                                    }
                                    // $progress = ($checkLesson == "pass" || $checkLesson == "learning" )? $progress+25:$progress;
                                }else{
                                    $progress = $progress+25;
                                    $img_learn = 'studyt';
                                    $text_learn = $label->label_notInLearn;
                                }

                                if ($checkPostTest) {
                                    $score_post = Helpers::CheckPassLessontest($value->id,'post');
                                    $progress = (!empty($score_post))? $progress+25:$progress;
                                }else{
                                    $progress = $progress+35;
                                }
                                ?>
                                <div class="tab-pane <?=($key == 0)?'active':''?>" id="lesson<?=$value->id?>">

                                    <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:<?=$progress+5?>%">
                                      <span class="sr-only"></span>
                                  </div>


                                  <div class="col-md-4 col-sm-4 col-xs-4 text-center ">
                              
                                    <?php if ($checkPreTest) { 

                                        $score_pre = Helpers::CheckPassLessontest($value->id,'pre');

                                        if ($score_pre[0]->score_past == 'y') {
                                            $img_pre = 'pret';
                                        }elseif ($score_pre[0]->score_past == 'n') {
                                            $img_pre = 'prefo';
                                        }else{
                                            $img_pre = 'pref';
                                        }

                                        ?>
                                        <h3 class="font-weight-bold textstate"><?= $label->label_testPre  ?><br></h3>
                                        <div class="pre statelearn">
                                            <a data-toggle="tooltip" data-placement="bottom" <?= (!empty($score_pre))? 'title="คะแนนสอบ  '.$score_pre[0]->score_number.'/'.$score_pre[0]->score_total.'"':'';?>>
                                                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/progressbar/<?= $img_pre;?>.png"  class="img-responsive " alt="" >
                                            </a>
                                        </div>
                                        <?php }else{ ?>
                                        <h3 class="font-weight-bold textstate"><?=  $label->label_notTestPre ?><br></h3>
                                        <div class="pre statelearn">
                                            <a data-toggle="tooltip" data-placement="bottom">
                                                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/progressbar/notest.png"  class="img-responsive " alt="" >
                                            </a>
                                        </div>
                                        <?php } ?>
                                    </div>



                                    <div class="col-md-4 col-sm-4 col-xs-4 text-center ">
                                        <h3 class="font-weight-bold textstate"><?=$text_learn?><br></h3>
                                        <div class="study  statelearn">
                                           <a>
                                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/progressbar/<?= $img_learn?>.png"  class="img-responsive " alt="" >
                                        </a>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-4 text-center ">
                                    <?php if ($checkPostTest) { 

                                        $score_post = Helpers::CheckPassLessontest($value->id,'post');

                                        ?>
                                        <h3 class="font-weight-bold textstate"><?=  $label->label_testPost ?><br></h3>
                                        <div class="post  statelearn">
                                            <a data-toggle="tooltip" data-placement="bottom" <?= (!empty($score_post))? 'title="'.$score_post[0]->score_number.'/'.$score_post[0]->score_total.'"':'';?>>
                                                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/progressbar/<?= (!empty($score_post))? 'postt':'postf';?>.png"  class="img-responsive " alt="" >
                                            </a>
                                        </div>
                                        <?php }else{ ?>
                                        <h3 class="font-weight-bold textstate"><?=  $label->label_notTestPost  ?><br></h3>
                                        <div class="pre statelearn">
                                            <a data-toggle="tooltip" data-placement="bottom">
                                                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/progressbar/notest.png"  class="img-responsive " alt="" >
                                            </a>
                                        </div>
                                        <?php } ?>
                                    </div>

                                </div>
                                <?php } //end foreach ?>

                            </div>

                        </div>
                         <div class="clearfix"></div> 
                    </div>
                    <?php $checkLearnAll = Helpers::lib()->checkLearnAll_Questionnaire($lessonList,'pass'); ?>

                   
                    <div class="col-md-2 col-sm-2 col-xs-12 text-center border-left">
                        <h3 class="font-weight-bold textstate"><?= ($checkLearnAll)? $label->label_trainPass:$label->label_trainFail ?><br></h3>
                        <div class="checktf">
                           <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/progressbar/<?= ($checkLearnAll)?'true':'fail'?>.png"  class="img-responsive " alt="" >
                       </div>
                   </div>

               </div> -->

               <!-- <hr class="border-bottom"> -->

               <div class="row">




                <?php 
                // 1 = เรียนผ่านทุกบทเรียน
                // 2 = สอบข้อสอบหลักสูตร
                // 3 = ทำแบบสอบถาม
                // 4 = พิมพ์ใบประกาศ (เฉพาะ LMS)
                $step1 = false;
                $step2 = false;
                $step3 = false;
                $step4 = false;
                $progress = 0;
                
                $imgPass = 'passf.png';
                $imgCourseQuest = 'examf.png';
                $img_passcourse = "cerf.png";
                $imgQuestionnaire = 'assf.png';
                $img_passcourse = "cerf.png";

                $checkLearnAll = Helpers::lib()->checkLearnAll_Questionnaire($lessonList,'pass');
                $CourseSurvey = CourseTeacher::model()->findAllByAttributes(array('course_id'=>$course->course_id));
                $pathCourseqn = ($checkLearnAll && count($CourseSurvey) > 0 )?$this->createUrl('questionnaire_course/index', array('id' => $CourseSurvey[0]->id)):'javascript:void(0);';
                $flagTest = true;
                if($lessonList){
                    if($checkLearnAll){
                     $data = Helpers::lib()->checkTestPassAll($course->course_id);
                     foreach ($data as $key => $value) {
                        if($value['pre_test']){
                            if(!$value['pre_pass']){
                            // $flagTest = false;
                            }
                        }
                        if($value['post_test']){
                            if(!$value['post_pass']){
                                $flagTest = false;
                            }
                        }
                    }
                    if($flagTest){
                        $imgPass = 'pass.png';
                        $step1 = true;
                        $pathLearn = 'javascript:void(0);';
                        $progress += 100;
                    }
                }else{
                    $pathCourseqn = 'javascript:void(0);';
                    $pathLearn = 'javascript:void(0);';
                }
            } else {
                $imgPass = 'pass.png';
                $step1 = true;
                $pathLearn = 'javascript:void(0);';
                $progress += 100;
            }

            $finalTest = Helpers::lib()->checkHaveCourseTestInManage($course->course_id);
            $alert_question = '';


            //นับจำนวนที่สามารถสอบได้
            $stateCountTest = false; 
            $criteria = new CDbCriteria;
            $criteria->condition = ' course_id="' . $course->course_id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL AND active="y"';
            $criteria->order = 'create_date ASC';
            $BestFinalTestScore = Coursescore::model()->findAll($criteria);
            $pathTest =  'javascript:void(0);';
            if($step1 && !$finalTest) {
                $step2 = true;
                $imgCourseQuest = 'exam.png';
                $progress += 100;
            } else if($finalTest && $step1){
                $allPassed = true;
                if($BestFinalTestScore) {
                    $checkPass = array();
                    foreach($BestFinalTestScore as $time => $FinalTest) {
                     $checkPass[] = $FinalTest->score_past;
                 }
             }
         } 

        //CHECK JAE
         if($step1  && $flagTest && $finalTest){
            if(in_array("y", $checkPass) || count($BestFinalTestScore) < $course->cate_amount){
                $allPassed = true;
            }else{
                $allPassed = false;
            }

            if($allPassed){ 
                    //สอบผ่าน หรือสอบไม่ผ่านแต่ยังมีสิทธิ์สอบอยู่
                if(count($BestFinalTestScore) < $course->cate_amount && $finalTest){ 
                        //มีสิทะิ์สอบ
                    if(in_array("y", $checkPass)){ 
                            //สอบผ่าน ก่อนครบจำนวนครั้ง
                        $imgCourseQuest = 'exam.png';
                        $step2 = true;
                        $alert = 'onclick="alertswalPass()"';
                        if($course_type == 'lms'){
                            $progress += 100;
                        }
                    }else{ 
                        //สอบไม่ผ่าน แต่ยังมีสิทธิ์สอบ & ยังไม่เคยสอบ
                        $pathTest =  $this->createUrl('coursequestion/preexams', array('id' => $course->course_id));
                        $progress = 100;
                                 //passcourse
                        if($finalTest){
                            $stateCountTest = true;
                        }
                    }
                } else { 
                        //สอบผ่าน ครบจำนวนครั้ง
                    $imgCourseQuest = 'exam.png';
                    $step2 = true;
                    $alert = 'onclick="alertswalPass()"';
                    if($course_type == 'lms'){
                        $progress += 100;
                    }
                }
            } else { 
                    //สอบไม่ผ่านและครบจำนวนครั้งแล้ว
                $imgCourseQuest = 'exam.png';
                $alert = 'onclick="alertswalCourseTest()"';

                        //passcourse
                if($finalTest){
                    //ทา่นสอบครบแล้ว และไม่ผ่าน
                    $stateCountTest = true; 
                }
            }
            //บทเรียน ไม่ผ่าน
        }else if(!$flagTest){ 
            $imgCourseQuest = 'examf.png';
            $alert = 'onclick="alertswalCourseTest()"';
        }

            //Check Survey
        $state_pass_all = false;
        $alertSurvey = '';
        $pathCourseqn = 'javascript:void(0);';
        if($step1 && $step2 && count($CourseSurvey) > 0){ 
            //Check Survey pass
            $passQuest = QQuestAns_course::model()->find(array(
                'condition' => 'user_id = "' . Yii::app()->user->id . '" AND course_id ="' . $course->course_id . '"',
            ));
            //ทำแบบสอบถามแล้ว
            if ($passQuest) { 
                $imgQuestionnaire = 'ass.png';
                $state_pass_all = true;
                $step3 = true;
                if($course_type == 'lms'){
                    $progress = 300;
                }
            //ยังไม่ได้ทำแบบสอบถาม
            }else{ 
                $progress = 200;
                $pathCourseqn = $this->createUrl('questionnaire_course/index', array('id' =>$CourseSurvey[0]->id));
            }
        } else if(count($CourseSurvey) == 0 && $step1 && $step2) {
            $alertSurvey = 'onclick="alertswalSurvey()"';
            $imgQuestionnaire = 'ass.png';
            $step3 = true;
        }

        $certDetail = CertificateNameRelations::model()->find(array('condition'=>'course_id='.$course->course_id));
        if($step1 && $step2 && $step3){
            if(!$certDetail){
                $pathPassed = 'javascript:void(0)';
                $img_passcourse = "cer.png";
                $alertCer = 'onclick="alertswalError()"';
            }else{
                    //passcourse
                $pathPassed = $this->createUrl('Course/PrintCertificate', array('id' => $course->course_id));
                $img_passcourse = "cer.png";
            }
        } else {
            $pathPassed = 'javascript:void(0)';
        }
    // $criteria = new CDbCriteria;
    // $criteria->condition = ' course_id="' . $course->course_id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL AND active="y" AND score_past = "y"';
    // $criteria->order = 'create_date ASC';
    // $FinalScore = Coursescore::model()->findAll($criteria);

        if($step1 && $step2 && $step3){
         $imgPassAll ='success-learn.png';
         $progress += 100;
     }else{
         $imgPassAll ='no-success-learn.png';
     }

     ?>

     <div class="col-md-2 col-md-offset-1 col-sm-4 col-xs-4 text-center" id="first">
        <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="margin-left: 30px;width:<?=$progress+5?>%">
          <span class="sr-only"></span>
      </div>
      <h3 class="font-weight-bold textstate"><?=  UserModule::t('pass_lesson'); ?><br></h3>
      <div class="ass">
       <a href="<?= $pathLearn ?>"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/menusteps/<?= $imgPass ?>"  class="img-responsive " alt="" ></a>

   </div>
</div>

<div class="col-md-2 col-sm-4 col-xs-4 text-center">
    <h3 class="font-weight-bold textstate"><?= $label->label_testCourse ?><br></h3>
    <div class="exam">
       <a href="<?=$pathTest?>" <?= $alert ?> ><img src="<?= Yii::app()->theme->baseUrl."/images/menusteps/".$imgCourseQuest ?>"  class="img-responsive " alt="" ></a>
   </div>
</div>

<div class="col-md-2 col-sm-4 col-xs-4 text-center">
    <h3 class="font-weight-bold textstate"><?= $label->label_AssessSatisfaction ?><br></h3>
    <div class="exam">
      <a href="<?= $pathCourseqn ?>" <?= $alertSurvey ?> ><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/menusteps/<?= $imgQuestionnaire; ?>"  class="img-responsive " alt="" ></a>
  </div>
</div>




<?php if($course_type == 'lms'){ ?>
    <div class="col-md-2 col-sm-4 col-xs-4 text-center">
        <h3 class="font-weight-bold textstate"><?=  $label->label_printCert ?><br></h3>
        <div class="cer">
            <a href="<?=$pathPassed?>" <?= $alertCer ?> ><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/menusteps/<?= $img_passcourse;?>"  class="img-responsive " alt="" ></a>
        </div>
    </div>




<?php } ?>
<?php 
            // $criteria = new CDbCriteria;
            // $criteria->condition = ' course_id="' . $course->course_id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL AND active="y" AND score_past = "y"';
            // $criteria->order = 'create_date ASC';
            // $FinalScore = Coursescore::model()->findAll($criteria);
            //     if(!$state_pass_all){
            //         $imgPassAll ='no-success-learn.png';
            //     }else if(!empty($FinalScore) || $state_pass_all){
            //         $imgPassAll ='success-learn.png';
            //     }
            //     // if(empty($FinalScore)){
            //     //     $imgPassAll ='no-success-learn.png';
            //     // }else{
            //     //     $imgPassAll ='success-learn.png';
            //     // }
?>

<div class="col-md-2 col-sm-4 col-xs-4 text-center">
    <h3 class="font-weight-bold textstate"><?=  ($imgPassAll == 'success-learn.png')? UserModule::t('pass_complete') : UserModule::t('not_complete'); ?>
    <br></h3>
    <div class="exam">
       <a  ><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/menusteps/<?= $imgPassAll;?>"  class="img-responsive " alt="" ></a>
   </div>
</div>
       <!--  <div class="col-md-2 col-sm-12 col-xs-12">
            <div class="well well-alert">
                    <b><i class="fa fa-bell-o" aria-hidden="true"></i> <?= UserModule::t('notification'); ?></b>
                    <ol class="stat-alert">
                        <?php if($step1){ ?>
                            <li style="background-color: #42c542;">
                                &nbsp;<?= UserModule::t('step1Pass'); ?>
                            </li>
                        <?php }else{ ?>
                           <li>
                                &nbsp;<?= UserModule::t('step1Fail'); ?>
                        </li>
                        <?php } ?>
                        
                        <?php if($step2){ ?>
                        <li style="background-color: #42c542;"> 
                            &nbsp;<?= UserModule::t('step2Pass'); ?>
                        </li>
                        <?php }else{ ?>
                          <li> 
                            &nbsp;<?= UserModule::t('step2Fail'); ?>
                        </li>
                        <?php } ?>

                        <?php if($step3){ ?>
                        <li style="background-color: #42c542;"> 
                            &nbsp;<?= UserModule::t('step3Pass'); ?>
                        </li>
                        <?php if($course_type == 'lms'){ ?>
                        <li style="background-color: #42c542;"> 
                            &nbsp;<?= UserModule::t('step4Pass'); ?>
                        </li>
                        <?php } ?>
                         <?php }else{ ?>
                        <li> 
                            &nbsp;<?= UserModule::t('step3Pass'); ?>
                        </li>
                        <?php if($course_type == 'lms'){ ?>
                         <li> 
                            &nbsp;<?= UserModule::t('step4Fail'); ?>
                        </li>
                         <?php } ?>
                        <?php } ?>

                        
                    </ol>
            </div>
        </div> -->

    </div>

</div>
</div>
</div>

</div>
</div>
<?php if($stateCountTest){ ?>

    <?php 
    $countScore = $course->cate_amount -  count($BestFinalTestScore);
    if($countScore <= 0){
        $msg_count = UserModule::t('fullCountTest');
    }else{
        $msg_count = UserModule::t('notFullCountTest') .' <b>'. $countScore .'</b>'.UserModule::t('Times');
    }

    ?>
    <!-- <span class="fixalert"><?= $msg_count ?></span> -->
<?php } ?>


<script>
    function alertswalPass() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_passTest ?>', "error");
    }

    function alertswalSurvey() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_noSurveyCourse ?>', "error");
    }

    function alertswalCourseTest() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_noPermis ?>', "error");
    }

    function alertswalError() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_alert_msg_notFound ?>', "error");
    }

</script>