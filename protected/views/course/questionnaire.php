<?php
if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
    $Completed = "Completed";
}else{  
    $Completed = "สำเร็จ";
}

if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
    $langId = Yii::app()->session['lang'] = 1;
}else{
    $langId = Yii::app()->session['lang'];
}
$gen_id = $gen;
$teacher = Teacher::model()->findByPk($course->course_lecturer);
$checkLearnAll = Helpers::lib()->checkLearnAll_Questionnaire($lessonList,'pass');

$curLessonArray = array();
if($lessonList) {
    foreach($lessonList as $list) {
        array_push($curLessonArray, $list->id);
    }
}
// $checkLessonManager = Manage::model()->findAll(array(
//     'condition' => 'id = "' . $course->course_id . '"'
// ));
$PassedTestAfterLearn = false;

//set message alert
if($checkLearnAll) {
    $passtotal = 0;
    foreach($lessonList as $lesson) {
        $checkLessonManager = Manage::model()->findAll(array(
            'condition' => 'id = "' . $lesson->id . '" AND type="post"'
        ));
        if($checkLessonManager){
            $checkPassScore = Score::model()->findAllByAttributes(array(
                'lesson_id' => $lesson->id,
                'user_id' => Yii::app()->user->id,
                'type' => 'post',
                'active' => 'y', 'gen_id'=>$gen_id
            ));        
            if($checkPassScore) {
                $passtotal++;
            }
        } else {
            $passtotal++;
        }
    }
    if($passtotal == count($lessonList)) {
        $PassedTestAfterLearn = true;
    }
}

$getLessonAll = Lesson::model()->findAll(array(
    'condition' => 'course_id = "' . $course->course_id . '"',
)
);



