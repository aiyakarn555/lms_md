


<script src="<?php echo $this->assetsBase; ?>/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo $this->assetsBase; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<script src="<?php echo $this->assetsBase; ?>/js/jwplayer/jwplayer.js" type="text/javascript"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript">jwplayer.key = "J0+IRhB3+LyO0fw2I+2qT2Df8HVdPabwmJVeDWFFoplmVxFF5uw6ZlnPNXo=";</script>
<script type="text/javascript">

</script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/uploadifive.css">
<style type="text/css">
    body {
        font: 13px Arial, Helvetica, Sans-serif;
    }
    .uploadifive-button {
        float: left;
        margin-right: 10px;
    }
    #queue {
        border: 1px solid #E5E5E5;
        height: 177px;
        overflow: auto;
        margin-bottom: 10px;
        padding: 0 3px 3px;
        width: 600px;
    }
    .width400{width: 400px;}
</style>

<!-- innerLR -->
<div class="innerLR">
    <div class="widget widget-tabs border-bottom-none">
        <div class="widget-head">
            <ul>
                <li class="active">
                    <a class="glyphicons edit" href="#account-details" data-toggle="tab">
                        <i></i><?php echo $formtext; ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="widget-body">
            <div class="form">
                <?php
                $form = $this->beginWidget('AActiveForm', array(
                    'id' => 'MainMenu-form',
                    'clientOptions' => array(
                        'validateOnSubmit' => true
                    ),
                    'errorMessageCssClass' => 'label label-important',
                    'htmlOptions' => array('enctype' => 'multipart/form-data')
                ));
                ?>
                <!-- <div class="row" style="display: none;">
                    <?php echo $form->labelEx($model, 'lang_id'); ?>
                    <?php echo $this->listlanguageShow($model, 'lang_id','width600'); ?>
                    <?php echo $form->textField($model, 'lang_id'); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'lang_id'); ?>
                </div>
                
                <div class="row" id="parent_id" style="display: none;">
                    <?php echo $form->labelEx($model, 'parent_id'); ?>
                    <?php echo $this->listParentMainmenuShow($model, 'parent_id','width600'); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'parent_id'); ?>
                </div> -->

                <div class="row">
                    <?php echo $form->labelEx($model, 'title'); ?>
                    <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </div>
                <?php if(!isset($_GET['parent_id'])){ ?>
                <div class="row" id="url">
                    <?php echo $form->labelEx($model, 'url'); ?>
                    <?php echo $form->textField($model, 'url', array('size' => 60, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'url'); ?>
                </div>
               <?php } ?>

               <h4 class="labelCourse"><i class="fa fa-bars" aria-hidden="true"></i>&nbsp; แถบเมนูรายการหลักสูตร<h4>
                <div class="row">
                    <div class="col-md-4">

                    <?php echo $form->labelEx($label, 'label_course'); ?>
                    <?php echo $form->textField($label, 'label_course', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_course'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_homepage'); ?>
                    <?php echo $form->textField($label, 'label_homepage', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_homepage'); ?>
                </div>


                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_search'); ?>
                    <?php echo $form->textField($label, 'label_search', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_search'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_cate'); ?>
                    <?php echo $form->textField($label, 'label_cate', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_cate'); ?>
                </div>
            </div>

            <h4 class="labelCourse"><i class="fa fa-book" aria-hidden="true"></i>&nbsp; หน้ารายละเอียดหลักสูตร<h4>

                <div class="row">
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_startLearn'); ?>
                    <?php echo $form->textField($label, 'label_startLearn', array('size' => 60, 'maxlength' => 155, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_startLearn'); ?>
                </div>

                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_DocsDowload'); ?>
                    <?php echo $form->textField($label, 'label_DocsDowload', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_DocsDowload'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_alert_msg_StartLearn'); ?>
                    <?php echo $form->textField($label, 'label_alert_msg_StartLearn', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_alert_msg_StartLearn'); ?>
                </div>
                
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_alert_msg_expired'); ?>
                    <?php echo $form->textField($label, 'label_alert_msg_expired', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_alert_msg_expired'); ?>
                </div>

                
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_step'); ?>
                    <?php echo $form->textField($label, 'label_step', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_step'); ?>
                </div>

                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_Content'); ?>
                    <?php echo $form->textField($label, 'label_Content', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_Content'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_gotoLesson'); ?>
                    <?php echo $form->textField($label, 'label_gotoLesson', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_gotoLesson'); ?>
                </div>

                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_detail'); ?>
                    <?php echo $form->textField($label, 'label_detail', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_detail'); ?>
                </div>

                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_courseName'); ?>
                    <?php echo $form->textField($label, 'label_courseName', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_courseName'); ?>
                </div>

                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_statuslearn'); ?>
                    <?php echo $form->textField($label, 'label_statuslearn', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_statuslearn'); ?>
                </div>

                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_testPre'); ?>
                    <?php echo $form->textField($label, 'label_testPre', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_testPre'); ?>
                </div>

                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_testPost'); ?>
                    <?php echo $form->textField($label, 'label_testPost', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_testPost'); ?>
                </div>

                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_point'); ?>
                    <?php echo $form->textField($label, 'label_point', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_point'); ?>
                </div>

                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_DoTest'); ?>
                    <?php echo $form->textField($label, 'label_DoTest', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_DoTest'); ?>
                </div>

                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_resultTestPre'); ?>
                    <?php echo $form->textField($label, 'label_resultTestPre', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_resultTestPre'); ?>
                </div>

                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_survey'); ?>
                    <?php echo $form->textField($label, 'label_survey', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_survey'); ?>
                </div>
                

                <div class="col-md-4">
                     <?php echo $form->labelEx($label, 'label_questionnaire'); ?>
                    <?php echo $form->textField($label, 'label_questionnaire', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_questionnaire'); ?>
                </div>

                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_Doquestionnaire'); ?>
                    <?php echo $form->textField($label, 'label_Doquestionnaire', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_Doquestionnaire'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_resultTestPost'); ?>
                    <?php echo $form->textField($label, 'label_resultTestPost', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_resultTestPost'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_detailSurvey'); ?>
                    <?php echo $form->textField($label, 'label_detailSurvey', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_detailSurvey'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_surveyName'); ?>
                    <?php echo $form->textField($label, 'label_surveyName', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_surveyName'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_headerSurvey'); ?>
                    <?php echo $form->textField($label, 'label_headerSurvey', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_headerSurvey'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_SatisfactionLv'); ?>
                    <?php echo $form->textField($label, 'label_SatisfactionLv', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_SatisfactionLv'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_download'); ?>
                    <?php echo $form->textField($label, 'label_download', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_download'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_courseRec'); ?>
                    <?php echo $form->textField($label, 'label_courseRec', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_courseRec'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_notLearn'); ?>
                    <?php echo $form->textField($label, 'label_notLearn', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_notLearn'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_lessonPass'); ?>
                    <?php echo $form->textField($label, 'label_lessonPass', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_lessonPass'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_learning'); ?>
                    <?php echo $form->textField($label, 'label_learning', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_learning'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_learnPass'); ?>
                    <?php echo $form->textField($label, 'label_learnPass', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_learnPass'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_courseAll'); ?>
                    <?php echo $form->textField($label, 'label_courseAll', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_courseAll'); ?>
                </div>
            </div>
            
            <h4 class="labelCourse"><i class="fa fa-indent" aria-hidden="true"></i>&nbsp; เมนูสถานะการเรียน (menu steps)<h4>
            <div class="row">
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_courseViewAll'); ?>
                    <?php echo $form->textField($label, 'label_courseViewAll', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_courseViewAll'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_notInLearn'); ?>
                    <?php echo $form->textField($label, 'label_notInLearn', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_notInLearn'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_course_wait'); ?>
                    <?php echo $form->textField($label, 'label_course_wait', array('size' => 60, 'maxlength' => 100, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_course_wait'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_notTestPre'); ?>
                    <?php echo $form->textField($label, 'label_notTestPre', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_notTestPre'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_notTestPost'); ?>
                    <?php echo $form->textField($label, 'label_notTestPost', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_notTestPost'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_trainPass'); ?>
                    <?php echo $form->textField($label, 'label_trainPass', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_trainPass'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_trainFail'); ?>
                    <?php echo $form->textField($label, 'label_trainFail', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_trainFail'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_AssessSatisfaction'); ?>
                    <?php echo $form->textField($label, 'label_AssessSatisfaction', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_AssessSatisfaction'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_testCourse'); ?>
                    <?php echo $form->textField($label, 'label_testCourse', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_testCourse'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_doNotQuestionnaire'); ?>
                    <?php echo $form->textField($label, 'label_doNotQuestionnaire', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_doNotQuestionnaire'); ?>
                </div>
            </div>

            <h4 class="labelCourse"><i class="fa fa-certificate" aria-hidden="true"></i>&nbsp; เมนูพิมพ์ใบประกาศนียบัตร <h4>
            <div class="row">
                <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_printCert'); ?>
                    <?php echo $form->textField($label, 'label_printCert', array('size' => 60, 'maxlength' => 250, 'class' => 'width400')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_printCert'); ?>
                </div>

                <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_cantPrintCert'); ?>
                    <?php echo $form->textField($label, 'label_cantPrintCert', array('size' => 60, 'maxlength' => 250, 'class' => 'width400')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_cantPrintCert'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_save'); ?>
                    <?php echo $form->textField($label, 'label_save', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_save'); ?>
                </div>
            </div>

        <h4 class="labelCourse"><i class="fa fa-align-right" aria-hidden="true"></i>&nbsp; เมนูสรุปผลการสอบหลักสูตร (course final)<h4>
             <div class="row">
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_percentage'); ?>
                    <?php echo $form->textField($label, 'label_percentage', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_percentage'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_passTest'); ?>
                    <?php echo $form->textField($label, 'label_passTest', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_passTest'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_notPassTest'); ?>
                    <?php echo $form->textField($label, 'label_notPassTest', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_notPassTest'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_haveCorrect'); ?>
                    <?php echo $form->textField($label, 'label_haveCorrect', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_haveCorrect'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_list'); ?>
                    <?php echo $form->textField($label, 'label_list', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_list'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_startTestCourse'); ?>
                    <?php echo $form->textField($label, 'label_startTestCourse', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_startTestCourse'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_doNotTestCourse'); ?>
                    <?php echo $form->textField($label, 'label_doNotTestCourse', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_doNotTestCourse'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_totalTest'); ?>
                    <?php echo $form->textField($label, 'label_totalTest', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_totalTest'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_dateTest'); ?>
                    <?php echo $form->textField($label, 'label_dateTest', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_dateTest'); ?>
                </div>

                <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_doSurveyCourse'); ?>
                    <?php echo $form->textField($label, 'label_doSurveyCourse', array('size' => 60, 'maxlength' => 250, 'class' => 'width400')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_doSurveyCourse'); ?>
                </div>

                <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_mess_notPass'); ?>
                    <?php echo $form->textField($label, 'label_mess_notPass', array('size' => 60, 'maxlength' => 250, 'class' => 'width400')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_mess_notPass'); ?>
                </div>

             </div>

        <h4 class="labelCourse"><i class="fa fa-align-right" aria-hidden="true"></i>&nbsp; เมนูสรุปผลด้านซ้าย (menu right)<h4>
            <div class="row">
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_resultFinal'); ?>
                    <?php echo $form->textField($label, 'label_resultFinal', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_resultFinal'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_Fail'); ?>
                    <?php echo $form->textField($label, 'label_Fail', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_Fail'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_Pass'); ?>
                    <?php echo $form->textField($label, 'label_Pass', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_Pass'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_testFinalTimes'); ?>
                    <?php echo $form->textField($label, 'label_testFinalTimes', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_testFinalTimes'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_permisToTestFinal'); ?>
                    <?php echo $form->textField($label, 'label_permisToTestFinal', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_permisToTestFinal'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_NoPermisToTestFinal'); ?>
                    <?php echo $form->textField($label, 'label_NoPermisToTestFinal', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_NoPermisToTestFinal'); ?>
                </div>
            </div>


         <h4 class="labelCourse"><i class="fa fa-file-text-o" aria-hidden="true"></i>&nbsp; เมนูแบบประเมินความพึงพอใจ<h4>       
            <div class="row">
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_surveyCourse'); ?>
                    <?php echo $form->textField($label, 'label_surveyCourse', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_surveyCourse'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_noSurveyCourse'); ?>
                    <?php echo $form->textField($label, 'label_noSurveyCourse', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_noSurveyCourse'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_doNotSurveyCourse'); ?>
                    <?php echo $form->textField($label, 'label_doNotSurveyCourse', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_doNotSurveyCourse'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_AnsweredQuestions'); ?>
                    <?php echo $form->textField($label, 'label_AnsweredQuestions', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_AnsweredQuestions'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_dontAnsweredQuestions'); ?>
                    <?php echo $form->textField($label, 'label_dontAnsweredQuestions', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_dontAnsweredQuestions'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_startDoSurvey'); ?>
                    <?php echo $form->textField($label, 'label_startDoSurvey', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_startDoSurvey'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_cantDoSurvey'); ?>
                    <?php echo $form->textField($label, 'label_cantDoSurvey', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_cantDoSurvey'); ?>
                </div>
            </div>


            <h4 class="labelCourse"><i class="fa fa-window-maximize" aria-hidden="true"></i>&nbsp; แจ้งเตือน (Alert ต่างๆ)<h4>   
            <div class="row">
                <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_swal_checkLearn'); ?>
                    <?php echo $form->textField($label, 'label_swal_checkLearn', array('size' => 60, 'maxlength' => 250, 'class' => 'width400')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_swal_checkLearn'); ?>
                </div>

                <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_swal_warning'); ?>
                    <?php echo $form->textField($label, 'label_swal_warning', array('size' => 60, 'maxlength' => 250, 'class' => 'width400')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_swal_warning'); ?>
                </div>
                
                <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_swal_plsLearnPass'); ?>
                    <?php echo $form->textField($label, 'label_swal_plsLearnPass', array('size' => 60, 'maxlength' => 250, 'class' => 'width400')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_swal_plsLearnPass'); ?>
                </div>

                <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_swal_plsTestPost'); ?>
                    <?php echo $form->textField($label, 'label_swal_plsTestPost', array('size' => 60, 'maxlength' => 250, 'class' => 'width400')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_swal_plsTestPost'); ?>
                </div>

                <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_congratulations'); ?>
                    <?php echo $form->textField($label, 'label_congratulations', array('size' => 60, 'maxlength' => 250, 'class' => 'width400')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_congratulations'); ?>
                </div>

                <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_thank'); ?>
                    <?php echo $form->textField($label, 'label_thank', array('size' => 60, 'maxlength' => 250, 'class' => 'width400')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_thank'); ?>
                </div>

                <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_backToSurvey'); ?>
                    <?php echo $form->textField($label, 'label_backToSurvey', array('size' => 60, 'maxlength' => 250, 'class' => 'width400')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_backToSurvey'); ?>
                </div>

                <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_noPermis'); ?>
                    <?php echo $form->textField($label, 'label_noPermis', array('size' => 60, 'maxlength' => 250, 'class' => 'width400')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_noPermis'); ?>
                </div>

                <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_error'); ?>
                    <?php echo $form->textField($label, 'label_error', array('size' => 60, 'maxlength' => 250, 'class' => 'width400')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_error'); ?>
                </div>
        </div>
        
            

                <div class="row">
                    <?php echo $form->labelEx($model,'status'); ?>
                    <!-- <div class="toggle-button" data-toggleButton-style-enabled="success"> -->
                        <?php echo $form->checkBox($model,'status',array(
                            'data-toggle'=> 'toggle','value'=>"y", 'uncheckValue'=>"n"
                        )); ?>
                    <!-- </div> -->
                    <?php echo $form->error($model,'status'); ?>
                </div>

                
                <br>
                <div class="row buttons">
                    <?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-icon glyphicons ok_2', 'onclick' => "return upload();"), '<i></i>บันทึกข้อมูล'); ?>
                </div>

                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>
<!-- END innerLR -->

<script>
    $(function () {
        init_tinymce();
        // getParentList(1);
    });

    // function getParentList(id){
    //     if(id != '1'){
    //         $("#url").css('display','none');
    //         $("#parent_id").css('display','block');
    //         $("#MainMenu_parent_id").attr('disabled',false);
    //     } else {
    //         $("#url").css('display','block');
    //         $("#parent_id").css('display','none');
    //         $("#MainMenu_parent_id").attr('disabled',true);
    //     }
    // }
</script>
