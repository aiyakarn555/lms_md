


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
    .width500{width: 450px;}
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
                    <?php echo $this->listlanguageShow($model, 'lang_id','span8'); ?>
                    <?php echo $form->textField($model, 'lang_id'); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'lang_id'); ?>
                </div>
                
                <div class="row" id="parent_id" style="display: none;">
                    <?php echo $form->labelEx($model, 'parent_id'); ?>
                    <?php echo $this->listParentMainmenuShow($model, 'parent_id','span8'); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'parent_id'); ?>
                </div> -->

                <div class="row">
                    <?php echo $form->labelEx($model, 'title'); ?>
                    <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 250, 'class' => 'span8')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'title'); ?>
                </div>
                <?php if(!isset($_GET['parent_id'])){ ?>
                <div class="row" id="url">
                    <?php echo $form->labelEx($model, 'url'); ?>
                    <?php echo $form->textField($model, 'url', array('size' => 60, 'class' => 'span8')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'url'); ?>
                </div>
               <?php } ?>

               <h4 class="labelCourse"><i class="fa fa-address-card-o" aria-hidden="true"></i>&nbsp; ฟอร์มสมัครสมาชิก & แก้ไขข้อมูล<h4>
                <div class="row">
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_regis'); ?>
                    <?php echo $form->textField($label, 'label_regis', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_regis'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_homepage'); ?>
                    <?php echo $form->textField($label, 'label_homepage', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_homepage'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_accept'); ?>
                    <?php echo $form->textField($label, 'label_accept', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_accept'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_reject'); ?>
                    <?php echo $form->textField($label, 'label_reject', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_reject'); ?>
                </div>

                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_identification'); ?>
                    <?php echo $form->textField($label, 'label_identification', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_identification'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_email'); ?>
                    <?php echo $form->textField($label, 'label_email', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_email'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_courseAll'); ?>
                    <?php echo $form->textField($label, 'label_courseAll', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_courseAll'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_placeholder_course'); ?>
                    <?php echo $form->textField($label, 'label_placeholder_course', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_placeholder_course'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_title'); ?>
                    <?php echo $form->textField($label, 'label_title', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_title'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_firstname'); ?>
                    <?php echo $form->textField($label, 'label_firstname', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_firstname'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_lastname'); ?>
                    <?php echo $form->textField($label, 'label_lastname', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_lastname'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_phone'); ?>
                    <?php echo $form->textField($label, 'label_phone', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_phone'); ?>
                </div>
                <!-- <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_station'); ?>
                    <?php echo $form->textField($label, 'label_station', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_station'); ?>
                </div> -->
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_company'); ?>
                    <?php echo $form->textField($label, 'label_company', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_company'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_position'); ?>
                    <?php echo $form->textField($label, 'label_position', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_position'); ?>
                </div>
               <!--  <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_placeholder_station'); ?>
                    <?php echo $form->textField($label, 'label_placeholder_station', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_placeholder_station'); ?>
                </div> -->
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_placeholder_company'); ?>
                    <?php echo $form->textField($label, 'label_placeholder_company', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_placeholder_company'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_placeholder_position'); ?>
                    <?php echo $form->textField($label, 'label_placeholder_position', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_placeholder_position'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_save'); ?>
                    <?php echo $form->textField($label, 'label_save', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_save'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_employee_id'); ?>
                    <?php echo $form->textField($label, 'label_employee_id', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_employee_id'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_passport'); ?>
                    <?php echo $form->textField($label, 'label_passport', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_passport'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_date_of_expiry'); ?>
                    <?php echo $form->textField($label, 'label_date_of_expiry', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_date_of_expiry'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_birthday'); ?>
                    <?php echo $form->textField($label, 'label_birthday', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_birthday'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_age'); ?>
                    <?php echo $form->textField($label, 'label_age', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_age'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_month'); ?>
                    <?php echo $form->textField($label, 'label_month', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_month'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_race'); ?>
                    <?php echo $form->textField($label, 'label_race', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_race'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_nationality'); ?>
                    <?php echo $form->textField($label, 'label_nationality', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_nationality'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_religion'); ?>
                    <?php echo $form->textField($label, 'label_religion', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_religion'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_sex'); ?>
                    <?php echo $form->textField($label, 'label_sex', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_sex'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_blood'); ?>
                    <?php echo $form->textField($label, 'label_blood', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_blood'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_height'); ?>
                    <?php echo $form->textField($label, 'label_height', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_height'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_weight'); ?>
                    <?php echo $form->textField($label, 'label_weight', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_weight'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_marital_status'); ?>
                    <?php echo $form->textField($label, 'label_marital_status', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_marital_status'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_address'); ?>
                    <?php echo $form->textField($label, 'label_address', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_address'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_addressParent'); ?>
                    <?php echo $form->textField($label, 'label_addressParent', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_addressParent'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_id_Line'); ?>
                    <?php echo $form->textField($label, 'label_id_Line', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_id_Line'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_history_of_severe_illness'); ?>
                    <?php echo $form->textField($label, 'label_history_of_severe_illness', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_history_of_severe_illness'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_educational'); ?>
                    <?php echo $form->textField($label, 'label_educational', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_educational'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_education_level'); ?>
                    <?php echo $form->textField($label, 'label_education_level', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_education_level'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_academy'); ?>
                    <?php echo $form->textField($label, 'label_academy', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_academy'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_graduation_year'); ?>
                    <?php echo $form->textField($label, 'label_graduation_year', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_graduation_year'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_branch'); ?>
                    <?php echo $form->textField($label, 'label_branch', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_branch'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_placeholder_branch'); ?>
                    <?php echo $form->textField($label, 'label_placeholder_branch', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_placeholder_branch'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_boat_person_report'); ?>
                    <?php echo $form->textField($label, 'label_boat_person_report', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_boat_person_report'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_boat_name'); ?>
                    <?php echo $form->textField($label, 'label_boat_name', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_boat_name'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_placeholder_boat_name'); ?>
                    <?php echo $form->textField($label, 'label_placeholder_boat_name', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_placeholder_boat_name'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_adress2'); ?>
                    <?php echo $form->textField($label, 'label_adress2', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_adress2'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_placeholder_address2'); ?>
                    <?php echo $form->textField($label, 'label_placeholder_address2', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_placeholder_address2'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_ship_up_date'); ?>
                    <?php echo $form->textField($label, 'label_ship_up_date', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_ship_up_date'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_ship_down_date'); ?>
                    <?php echo $form->textField($label, 'label_ship_down_date', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_ship_down_date'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_phone1'); ?>
                    <?php echo $form->textField($label, 'label_phone1', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_phone1'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_phone2'); ?>
                    <?php echo $form->textField($label, 'label_phone2', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_phone2'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_phone3'); ?>
                    <?php echo $form->textField($label, 'label_phone3', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_phone3'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_seamanbook'); ?>
                    <?php echo $form->textField($label, 'label_seamanbook', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_seamanbook'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_spouse_firstname'); ?>
                    <?php echo $form->textField($label, 'label_spouse_firstname', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_spouse_firstname'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_spouse_lastname'); ?>
                    <?php echo $form->textField($label, 'label_spouse_lastname', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_spouse_lastname'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_father_firstname'); ?>
                    <?php echo $form->textField($label, 'label_father_firstname', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_father_firstname'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_father_lastname'); ?>
                    <?php echo $form->textField($label, 'label_father_lastname', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_father_lastname'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_mother_firstname'); ?>
                    <?php echo $form->textField($label, 'label_mother_firstname', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_mother_firstname'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_mother_lastname'); ?>
                    <?php echo $form->textField($label, 'label_mother_lastname', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_mother_lastname'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_military'); ?>
                    <?php echo $form->textField($label, 'label_military', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_military'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_sickness'); ?>
                    <?php echo $form->textField($label, 'label_sickness', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_sickness'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_expected_salary'); ?>
                    <?php echo $form->textField($label, 'label_expected_salary', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_expected_salary'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_start_working'); ?>
                    <?php echo $form->textField($label, 'label_start_working', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_start_working'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_accommodation'); ?>
                    <?php echo $form->textField($label, 'label_accommodation', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_accommodation'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_domicile_address'); ?>
                    <?php echo $form->textField($label, 'label_domicile_address', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_domicile_address'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_occupation'); ?>
                    <?php echo $form->textField($label, 'label_occupation', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_occupation'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_ss_card'); ?>
                    <?php echo $form->textField($label, 'label_ss_card', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_ss_card'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_number_of_children'); ?>
                    <?php echo $form->textField($label, 'label_number_of_children', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_number_of_children'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_place_of_birth'); ?>
                    <?php echo $form->textField($label, 'label_place_of_birth', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_place_of_birth'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_place_issued'); ?>
                    <?php echo $form->textField($label, 'label_place_issued', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_place_issued'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_date_issued'); ?>
                    <?php echo $form->textField($label, 'label_date_issued', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_date_issued'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_tel'); ?>
                    <?php echo $form->textField($label, 'label_tel', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_tel'); ?>
                </div>
                   <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_name_emergency'); ?>
                    <?php echo $form->textField($label, 'label_name_emergency', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_name_emergency'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_relationship_emergency'); ?>
                    <?php echo $form->textField($label, 'label_relationship_emergency', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_relationship_emergency'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_FileAttachIdentification'); ?>
                    <?php echo $form->textField($label, 'label_FileAttachIdentification', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_FileAttachIdentification'); ?>
                </div>
                   <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_FileAttachPassport'); ?>
                    <?php echo $form->textField($label, 'label_FileAttachPassport', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_FileAttachPassport'); ?>
                </div>
                 <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_FileAttachCrewIdentification'); ?>
                    <?php echo $form->textField($label, 'label_FileAttachCrewIdentification', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_FileAttachCrewIdentification'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_AttachCopiesOfHousePaticular'); ?>
                    <?php echo $form->textField($label, 'label_AttachCopiesOfHousePaticular', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_AttachCopiesOfHousePaticular'); ?>
                </div>
            </div>

                <h4 class="labelCourse"><i class="fa fa-window-maximize" aria-hidden="true"></i>&nbsp; แจ้งเตือน (Alert ต่างๆ)<h4>
                <div class="row">
                    <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_alert_identification'); ?>
                    <?php echo $form->textField($label, 'label_alert_identification', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_alert_identification'); ?>
                </div>
                 <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_alert_notNumber'); ?>
                    <?php echo $form->textField($label, 'label_alert_notNumber', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_alert_notNumber'); ?>
                </div>
                </div>

                <h4 class="labelCourse"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i>&nbsp; ตัวเลือก (Dropdown)<h4>
           
                    <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_dropdown_mr'); ?>
                    <?php echo $form->textField($label, 'label_dropdown_mr', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_dropdown_mr'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_dropdown_ms'); ?>
                    <?php echo $form->textField($label, 'label_dropdown_ms', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_dropdown_ms'); ?>
                </div>
                <div class="col-md-4">
                    <?php echo $form->labelEx($label, 'label_dropdown_mrs'); ?>
                    <?php echo $form->textField($label, 'label_dropdown_mrs', array('size' => 60, 'maxlength' => 250, 'class' => 'width300')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_dropdown_mrs'); ?>
                </div>
           
                <div class="row">
                    <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_male'); ?>
                    <?php echo $form->textField($label, 'label_male', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_male'); ?>
                </div>
                 <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_female'); ?>
                    <?php echo $form->textField($label, 'label_female', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_female'); ?>
                </div>
                </div>

                   <h4 class="labelCourse"><i class="fa fa-address-card-o" aria-hidden="true"></i>&nbsp;  ตัวเลือก (radio)<h4>
              <div class="row">
                    <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_general_public'); ?>
                    <?php echo $form->textField($label, 'label_general_public', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_general_public'); ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_ship_public'); ?>
                    <?php echo $form->textField($label, 'label_ship_public', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_ship_public'); ?>
                </div>
                 <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_personnel'); ?>
                    <?php echo $form->textField($label, 'label_personnel', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_personnel'); ?>
                </div>
                 </div>
                 <div class="row">
                    <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_never'); ?>
                    <?php echo $form->textField($label, 'label_never', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_never'); ?>
                </div>
                 <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_ever'); ?>
                    <?php echo $form->textField($label, 'label_ever', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_ever'); ?>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_single'); ?>
                    <?php echo $form->textField($label, 'label_single', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_single'); ?>
                </div>
                 <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_marry'); ?>
                    <?php echo $form->textField($label, 'label_marry', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_marry'); ?>
                </div>
                </div>
                  <div class="row">
                    <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_office'); ?>
                    <?php echo $form->textField($label, 'label_office', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_office'); ?>
                </div>
                 <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_ship'); ?>
                    <?php echo $form->textField($label, 'label_ship', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_ship'); ?>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_OwnHouse'); ?>
                    <?php echo $form->textField($label, 'label_OwnHouse', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_OwnHouse'); ?>
                </div>
                 <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_RentHouse'); ?>
                    <?php echo $form->textField($label, 'label_RentHouse', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_RentHouse'); ?>
                </div> 
                <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_WithParents'); ?>
                    <?php echo $form->textField($label, 'label_WithParents', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_WithParents'); ?>
                </div>
                 <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_Apartment'); ?>
                    <?php echo $form->textField($label, 'label_Apartment', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_Apartment'); ?>
                </div> 
                <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_WithRelative'); ?>
                    <?php echo $form->textField($label, 'label_WithRelative', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_WithRelative'); ?>
                </div> 
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_Enlisted'); ?>
                    <?php echo $form->textField($label, 'label_Enlisted', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_Enlisted'); ?>
                </div>
                 <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_NotEnlisted'); ?>
                    <?php echo $form->textField($label, 'label_NotEnlisted', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_NotEnlisted'); ?>
                </div> 
                <div class="col-md-6">
                    <?php echo $form->labelEx($label, 'label_Exempt'); ?>
                    <?php echo $form->textField($label, 'label_Exempt', array('size' => 60, 'maxlength' => 250, 'class' => 'width500')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($label, 'label_Exempt'); ?>
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
