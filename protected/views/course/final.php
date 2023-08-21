<link href="<?= Yii::app()->theme->baseUrl ?>/css/jquery.wizard.css" rel="stylesheet" type="text/css">
<script src="<?= Yii::app()->theme->baseUrl ?>/js/jquery.wizard.js"></script>
<style type="text/css">
    .box-body, .box-body-notthing { padding: 15px; margin-bottom: 1em; border-radius: 4px; border: 1px solid rgba(119, 119, 119, 0.5); }
    .box-content-body { padding: 10px; }
    .box-content-body h1 { border-bottom: 2px solid #f0ad4e; line-height: 20px; padding-bottom: 10px; }
    .font-normal { font-size: 1em; }
    .font-big { font-size: 2em; }
    .padleft { padding-left: 20px !important; }
    .warningArea { text-align: center; padding: 5px; }
    .passFinalTest { color: green; }
    .notPassFinalTest { color: red; }
    .center {
        text-align: center;
    }
    
</style>
<?php

if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
        $langId = Yii::app()->session['lang'] = 1;
    }else{
        $langId = Yii::app()->session['lang'];
    }

$checkQuestinaireOnCourse = CourseTeacher::model()->findAllByAttributes(array('course_id' => $course->course_id));
$checkAnswerYet = true;

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
    }else{
        $checkAnswerYet = false;
    }
}

$doQuestionBeforeFinalTest = Helpers::lib()->checkCourseQuestion($course->course_id);

$criteria = new CDbCriteria;
$criteria->condition = ' course_id="' . $course->course_id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL  and active ="y"';
$criteria->order = 'create_date ASC';

$allFinalTest = Coursescore::model()->findAll($criteria);

$passed = false;
$doFinalTest = true;

?>
<div class="header-page parallax-window" data-parallax="scroll" data-image-src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-header-page.png">
        <div class="container">
            <?php // $Model = CourseOnline::model()->findByAttributes(array('cate_id'=>$id,)); ?>    
            <h1><?= $course->course_title ?> <?= $course->getGen($course->course_id); ?>

                <small class="pull-right">
                    <ul class="list-inline list-unstyled">
                        <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><?= $label->label_homepage ?></a></li>/
                        <li><a href="<?php echo $this->createUrl('/course/index'); ?>"><?= $label->label_course ?></a></li>/
                        <li><span class="text-bc"><?= $course->course_title ?> <?= $course->getGen($course->course_id); ?></span></li>
                    </ul>
                </small>
            </h1>
        </div>
        <div class="bottom1"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/kind-bottom.png" class="img-responsive" alt=""></div>
    </div>

    <!-- Content -->
    <section class="content" id="course-detail">
        <div class="container">
            <?php
                            $this->renderPartial('menu-steps', array(
                                'course' => $course,
                                'stepActivate' => $stepActivate,
                                'lessonList' => $lessonList,
                                'label' => $label
                            ));
                            ?>
            
            <div class="row blog-post-page">
                <div class="col-md-9 blog-box bg-white pd-2em">
                    <!-- Classic Heading -->
