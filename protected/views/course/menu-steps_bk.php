<?php 
    if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
        $langId = Yii::app()->session['lang'] = 1;
        $flag = true;
    }else{  
        $langId = Yii::app()->session['lang'];
        $flag = false;
    }
?>
<div class="bs-example">
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading headstat">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span style="color: #fff;"><?=  $label->label_statuslearn ?></span> <span class="pull-right"><i class="fa fa-caret-down" aria-hidden="true"></i></span></a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="panel-body">
                    <div class="row">
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
                        <!-- <div class="clearfix"></div> -->
                    </div>
                    <?php $checkLearnAll = Helpers::lib()->checkLearnAll_Questionnaire($lessonList,'pass'); ?>

                    <!-- fail   -->
                    <div class="col-md-2 col-sm-2 col-xs-12 text-center border-left">
                        <h3 class="font-weight-bold textstate"><?= ($checkLearnAll)? $label->label_trainPass:$label->label_trainFail ?><br></h3>
                        <div class="checktf">
                           <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/progressbar/<?= ($checkLearnAll)?'true':'fail'?>.png"  class="img-responsive " alt="" >
                       </div>
                   </div>

               </div>

               <hr class="border-bottom">

               <div class="row">
                <div class="col-md-3 col-sm-0 col-xs-0"></div>
                <?php 
                $checkLearnAll = Helpers::lib()->checkLearnAll_Questionnaire($lessonList,'pass');
                $CourseSurvey = CourseTeacher::model()->findAllByAttributes(array('course_id'=>$course->course_id));
                $pathCourseqn = ($checkLearnAll && count($CourseSurvey) > 0 )?$this->createUrl('questionnaire_course/index', array('id' => $CourseSurvey[0]->id)):'javascript:void(0);';
                 ?>
                <div class="col-md-2 col-sm-4 col-xs-4 text-center">
                    <h3 class="font-weight-bold textstate"><?=  $label->label_AssessSatisfaction ?><br></h3>
                    <div class="ass">
                       <a href="<?= $pathCourseqn ?>"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/progressbar/<?= ($checkLearnAll && count($CourseSurvey) > 0)? 'ass':'assf';?>.png"  class="img-responsive " alt="" ></a>
                   </div>
               </div>

               <?php 
              
               $finalTest = Helpers::lib()->checkHaveCourseTestInManage($course->course_id);
               $alert_question = '';
               $imgCourseQuest = 'examf.png';
               if($finalTest){
                    $PaQuest = false;
                    if ($CourseSurvey) {
                        $passQuest = QQuestAns_course::model()->find(array(
                            'condition' => 'user_id = "' . Yii::app()->user->id . '" AND course_id ="' . $course->course_id . '"',
                        ));
                        if ($passQuest) {
                            $PaQuest = true;
                        }
                    }else{
                        $PaQuest = true;
                    }
                    if ($PaQuest) {
                        $pathTest =  $this->createUrl('coursequestion/preexams', array('id' => $course->course_id));
                        $strMsg = 'ทำแบบทดสอบ';
                        $imgCourseQuest = 'exam.png';

                    }else{
                        $pathTest =  'javascript:void(0);';
                        $strMsg = 'ไม่สามารถทำได้';
                        $alert_question = "swal('ไม่สามารถทำได้', 'กรุณาทำแบบประเมินความพึงพอใจก่อน !', 'error')";
                    }
                    
                } else {
                    $pathTest = 'javascript:void(0);';
                    $strMsg = 'ไม่มีแบบทดสอบ';
                }

                $flagTest = true;
                if($finalTest){
                    $data = Helpers::lib()->checkTestPassAll($course->course_id); //pass all lesson
                    foreach ($data as $key => $value) {
                        if($value['pre_test']){
                            if(!$value['pre_pass']){
                                $flagTest = false;
                            }
                        }
                        if($value['post_test']){
                            if(!$value['post_pass']){
                                $flagTest = false;
                            }
                        }
                    }
                    if($flagTest){
                        $pathTest =  $this->createUrl('coursequestion/preexams', array('id' => $course->course_id));
                        $strMsg = 'ทำแบบทดสอบ';
                        $imgCourseQuest = 'exam.png';

                    }else{
                        $pathTest =  'javascript:void(0);';
                        $strMsg = 'ไม่สามารถทำได้';
                        $alert_question = "swal('ไม่สามารถทำได้', 'กรุณาทำแบบทดสอบก่อน !', 'error')";
                        $imgCourseQuest = 'examf.png';
                    }
                }


               // $finalTest = Helpers::lib()->checkHaveCourseTestInManage($course->course_id); 
               // $pathTest =  ($finalTest)?$this->createUrl('coursequestion/preexams', array('id' => $course->course_id)):'javascript:void(0);';
               
               ?>

               <?php
                   $checkCourseTest = Helpers::lib()->checkCoursePass($course->course_id);
                   $checkHaveCourseTest = Helpers::lib()->checkHaveCourseTestInManage($course->course_id);
                   $criteria = new CDbCriteria;
                   $criteria->condition = ' course_id="' . $course->course_id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL AND active="y"';
                   $criteria->order = 'create_date ASC';
                   $BestFinalTestScore = Coursescore::model()->findAll($criteria);
                   if($checkHaveCourseTest && $checkCourseTest == 'pass'){
                    $allPassed = true;
                    if($BestFinalTestScore) {
                        $checkPass = array();
                            foreach($BestFinalTestScore as $time => $FinalTest) {
                                 $checkPass[] = $FinalTest->score_past;
                                // if($FinalTest->score_past == 'n' &&  $allPassed) {
                                //     $allPassed = false;
                                // }
                            }
                        }
                    } else if($checkCourseTest == 'pass'){
                        $allPassed = true;
                    }


                    //CHECK JAE
                    if($checkCourseTest != "notPass"  && $flagTest){

                    if(in_array("y", $checkPass) || count($BestFinalTestScore) < $course->cate_amount){
                        $allPassed = true;
                    }else{
                        $allPassed = false;
                    }


                    if($allPassed){ //สอบผ่าน หรือสอบไม่ผ่านแต่ยังมีสิทธิ์สอบอยู่
                        if(count($BestFinalTestScore) < $course->cate_amount){ //มีสิทะิ์สอบ
                            if(in_array("y", $checkPass)){ //สอบผ่าน ก่อนครบจำนวนครั้ง
                                $pathTest = 'javascript:void(0);';
                                $imgCourseQuest = 'exam.png';
                                $alert = 'onclick="alertswalPass()"';

                                //passcourse
                                $pathPassed = $this->createUrl('Course/PrintCertificate', array('id' => $course->course_id));
                                $img_passcourse = "cer.png";

                            }else{ //สอบไม่ผ่าน แต่ยังมีสิทธิ์สอบ
                                $pathTest =  $this->createUrl('coursequestion/preexams', array('id' => $course->course_id));
                                $imgCourseQuest = 'exam.png';

                                 //passcourse
                                $pathPassed = 'javascript:void(0);';
                                $img_passcourse = "cerf.png";
                            }
                           
                        }else{ //สอบผ่าน ครบจำนวนครั้ง
                            $pathTest = 'javascript:void(0);';
                            $imgCourseQuest = 'exam.png';
                            $alert = 'onclick="alertswalPass()"';

                            //passcourse
                            $pathPassed = $this->createUrl('Course/PrintCertificate', array('id' => $course->course_id));
                            $img_passcourse = "cer.png";
                        }
                       
                    }else{ //สอบไม่ผ่านและครบจำนวนครั้งแล้ว
                        $pathTest = 'javascript:void(0);';
                        $imgCourseQuest = 'exam.png';
                        $alert = 'onclick="alertswalCourseTest()"';

                        //passcourse
                        $pathPassed = 'javascript:void(0);';
                        $img_passcourse = "cerf.png";
                    }
                }else{ //บทเรียน ไม่ผ่าน
                    $pathTest = 'javascript:void(0);';
                    $imgCourseQuest = 'examf.png';
                    $alert = 'onclick="alertswalCourseTest()"';

                    //passcourse
                    $pathPassed = 'javascript:void(0);';
                    $img_passcourse = "cerf.png";
                }
                if(!$finalTest){ // ไม่มีแบบทดสอบ
                    $pathTest = 'javascript:void(0);';
                    $imgCourseQuest = 'examf.png';
                    $alert = '';
                }

            ?>

               <div class="col-md-2 col-sm-4 col-xs-4 text-center">
                <h3 class="font-weight-bold textstate"><?= $label->label_testCourse ?><br></h3>
                <div class="exam">
                   <a href="<?=$pathTest?>" <?= $alert ?> ><img src="<?= Yii::app()->theme->baseUrl."/images/progressbar/".$imgCourseQuest ?>"  class="img-responsive " alt="" ></a>
               </div>
           </div>



        <div class="col-md-2 col-sm-4 col-xs-4 text-center">
            <h3 class="font-weight-bold textstate"><?=  $label->label_printCert ?><br></h3>
            <div class="cer">
                <a href="<?=$pathPassed?>"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/progressbar/<?= $img_passcourse;?>"  class="img-responsive " alt="" ></a>
            </div>
        </div>
        <div class="col-md-3 col-sm-0 col-xs-0"></div>
    </div>


</div>
</div>
</div>

</div>

</div> 

<script>
    function alertswalPass() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_passTest ?>', "success");
    }

    function alertswalCourseTest() {
        swal('<?= $label->label_swal_warning ?>', '<?= $label->label_noPermis ?>', "error");
    }

</script>