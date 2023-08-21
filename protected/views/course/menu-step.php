<style>
    a { color: white; text-decoration: none; }
    .notificationbtn {     
        float: right;
        display: block;
        border-radius: 4px;
        padding: 4px 10px;
        font-size: 14px;
        line-height: 12px;
        margin-top: 12px;
        margin-left: 6px;
        color: #fff;
        font-weight: 900;
    }
    .printcer { 
        width: 24px;
        height: 24px;
        top: 11px;
        right: 6px;
        font-size: 14px;
        position: absolute;
        background: #05ae0e;
        color: white;
        line-height: 24px;
        text-align: center;
        border-radius: 4px;
    }
    .passed {
        background: #05ae0e;
    }
    .nosurvey {
        background: #05ae0e;
    }
</style>
<?php
if ($course) {

    //check first step learn
    $stepFirst = false;
    $stepTwo = false;
    $stepThird = false;
    $stepFour = false;
    $stepActivate = 1;

    $LessonCourseList = Lesson::model()->findAll(array(
        'condition' => 'course_id = "' . $course->course_id . '" AND active = "y"',
        'order' => 'lesson_no'
    ));
    $isPreTest = Helpers::isPretestState($LessonCourseList[0]->id);
    $last_count = count($LessonCourseList)-1;
    $isPostTest = Helpers::isPosttestState($LessonCourseList[$last_count]->id);
    
    if ($LessonCourseList) {
        $countPass = 0;
        $totallesson = 0;
        foreach ($LessonCourseList as $Lesson) {
            $checkLearnPass = Learn::model()->find(array(
                'condition' => 'lesson_id = "' . $Lesson->id . '" AND user_id = "' . Yii::app()->user->id . '" AND lesson_status = "pass"  and lesson_active ="y"',
            ));
            if ($checkLearnPass) {
                $countPass++;
            }
            if(count($Lesson->files) > 0){
                $totallesson++;
            }
        }
        if ($countPass == $totallesson) {
            $stepFirst = true;
            $stepActivate = 2;
        }
    }
    //end first step
    //check second step
    if ($stepFirst) {
        $CourseSurvey = CourseTeacher::model()->findAllByAttributes(array('course_id'=>$course->course_id));
        if(!$CourseSurvey){
            $stepTwo = true;
            $stepActivate = 3;
        } else {
             $checkPassQuestionairCourse = QQuestAns_course::model()->findAll(array(
            'condition' => 'course_id = "' . $course->course_id . '" AND user_id = "' . Yii::app()->user->id . '"',
            ));
            if ($checkPassQuestionairCourse) {
                $stepTwo = true;
                $stepActivate = 3;
            }
        } 
       
    }
    //end second step
    //check third step
    if ($stepTwo) {
        if ($course->CategoryTitle->special_category == 'y') {
            $checkFinalTest = Coursescore::model()->findAll(array(
                'condition' => 'course_id = "' . $course->course_id . '" AND user_id = "' . Yii::app()->user->id . '" AND score_past = "y" and active ="y"',
            ));
            if ($checkFinalTest) {
                $stepThird = true;
                $stepActivate = 4;
            }
        } else {
            $checkHaveFinalTest = Coursemanage::model()->find(array(
                'condition' => 'id = "' . $course->course_id . '" AND active = "y"'
            ));
            if ($checkHaveFinalTest) {
                $checkFinalTest = Coursescore::model()->findAll(array(
                    'condition' => 'course_id = "' . $course->course_id . '" AND user_id = "' . Yii::app()->user->id . '"  AND score_past = "y" and active ="y"',
                ));
                if ($checkFinalTest) {
                    $stepThird = true;
                    $stepActivate = 4;
                }
            } else {
                $stepThird = true;
                $stepActivate = 4;
            }
        }
    }
    //end third step
    //check four step
    if ($stepThird) {
        $stepFour = true;
        $stepActivate = 4;
        $CanPrint = '<div class="printcer"><i class="fa fa-print" aria-hidden="true"></i></div>';
    }
    //end four step
}

$success = '<div class="notificationbtn passed"><i class="fa fa-check-circle-o" aria-hidden="true"></i> ผ่าน</div>';
?>
<!--<div class="col-md-12">
    <div data-wizard-init>
        <ul class="steps nav-justified">
            <li data-step="1" <?= ($stepActivate == 1) ? 'class="active"' : null ?>>
                <a class="check-course-start" check-course="<?= $course->id ?>" href="<?= $this->createUrl('course/lesson', array('id' => $course->id)) ?>" >
                    เรียนผ่านรายวิชา
                </a> <?= ($stepFirst) ? $success : null ?>
            </li>
            <li data-step="2" <?= ($stepActivate == 2) ? 'class="active"' : null ?>>
                <a href="<?= $this->createUrl('course/questionnaire', array('id' => $course->id)) ?>" target="_self">
                    ทำแบบสอบถาม</a> <?= ($stepTwo) ? $success : null ?></li>
            <li data-step="3" <?= ($stepActivate == 3) ? 'class="active"' : null ?>>
                <a href="<?= $this->createUrl('course/final', array('id' => $course->id)) ?>" target="_self">
                    สอบ Final
                </a> <?= ($stepThird) ? $success : null ?>
            </li>
            <li data-step="4" <?= ($stepActivate == 4) ? 'class="active"' : null ?>>
                <a href="<?= $this->createUrl('course/certificate', array('id' => $course->id)) ?>" target="_self">
                    พิมพ์หนังสือรับรอง CPD
                </a> <?= ($stepFour) ? $CanPrint : null ?>
            </li>
        </ul>
    </div>
