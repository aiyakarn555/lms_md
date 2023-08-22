


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

                <?php 

                if($model->lang_id != 1){
                $label = MenuSite::model()->find(array(
                'condition' => 'lang_id=:lang_id',
                'params' => array(':lang_id' => $model->lang_id)
                ));
                }

                ?>

                <h4 class="labelCourse"><i class="fa fa-desktop" aria-hidden="true"></i>&nbsp; เมนูหน้าแรก<h4>

                <div class="row">
                    <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_imgslide'); ?>
                    <?php echo $form->textField($label, 'label_imgslide', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_imgslide'); ?>
                    </div>
                

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_vdo'); ?>
                    <?php echo $form->textField($label, 'label_vdo', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_vdo'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_course'); ?>
                    <?php echo $form->textField($label, 'label_course', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_course'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_news'); ?>
                    <?php echo $form->textField($label, 'label_news', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_news'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_docs'); ?>
                    <?php echo $form->textField($label, 'label_docs', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_docs'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_linkall'); ?>
                    <?php echo $form->textField($label, 'label_linkall', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_linkall'); ?>
                </div>

                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_viewAll'); ?>
                    <?php echo $form->textField($label, 'label_viewAll', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_viewAll'); ?>
                </div>

            </div>

            <h4 class="labelCourse"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp; เมนูหน้าสถานะการเรียน<h4>

                <div class="row">
                    <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_statusLearn'); ?>
                    <?php echo $form->textField($label, 'label_statusLearn', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_statusLearn'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_homepage'); ?>
                    <?php echo $form->textField($label, 'label_homepage', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_homepage'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_statusCourse'); ?>
                    <?php echo $form->textField($label, 'label_statusCourse', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_statusCourse'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_status'); ?>
                    <?php echo $form->textField($label, 'label_status', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_status'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_resultLearn'); ?>
                    <?php echo $form->textField($label, 'label_resultLearn', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_resultLearn'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_search'); ?>
                    <?php echo $form->textField($label, 'label_search', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_search'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_course'); ?>
                    <?php echo $form->textField($label, 'label_course', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_course'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_courseSearch'); ?>
                    <?php echo $form->textField($label, 'label_courseSearch', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_courseSearch'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_gen'); ?>
                    <?php echo $form->textField($label, 'label_gen', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_gen'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_notLearn'); ?>
                    <?php echo $form->textField($label, 'label_notLearn', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_notLearn'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_learned'); ?>
                    <?php echo $form->textField($label, 'label_learned', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_learned'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_learning'); ?>
                    <?php echo $form->textField($label, 'label_learning', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_learning'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_printCert'); ?>
                    <?php echo $form->textField($label, 'label_printCert', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_printCert'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_lesson'); ?>
                    <?php echo $form->textField($label, 'label_lesson', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_lesson'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_result'); ?>
                    <?php echo $form->textField($label, 'label_result', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_result'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_test'); ?>
                    <?php echo $form->textField($label, 'label_test', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_test'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_testFinal'); ?>
                    <?php echo $form->textField($label, 'label_testFinal', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_testFinal'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_assessSatisfaction'); ?>
                    <?php echo $form->textField($label, 'label_assessSatisfaction', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_assessSatisfaction'); ?>
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
                    <?php echo $form->labelEx($label, 'label_learnPass'); ?>
                    <?php echo $form->textField($label, 'label_learnPass', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_learnPass'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_learnFail'); ?>
                    <?php echo $form->textField($label, 'label_learnFail', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_learnFail'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_DotestPre'); ?>
                    <?php echo $form->textField($label, 'label_DotestPre', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_DotestPre'); ?>
                </div>


                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_NoPreTest'); ?>
                    <?php echo $form->textField($label, 'label_NoPreTest', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_NoPreTest'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_DotestPost'); ?>
                    <?php echo $form->textField($label, 'label_DotestPost', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_DotestPost'); ?>
                </div>


                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_NoPostTest'); ?>
                    <?php echo $form->textField($label, 'label_NoPostTest', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_NoPostTest'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_haveNotTest'); ?>
                    <?php echo $form->textField($label, 'label_haveNotTest', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_haveNotTest'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_seeResult'); ?>
                    <?php echo $form->textField($label, 'label_seeResult', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_seeResult'); ?>
                </div>
            </div>
    
            <h4 class="labelCourse"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>&nbsp; แจ้งเตือน (Alert ต่างๆ)<h4>
                <div class="row">
                    <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_alert_warning'); ?>
                    <?php echo $form->textField($label, 'label_alert_warning', array('size' => 60, 'maxlength' => 250, 'class' => 'width400')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_alert_warning'); ?>
                    </div>

                <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_swal_learnPass'); ?>
                    <?php echo $form->textField($label, 'label_swal_learnPass', array('size' => 60, 'maxlength' => 250, 'class' => 'width400')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_swal_learnPass'); ?>
                </div>
            </div>
        
         <h4 class="labelCourse"><i class="fa fa-header" aria-hidden="true"></i>&nbsp; แถบเมนูด้านบน (Header)<h4>
            <div class="row">
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_header_login'); ?>
                    <?php echo $form->textField($label, 'label_header_login', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_header_login'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_header_dashboard'); ?>
                    <?php echo $form->textField($label, 'label_header_dashboard', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_header_dashboard'); ?>
                </div>


                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_header_update'); ?>
                    <?php echo $form->textField($label, 'label_header_update', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_header_update'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_header_logout'); ?>
                    <?php echo $form->textField($label, 'label_header_logout', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_header_logout'); ?>
                </div>


                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_header_msg'); ?>
                    <?php echo $form->textField($label, 'label_header_msg', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_header_msg'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_header_msgAll'); ?>
                    <?php echo $form->textField($label, 'label_header_msgAll', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_header_msgAll'); ?>
                </div>


                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_header_regis'); ?>
                    <?php echo $form->textField($label, 'label_header_regis', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_header_regis'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_header_username'); ?>
                    <?php echo $form->textField($label, 'label_header_username', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_header_username'); ?>
                </div>


                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_header_password'); ?>
                    <?php echo $form->textField($label, 'label_header_password', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_header_password'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_header_remember'); ?>
                    <?php echo $form->textField($label, 'label_header_remember', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_header_remember'); ?>
                </div>


                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_header_forgotPass'); ?>
                    <?php echo $form->textField($label, 'label_header_forgotPass', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_header_forgotPass'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_header_yes'); ?>
                    <?php echo $form->textField($label, 'label_header_yes', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_header_yes'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_placeholder_search'); ?>
                    <?php echo $form->textField($label, 'label_placeholder_search', array('size' => 60, 'maxlength' => 250, 'class' => 'width600')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_placeholder_search'); ?>
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