?>
<style type="text/css">
    .box-body, .box-body-notthing { padding: 15px; margin-bottom: 1em; border-radius: 4px; border: 1px solid rgba(119, 119, 119, 0.5); }
    .box-content-body { padding: 5px; }
    .box-content-body h1 { border-bottom: 2px solid #f0ad4e; line-height: 20px; padding-bottom: 10px; }
    .font-normal { font-size: 1em; }
    .font-big { font-size: 2em; }
    .padleft { padding-left: 20px !important; }
    .warningArea { text-align: center; }
    .text-left { text-align: left !important; }
</style>
<!-- Header page -->
<!-- <div class="header-page">
    <div class="container">
        <?php // $Model = CourseOnline::model()->findByAttributes(array('cate_id'=>$id,)); ?>    
        <h1><?= $course->course_title ?>

        <small class="pull-right">
            <ul class="list-inline list-unstyled">
                <li><a href="<?php echo $this->createUrl('/site/index'); ?>">หน้าแรก</a></li>/
                <li><a href="<?php echo $this->createUrl('/course/index'); ?>">หลักสูตร</a></li>/
                <li><a href="#">ชื่อหลักสูตร</a></li>
            </ul>
        </small>
    </h1>
</div>
</div> -->

<div class="container-main">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
          <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/course/index'); ?>"><?php echo $labelCourse->label_course; ?></a>
            <li class="breadcrumb-item active" aria-current="page"><?= $course->course_title ?> <?= $course->getGen($course->course_id); ?></li>
        </ol>
    </nav>
</div> 

<!-- Content -->
<section class="content" id="course-detail">
    <div class="container-main ">
            <!-- ?php
                            $this->renderPartial('menu-steps', array(
                                'course' => $course,
                                'stepActivate' => $stepActivate,
                                'lessonList' => $lessonList,
                                'label'=>$label,
                            ));
                            ?> -->
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php
                                            if($course) {
                                                $InactivateSurvey = 0;

                                                $course_id_have_ans = $course->course_id;

                                                $checkAnswer = QQuestAns_course::model()->findByAttributes(array(
                                                    'user_id' => Yii::app()->user->id,
                                                    'course_id' => $course->course_id, 'gen_id'=>$gen_id
                                                ));
                                                if (!$checkAnswer) {
                                                    $course_check = CourseOnline::model()->findAll("parent_id=".$course->course_id);
                                                    foreach ($course_check as $key => $value) {
                                                        $checkAnswer_parent = QQuestAns_course::model()->findByAttributes(array(
                                                            'user_id' => Yii::app()->user->id,
                                                            'course_id' => $value->course_id, 'gen_id'=>$gen_id
                                                        ));
                                                        if ($checkAnswer_parent) {
                                                            $course_id_have_ans = $value->course_id;
                                                        }
                                                    }
                                                }

                                                $course = CourseOnline::model()->findByPk($course_id_have_ans);

                                                $CourseSurvey = CourseTeacher::model()->findAllByAttributes(array('course_id'=>$course->course_id));

                                                // if ($langId != 1) {
                                                //     $course = CourseOnline::model()->find("parent_id=".$course->course_id." AND lang_id =".$langId);
                                                //     $course_id = $course->course_id;
                                                //     $CourseSurvey = CourseTeacher::model()->findAllByAttributes(array('course_id'=>$course_id));
                                                // }

                                                if($CourseSurvey) {
                                                    foreach ($CourseSurvey as $i => $survey) {
                                                        $SurveyCourse = QHeader::model()->findByPk($survey->survey_header_id);
                                                        $checkAnswerYet = QQuestAns_course::model()->findByAttributes(array(
                                                            'user_id' => Yii::app()->user->id,
                                                            'header_id' => $survey->survey_header_id,
                                                            'course_id' => $course->course_id, 'gen_id'=>$gen_id
                                                        ));
                                                        if($SurveyCourse) {
                                                            ?>
                                                            <div class="box-body panel-body bg-white>
                                                                <div class="col-md-9">
                                                                    <div class="box-content-body panel-body">
                                                                        <h4><?= $SurveyCourse->survey_name ?></h4>
                                                                        <h5 style="font-size: 20px;"><?= $label->label_surveyCourse ?>: <font style="font-weight: 500;"><?= $course->course_title ?> <?= $course->getGen($course->course_id); ?></font></h5>
                                                                        <hr>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="box-content-body">
                                                                        <?php
                                                                        if($checkAnswerYet) {
                                                                            ?>
                                                                            <div class="warningArea">
                                                                                <span style="color: green"><?= $label->label_AnsweredQuestions ?></span>
                                                                            </div>
                                                                            <div class="warningArea">
                                                                                <i class="fa fa-check-circle fa-4x" style="color: green"></i>
                                                                            </div>
                                                            <!-- <a class="col-md-12 btn btn-default btn-sm" href="javascript:void(0)" data-toggle="collapse" data-target="#showAnswerPanel_<?= $surveyCnt ?>">
                                                                <i class="fa fa-search"></i> < ?= $label->label_detailSurvey ?></a> -->
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <div class="warningArea">
                                                                    <span class="text-danger font-normal"><?= $label->label_dontAnsweredQuestions ?></span>
                                                                </div>
                                                                <div class="warningArea">
                                                                    <i class="fa fa-exclamation-circle fa-4x text-danger"></i>
                                                                </div>
                                                                <?php if($PassedTestAfterLearn) { ?>
                                                                    <a class="col-md-12 btn btn-warning btn-sm" href="<?php echo ($PassedTestAfterLearn)?$this->createUrl('questionnaire_course/index', array('id' => $survey->id)):'javascript:void(0)' ?>" role="button">
                                                                        <i class="fa fa-pencil"></i> <?= $label->label_startDoSurvey  ?>
                                                                    </a>
                                                                <?php } else { ?>
                                                                    <a class="col-md-12 btn btn-warning btn-sm" onclick="swal('<?= $label->label_cantDoSurvey ?>', '<?= $label->label_swal_checkLearn ?> !', 'error')">
                                                                        <i class="fa fa-warning"></i> <?= $label->label_cantDoSurvey ?>
                                                                    </a>
                                                                <?php } ?>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 " id="showAnswerPanel_<?= $surveyCnt ?>">
                                                        <div class="box-content-body panel-body">
                                                            <?php
                                                            // $currentQuestionaire = QHeader::model()->findByPk($course->course_id);
                                                            $currentQuestionaireAll = QSection::model()->findAll(['condition' =>'survey_header_id ='.$survey->survey_header_id]);
                                                            
                                                            if(isset($currentQuestionaireAll)) {
                                                                foreach( $currentQuestionaireAll as $index => $currentQuestionaire){

                                                                    ?>
                                                                    <div class="box-content-body panel-body">
                                                                        <h4><?= $currentQuestionaire->section_title ?></h4>
                                                                    </div>
                                                                    <div class="box-content-body panel-body">
                                                                        <?php
                                                                        if(isset($currentQuestionaire->questions)) {
                                                                            foreach($currentQuestionaire->questions as $QQuestion) {
                                                                                if($QQuestion->input_type_id == 4){
                                                                                    ?>
                                                                                    <table class="table table-bordered post-question">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <td class="head-question" style="vertical-align: middle;" class="left padleft" rowspan="2"><?= $QQuestion->question_name ?></td>
                                                                                                <td class="center head-question" <?= ($QQuestion->question_range)?'colspan="'.$QQuestion->question_range.'"':null ?>><?= $label->label_SatisfactionLv ?></td>
                                                                                            </tr>
                                                                                            <tr class="info">
                                                                                                <?php
                                                                                                if($QQuestion->question_range == 5){
                                                                                                    $titleArray = array(
                                                                                                        '1' => 'ไม่พอใจเลย',
                                                                                                        '2' => 'เฉยๆอ่ะ',
                                                                                                        '3' => 'พอใจ',
                                                                                                        '4' => 'พอใจมาก',
                                                                                                        '5' => 'พอใจมากที่สุด',
                                                                                                    );
                                                                                                } else {
                                                                                                    $titleArray = array(
                                                                                                        '1' => '1',
                                                                                                        '2' => '2',
                                                                                                        '3' => '3',
                                                                                                        '4' => '4',
                                                                                                        '5' => '5',
                                                                                                        '6' => '6',
                                                                                                        '7' => '7',
                                                                                                        '8' => '8',
                                                                                                        '9' => '9',
                                                                                                        '10' => '10',
                                                                                                    );
                                                                                                }
                                                                                                if($QQuestion->question_range > 0) {
                                                                                                    $j = $QQuestion->question_range;
                                                                                                    for($i=1; $i <= $QQuestion->question_range; $i++) {
                                                                                                        ?>
                                                                                                        <td class="center head-question" width="120"><?= $titleArray[$j] ?></td>
                                                                                                        <?php
                                                                                                        $j--;
                                                                                                    }
                                                                                                }
                                                                                                ?>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <?php 
                                                                                        if($QQuestion->choices) {
                                                                                            foreach($QQuestion->choices as $QChoices) {
                                                                                        // $currentAnswer
                                                                                                $currentAnswer = QAnswers_course::model()->find(array(
                                                                                                    'condition' => 'user_id = "' . Yii::app()->user->id . '" AND choice_id ="' . $QChoices->option_choice_id . '" AND quest_ans_id ="' . $checkAnswerYet->id . '"'." AND gen_id='".$gen_id."'",
                                                                                                ));
                                                                                                ?>
                                                                                                <tr>
                                                                                                    <td><?= $QChoices->option_choice_name ?></td>
                                                                                                    <?php
                                                                                                    if($QQuestion->question_range > 0) {
                                                                                                        $j = $QQuestion->question_range;
                                                                                                        for($i=1; $i <= $QQuestion->question_range; $i++) {
                                                                                                            ?>
                                                                                                            <td class="center"><input type="radio" disabled <?= ($currentAnswer->answer_numeric == $j)?'checked':null ?> /></td>
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
                                                                                } else if($QQuestion->input_type_id == 2) { ?> 
                                                                                    <table class="table table-bordered post-question">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <td colspan="3" class="head-question text-left"><?= $QQuestion->question_name ?></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td class="head-question">ตัวเลือก</td>
                                                                                                <td class="head-question">คำถาม</td>
                                                                                                <td class="head-question">หมายเหตุ</td>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <?php 
                                                                                        if($QQuestion->choices) {
                                                                                            foreach($QQuestion->choices as $QChoices) {
                                                                                        // $currentAnswer
                                                                                                $currentAnswer = QAnswers_course::model()->find(array(
                                                                                                    'condition' => 'user_id = "' . Yii::app()->user->id . '" AND choice_id ="' . $QChoices->option_choice_id . '" AND quest_ans_id ="' . $checkAnswerYet->id . '"'." AND gen_id='".$gen_id."'",
                                                                                                ));
                                                                                                ?>
                                                                                                <tr>
                                                                                                    <td><input type="radio" disabled <?= !empty($currentAnswer) ? 'checked' : '' ?>></td>
                                                                                                    <td><?= $QChoices->option_choice_name ?></td>
                                                                                                    <td class="center"><?= $currentAnswer->answer_text ?></td>
                                                                                                </tr>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    </table>  
                                                                                <?php } else if($QQuestion->input_type_id == 3) { ?> 
                                                                                   <table class="table table-bordered post-question">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <td colspan="3" class="head-question text-left"><?= $QQuestion->question_name ?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="head-question">ตัวเลือก</td>
                                                                                            <td class="head-question">คำถาม</td>
                                                                                            <td class="head-question">หมายเหตุ</td>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <?php 
                                                                                    if($QQuestion->choices) {
                                                                                        foreach($QQuestion->choices as $QChoices) {
                                                                                        // $currentAnswer
                                                                                            $currentAnswer = QAnswers_course::model()->find(array(
                                                                                                'condition' => 'user_id = "' . Yii::app()->user->id . '" AND choice_id ="' . $QChoices->option_choice_id . '" AND quest_ans_id ="' . $checkAnswerYet->id . '"'." AND gen_id='".$gen_id."'",
                                                                                            ));
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td><input type="checkbox" disabled <?= !empty($currentAnswer) ? 'checked' : '' ?>></td>
                                                                                                <td><?= $QChoices->option_choice_name ?></td>
                                                                                                <td class="center"><?= $currentAnswer->answer_text ?></td>
                                                                                            </tr>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </table>
                                                                                <?php    
                                                                            } else if($QQuestion->input_type_id == 5) { ?>
                                                                                <table class="table table-bordered post-question">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <td colspan="2" class="head-question text-left"><?= $QQuestion->question_name ?></td>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <?php 
                                                                                    if($QQuestion->choices) {
                                                                                        foreach($QQuestion->choices as $QChoices) {
                                                                                        // $currentAnswer
                                                                                            $currentAnswer = QAnswers_course::model()->find(array(
                                                                                                'condition' => 'user_id = "' . Yii::app()->user->id . '" AND choice_id ="' . $QChoices->option_choice_id . '" AND quest_ans_id ="' . $checkAnswerYet->id . '"'." AND gen_id='".$gen_id."'",
                                                                                            ));
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td width="10%" class="text-left">คำตอบ</td>
                                                                                                <td class="text-left"><?= $currentAnswer->answer_textarea ?></td>
                                                                                            </tr>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </table>
                                                                                <?php
                                                                            } else { ?>
                                                                                <table class="table table-bordered post-question">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <td colspan="2" class="head-question text-left"><?= $QQuestion->question_name ?></td>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <?php 
                                                                                    if($QQuestion->choices) {
                                                                                        foreach($QQuestion->choices as $QChoices) {
                                                                                        // $currentAnswer
                                                                                            $currentAnswer = QAnswers_course::model()->find(array(
                                                                                                'condition' => 'user_id = "' . Yii::app()->user->id . '" AND choice_id ="' . $QChoices->option_choice_id . '" AND quest_ans_id ="' . $checkAnswerYet->id . '"'." AND gen_id='".$gen_id."'",
                                                                                            ));
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td width="10%" class="text-left">คำตอบ</td>
                                                                                                <td class="text-left"><?= $currentAnswer->answer_text ?></td>
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
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        } else {
                                            $InactivateSurvey++;
                                        }
                                    }
                                    if($InactivateSurvey == count($CourseSurvey)) {
                                        ?>
                                        <div class="box-body panel-body bg-white">
                                            <div class="warningArea">
                                                <i class="fa fa-exclamation-circle fa-5x text-danger"></i>
                                            </div>
                                            <div class="warningArea">
                                                <span class="text-danger font-bold"><?= $label->label_noSurveyCourse ?></span>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="box-body panel-body bg-white">
                                        <div class="warningArea">
                                            <i class="fa fa-exclamation-circle fa-5x text-danger"></i>
                                        </div>
                                        <div class="warningArea">
                                            <span class="text-danger font-bold"><?= $label->label_noSurveyCourse ?></span>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>

                    </div>
                    <div class="btn-learn hidden-xs">
                        <!-- href="<?php echo $this->createUrl('/course/detail', array('id' => $course->course_id,'gen'=>$gen)); ?>" -->
                        <a id="btn_completed" class="btn btn-warning btn-lg" role="button" ><?= $Completed ?></a>
                    </div>
                </div>

                <!-- <div class="col-sm-4 col-md-3"> -->

                    <!-- < ?php
                    echo $this->renderPartial('_right_course', array(
                        'lessonCurrent'=>$lessonCurrent,
                        'lessonList'=>$lessonList,
                        'course'=>$course,
                        'courseTec'=>$courseTec,
                        'model_cate'=>$model_cate,
                        'label'=>$label,
                    ));
                    ?> -->
                    <!-- </div> -->

                </div>
            </div>
        </section>	
        <script>

            function alertswal(){
                swal('<?= $label->label_swal_warning ?>', '<?= $label->label_swal_plsLearnPass ?>', "error");
            }

            function alertswal_test(){
                swal('<?= $label->label_swal_warning ?>', '<?= $label->label_swal_plsTestPost ?>', "error");
            }

            $(function () {
                // console.log((document.referrer).split("/")[4]);
                // console.log(document.URL);
                // console.log(document.referrer);
                if((document.referrer).split("/")[4] == "questionnaire_course"){
                    var urll = "<?= $this->createUrl("course/detail") ?>"+"/"+(document.URL).split("/")[6]+"?gen="+<?= $gen ?>;
                    // console.log(urll);
                    $("#btn_completed").attr("href", urll);
                }else{
                    
                    // if(document.referrer == ""){
                        var urll = "<?= $this->createUrl("course/detail") ?>"+"/"+"<?=$course->course_id?>"+"?gen="+<?= $gen ?>;;
                    $("#btn_completed").attr("href", urll);
                    // }else{
                    //     $("#btn_completed").attr("href", document.referrer);
                    // }
                }

                $('.checkRequirement').click(function(e) {
                    e.preventDefault();
                    var currentUrl = $(this).attr('href');
                    $.post("<?= $this->createUrl("course/checkrequirement") ?>", { lesson_id: $(this).data('require-id') }, function(respon) {
                        var jsonRespon = JSON.parse(respon);
                //
                switch(jsonRespon.status) {
                    case 1:
                    swal('<?= $label->label_congratulations ?>', jsonRespon.errormsg, "success");
                        // currentUrl
                        swal({
                            title: '<?= $label->label_congratulations ?>',
                            text: '<?= $label->label_thank ?>',
                            type: "success",
                            showCancelButton: false,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: '<?= $label->label_backToSurvey ?>',
                            allowOutsideClick: true,
                            closeOnConfirm: false
                        },
                        function(isConfirm){
                            if(isConfirm) {
                                window.location.href = currentUrl;
                            }
                        });
                        break;
                        case 2:
                        swal('<?= $label->label_noPermis ?>', jsonRespon.errormsg, "error");
                        break;
                        default:
                        swal('<?= $label->label_error ?>', jsonRespon.errormsg, "warning");
                        break;
                    }
                });
                });

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


        </script>