<!--                    <h4 class="classic-title"><span>รายละเอียด</span></h4>-->
                <?php
                    if(!$checkAnswerYet) {
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box-body panel-body cannotTestFinal">
                                    <div class="col-md-12">
                                        <div class="panel-body">
                                            <div class="warningArea">
                                                <i class="fa fa-warning fa-4x text-warning"></i>
                                            </div>
                                            <div class="warningArea">
                                                <h1><?= $label->label_doNotQuestionnaire ?></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        if(!$doQuestionBeforeFinalTest) {
                            $checkQuestionBeforeTest = CourseTeacher::model()->findAllByAttributes(array('course_id'=>$course->course_id));;
                            if($checkQuestionBeforeTest) {
                                foreach($checkQuestionBeforeTest as $j => $questionBeforeTest) {
                    ?>
                        <div class="row">
                            <a href="<?= $this->createUrl('questionnaire_course/index', array('id' => $questionBeforeTest->id)) ?>" class="checkRequirement" data-require-id="<?= $course->course_id ?>">
                            <div class="col-md-12">
                                <div class="box-body panel-body">
                                    <div class="warningArea">
                                        <span class="fa-stack fa-5x text-danger">
                                            <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                            <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </div>
                                    <div class="warningArea">
                                        <h1><?= $label->label_doNotSurveyCourse ?></h1>
                                        <small class="text-success"><?= $label->label_doSurveyCourse ?>  <?= $j+1 ?> </small>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    <?php
                                }
                            } else {
                                echo $label->label_noSurveyCourse."!";
                            }
                        } else {
                            if($allFinalTest) {
                                if($allFinalTest) {
                                    foreach($allFinalTest as $i => $FinalTest) {
                                        $percent = number_format(($FinalTest->score_number/$FinalTest->score_total)*100,0);
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="box-body panel-body">
                                            <div class="col-md-3">
                                                <div class="center">
                                                    <input type="text" class="knob" value="<?= $percent ?>" data-skin="tron" data-thickness="0.2" data-width="80%" data-height="100%" data-fgColor="#28cbff" data-readonly="true">
                                                </div>
                                                <div class="center">
                                                    <small><?= $label->label_percentage ?></small>
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="box-content-body">
                                                    <h1><?= $label->label_resultFinal ?> <?= $i+1 ?></h1>
                                                </div>
                                                <div class="box-content-body">
                                                    <?php
                                                        if($FinalTest->score_past=='y') {
                                                            $passed = true;
                                                            ?>
                                                            <div class="passFinalTest"><i class="fa fa-check" aria-hidden="true"></i> <?= $label->label_passTest ?> <?=$course->percen_test?>% <?= $label->label_haveCorrect ?> <?= $FinalTest->score_number ?> <?= $label->label_list ?></div>
                                                            <?php
                                                        } else {   
                                                            ?>
                                                            <div class="notPassFinalTest"><i class="fa fa-close" aria-hidden="true"></i> <?= $label->label_notPassTest ?> <?=$course->percen_test?>% <?= $label->label_haveCorrect ?> <?= $FinalTest->score_number ?> <?= $label->label_list ?></div>
                                                            <?php
                                                        }
                                                    ?>
                                                </div>
                                                <div class="box-content-body col-md-6">
                                                    <h6 style="font-size: 18px;"><?= $label->label_totalTest ?>: <font style="font-weight: 500;"><?= $FinalTest->score_total ?> <?= $label->label_list ?></font> | <?= $label->label_point ?>: <font style="font-weight: 500;"><?= $FinalTest->score_number ?> <?= $label->label_list ?></font></h6>
                                                </div>
                                                <div class="box-content-body col-md-6">
                                                    <h5 style="font-size: 18px;"><?= $label->label_dateTest ?>: <font style="font-weight: 500;"><?= Helpers::lib()->changeFormatDate($FinalTest->create_date, 'datetime') ?></font></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                        
                                    }
//                                    if(!$passed && count($allFinalTest) == 1) {
                                    if(!$passed && count($allFinalTest) <= $course->cate_amount) {
                                        ?>
                                         <div class="row">
                                            <a href="<?= $this->createUrl('coursequestion/preexams', array('id' => $course->course_id)) ?>" class="checkRequirement" data-require-id="<?= $course->course_id ?>">
                                                <div class="col-md-12">
                                                    <div class="box-body panel-body cannotTestFinal">
                                                        <div class="col-md-12">
                                                            <div class="panel-body">
                                                                <div class="warningArea">
                                                                    <i class="fa fa-pencil fa-4x text-info"></i>
                                                                </div>
                                                                <div class="warningArea">
                                                                    <h1> <?= $label->label_resultFinal ?> <?=count($allFinalTest)+1?></h1>
                                                                    <small class="text-success"><?= $label->label_startTestCourse ?> ครั้งที่ <?=count($allFinalTest)+1?></small>
                                                                    <?php if(count($allFinalTest)+1 == $course->cate_amount){ ?><small class="text-danger"><strong> <?= $label->label_mess_notPass ?>
                                                                    </strong></small> <?php } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                    <!--
                                        <a class="btn btn-default" href="<?= $this->createUrl('coursequestion/preexams', array('id' => $course->course_id)) ?>" target="_self"><i class="fa fa-pencil-square"></i> สอบ Final ครั้งที่ <?=count($allFinalTest)+1?></a> <?php if(count($allFinalTest)+1 == $course->cate_amount){ ?><small class="text-danger"> หากผู้สอบ <strong>"ไม่ผ่านการสอบครั้งที่ <?=$course->cate_amount?>"</strong> และต้องการสอบใหม่ จำเป็นต้องเริ่มเรียนใหม่</small> <?php } ?>
                                        --><?php
                                    }
                                    if($passed) {
                                        ?>
                                        <div class="row">
                                            <a href="<?= $this->createUrl('course/certificate', array('id' => $course->course_id)) ?>" class="PrintCertificate" data-require-id="<?= $course->course_id ?>">
                                                <div class="col-md-12">
                                                    <div class="box-body panel-body cannotTestFinal">
                                                        <div class="col-md-12">
                                                            <div class="panel-body">
                                                                <div class="warningArea">
                                                                    <i class="fa fa-print fa-4x text-info"></i>
                                                                </div>
                                                                <div class="warningArea">
                                                                    <h1> <?= $label->label_printCert ?></h1>
                                                                    <!--<small class="text-success">พิมพ์หนังสือรับรอง</small>-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <!--<a class="btn btn-default PrintCertificate" href="<?= $this->createUrl('course/certificate', array('id' => $course->course_id)) ?>" target="_self"><i class="fa fa-print"></i> พิมพ์หนังสือรับรอง</a>-->
                                        <?php
                                    }
                                }
                            } else {
                    ?>
                                <div class="row">
                                    <a href="<?= $this->createUrl('coursequestion/preexams', array('id' => $course->course_id)) ?>" class="checkRequirement" data-require-id="<?= $course->course_id ?>">
                                        <div class="col-md-12">
                                            <div class="box-body panel-body cannotTestFinal">
                                                <div class="col-md-12">
                                                    <div class="panel-body">
                                                        <div class="warningArea">
                                                            <i class="fa fa-pencil fa-4x text-info"></i>
                                                        </div>
                                                        <div class="warningArea">
                                                            <h1><?= $label->label_doNotTestCourse ?></h1>
                                                            <small class="text-success"><?= $label->label_startTestCourse ?></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                    <?php
                            }
                        } 
                    }
                    ?>
                </div>
                <div class="col-md-3 sidebar right-sidebar bg-white50 pd-1em">
                    <div class="row mb-1em">
                        <div class="col-md-12">
                            <a href="javascript:history.go(-1)" class="btn btn-warning center-block"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                                    <?= $label->label_back ?></a>
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
    </section>
<script>
    $(function () {
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