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
$criteria = new CDbCriteria;
$criteria->condition = ' course_id="' . $course->course_id . '" AND user_id="' . Yii::app()->user->id . '" AND score_number IS NOT NULL AND active="y"';
$criteria->order = 'create_date ASC';

$countCoursemanage = Coursemanage::Model()->count("id=:id AND active=:active", array(
    "id" => $course->course_id,
    "active" => "y",
));
$category = Category::model()->findByPk($course->cate_id);
$checkCourseTest = Helpers::lib()->checkCoursePass($course->course_id);

$BestFinalTestScore = Coursescore::model()->findAll($criteria);

$allPassed = false;

if($category->special_category == 'y') {
    if($BestFinalTestScore) {
        foreach($BestFinalTestScore as $time => $FinalTest) {
            if($FinalTest->score_past == 'y') {
                $allPassed = true;
            }
        }
    }
} else {
    if($checkCourseTest == 'pass') {
        $allPassed = true;
    }
}

?>
<div class="header-page parallax-window" data-parallax="scroll" data-image-src="<?php //echo Yii::app()->theme->baseUrl.'/images/bg-header-page.png'; ?>">
  <div class="container">
    <h1><?=  $label->label_printCert ?>
    <small class="pull-right">
    <ul class="list-inline list-unstyled">
      <li><a href="<?php echo $this->createUrl('/site/index'); ?>"><?=  $label->label_homepage ?></a></li>/
      <li><span class="text-bc"><?=  $label->label_printCert ?></span></li>
    </ul>
    </small>
    </h1>
  </div>
  <div class="bottom1"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/kind-bottom.png" class="img-responsive" alt=""></div>
</div>
    <!-- Start Content -->
    <section class="content" id="course-detail">
        <div class="container">
        <!-- Start Step -->
            <!--<div class="row bg-white pd-1em">-->
                <!-- Start Render Partial -->
                <?php
                $this->renderPartial('menu-steps', array(
                    'course' => $course,
                    'stepActivate' => $stepActivate,
                    'lessonList' => $lessonList,
                    'label' => $label,
                ));
                ?>
            <!--</div>-->
            <!-- End Step -->
            <div class="row blog-post-page">
                <div class="col-md-9 blog-box bg-white pd-2em">
                    <!-- Classic Heading -->
                    <!--<h4 class="classic-title"><span style="border-bottom: 4px solid #38602f">รายละเอียด</span></h4>-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body panel-body">
                                <?php
                                if($allPassed) {
                                ?>
                                <div class="col-md-12 warningArea">
                                    <div class="p">
                                        <a class="btn btn-success PrintCertificate" href="<?php echo $this->createUrl('Course/PrintCertificate', array('id' => $course->course_id)); ?>" target="_blank">
                                            <i class="fa fa-print fa-4x"></i>
                                        </a>
                                    </div>
                                    <div class="p">
                                        <?=  $label->label_printCert ?> <br />
                                       <a class="PrintCertificate" href="<?php echo $this->createUrl('Course/PrintCertificate', array('id' => $course->course_id, 'dl' => 'dl')); ?>" style="color: blue; font-weight: 900;"><?=  $label->label_save ?></a>
                                    </div>
                                </div>
                                <?php 
                                } else {
                                ?>
                                <div class="col-md-12 warningArea">
                                    <div class="p">
                                        <span class="fa-stack fa-4x text-danger">
                                            <i class="fa fa-square-o fa-stack-2x"></i>
                                            <i class="fa fa-warning fa-stack-1x"></i>
                                        </span>
                                    </div>
                                    <div class="p">
                                        <?=  $label->label_cantPrintCert ?>
                                    </div>
                                </div>
                                <?php 
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 sidebar right-sidebar bg-white50 pd-1em">
                    <div class="row mb-1em">
                        <div class="col-md-12">
                            <a href="javascript:history.go(-1)" class="btn btn-warning center-block"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                                <?=  $label->label_back ?></a>
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
                        'label'=>$label,
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