</div>-->


<div class="well mb-2 bg-mute">
    <div class="row step">
        <div class="col-sm-2">
            <a href="<?php echo $this->createUrl('/course/detail', array('id' => $course->course_id)); ?>">
                <div class="text-center">
                    <!-- Default -->
                    <i class="fa fa-book fa-4x text-muted <?= (!$isPreTest)&&($stepFirst)&&(!$isPostTest)&&($stepTwo) ? 'hidden' : null ?>" aria-hidden="true"></i> 
                    <!-- Doing -->
                    <i class="fa fa-book fa-4x text-warning hidden" aria-hidden="true"></i>  
                    <!-- Success -->
                    <i class="fa fa-book fa-4x text-success <?= (!$isPreTest)&&($stepFirst)&&(!$isPostTest)&&($stepTwo) ? null : 'hidden' ?>" aria-hidden="true"></i>  
                    <!-- Unsuccess -->
                    <i class="fa fa-book fa-4x text-danger hidden" aria-hidden="true"></i>  
                    <p>ภาพรวมหลักสูตร</p> 
                </div>
            </a>
        </div>
        <div class="col-sm-8">
            <div class="well mb-0 bg-greenlight">
                <ul class="progressbar">
                    <li class="<?= (!$isPreTest) ? 'active':'' ?>"><a href="<?php echo $this->createUrl('/course/detail', array('id' => $course->course_id)); ?>">สอบก่อนเรียน</a></li>
                    <li class="<?= ($stepFirst) && (!$isPreTest) ? 'active':'' ?>"><a href="<?php echo $this->createUrl('/course/detail', array('id' => $course->course_id)); ?>">เรียน</a></li>
                    <li class="<?= (!$isPostTest) && ($stepFirst) ? 'active':'' ?>"><a href="<?php echo $this->createUrl('/course/detail', array('id' => $course->course_id)); ?>">สอบหลังเรียน</a></li>
                    <li class="<?= ($stepTwo) && (!$isPostTest) ? 'active':'' ?>"><a href="<?= $this->createUrl('course/questionnaire', array('id' => $course->id)) ?>" target="_self">ประเมิน</a></li>
                </ul>
            </div>
        </div>
<!--        <div class="col-sm-2">
            <a href="<?= $this->createUrl('course/questionnaire', array('id' => $course->id)) ?>" target="_self">
                <div class="text-center">
                     Default 
                    <i class="fa fa-check fa-4x text-muted <?= ($stepTwo) ? 'hidden' : null ?>" aria-hidden="true"></i>
                     Doing 
                    <i class="fa fa-check fa-4x text-warning hidden" aria-hidden="true"></i>
                     Success 
                    <i class="fa fa-check fa-4x text-success <?= ($stepTwo) ? null : 'hidden' ?>" aria-hidden="true"></i>
                     Unsuccess 
                    <i class="fa fa-check fa-4x text-danger hidden" aria-hidden="true"></i>
                    <p>ประเมิน</p> 
                </div>
            </a>
        </div>-->
        <div class="col-sm-2">
            <a href="<?php echo $this->createUrl('/course/final', array('id' => $course->course_id)); ?>">
                <div class="text-center">
                    <!-- Default -->
                    <i class="fa fa-trophy fa-4x text-muted <?= ($stepThird) ? 'hidden' : null ?>" aria-hidden="true"></i>
                    <!-- Doing -->
                    <i class="fa fa-trophy fa-4x text-warning hidden" aria-hidden="true"></i>
                   <!-- Success -->
                    <!--<i class="fa fa-trophy fa-4x text-success-trophy <?= ($stepThird) ? null : 'hidden' ?>" aria-hidden="true"></i>-->
                    <i class="<?= ($stepThird) ? null : 'hidden' ?>"><img src="<?=Yii::app()->theme->baseUrl; ?>/images/trophy_cup.png?>" width="78" height="84"></i>
                    <!-- Unsuccess -->
                    <i class="fa fa-trophy fa-4x text-danger hidden" aria-hidden="true"></i>
                    <p>ผลการสอบและพิมพ์ใบประกาศ</p> 
                </div>
            </a>
        </div>
    </div>                  
</div>