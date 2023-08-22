<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/gsdk-base.css" rel="stylesheet"/>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/bootstrap.min.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/multiple-select.css" media="screen">
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/multiple-select.js"></script>

<?php 

    // var_dump($model->auditor_id); 
    // var_dump($profile->type_user); exit();
    
?>
<?php if($profile->website) { ?>
    <script>
        $(function(){  
            $('input:radio[id="webcheck1"]').prop('checked', true); 
            });                              
    </script>
<?php  } else { ?>
    <script>
        $(function(){    
            $('input:radio[id="webcheck0"]').prop('checked', true); 
            });                              
    </script>
<?php } ?>
<script>
function fillfield(val){
    $('#User_bookkeeper_id').val(val);
}
$(function(){
    $('.mem').hide();
    $('.bussiness').hide();
    <?php if($profile->type_user) {?>
    $('#Profile_type_user').val('<?= $profile->type_user ?>');
    <?php } ?>
    $('#User_bookkeeper_id').val($('#User_username').val());
    <?php
    if($profile->type_user){
        if($profile->type_user == 1) {
        ?>
            $('.mem').hide();
            $('#bookkeeper').show();
        <?php
        } else if($profile->type_user == 2){
        ?>
            $('.mem').hide();
            $('#bookkeeper').show();
        <?php
        } else if($profile->type_user == 3){
        ?>
            $('.mem').hide();
            $('#auditor').show();
        <?php
        } else if($profile->type_user == 4){
        ?>
            $('.mem').hide();
            $('#auditor').show();
            $('#bookkeeper').show();
        <?php
        }
    }
    if($profile->occupation){
        if($profile->type_user == 'ธุรกิจส่วนตัว/เจ้าของกิจการ') {
            ?>
        $('.bussiness').show();
        $('#Profile_bussiness_model_id').attr('required', true);
        $('#Profile_bussiness_type_id').attr('required', true);
        $('#Profile_company').attr('required', true);
        $('#Profile_juristic').attr('required', true);
            <?php
        } else {
            ?>
        $('.bussiness').hide();
        $('#Profile_bussiness_model_id').attr('required', false);
        $('#Profile_bussiness_type_id').attr('required', false);
        $('#Profile_company').attr('required', false);
        $('#Profile_juristic').attr('required', false);
        $('#Profile_bussiness_model_id').val('');
        $('#Profile_bussiness_type_id').val('');
        $('#Profile_company').val('');
        $('#Profile_juristic').val('');
            <?php
        }
    } 
    ?>
});
function typemem(val){
    if(val == 1) {
        $('.mem').hide();
        $('#bookkeeper').show();
        $('#User_card_id').val('');
        $('#User_auditor_id').val('');
        $('#User_bookkeeper_id').val('');
        $('#User_bookkeeper_id').val($('#User_username').val());
        $('#User_card_id').attr('required', false);
        $('#User_auditor_id').attr('required', false);
    } else if(val == 2){
        $('.mem').hide();
        $('#bookkeeper').show();
        $('#pic_cardid').show();
        $('#User_card_id').val('');
        $('#User_auditor_id').val('');
        $('#User_bookkeeper_id').val('');
        $('#User_bookkeeper_id').val($('#User_username').val());
        $('#User_auditor_id').attr('required', false);
        $('#User_card_id').attr('required', true);
    } else if(val == 3){
        $('.mem').hide();
        $('#auditor').show();
        $('#pic_cardid').show();
        $('#User_card_id').val('');
        $('#User_auditor_id').val('');
        $('#User_bookkeeper_id').val('');
        $('#User_card_id').attr('required', true);
        $('#User_auditor_id').attr('required', true);
    } else if(val == 4){
        $('.mem').hide();
        $('#auditor').show();
        $('#bookkeeper').show();
        $('#pic_cardid').show();
        $('#User_card_id').val('');
        $('#User_auditor_id').val('');
        $('#User_bookkeeper_id').val('');
        $('#User_bookkeeper_id').val($('#User_username').val());
        $('#User_card_id').attr('required', true);
        $('#User_auditor_id').attr('required', true);
    } else {
        $('.mem').hide();
        $('#User_card_id').val('');
        $('#User_auditor_id').val('');
    }
}

function typeOccupation(val){
    if(val == '2') {
        $('.bussiness').show();
        $('#model_department_id').attr('required', true);
        // $('#Profile_bussiness_type_id').attr('required', true);
        // $('#Profile_company').attr('required', true);
        // $('#Profile_juristic').attr('required', true);
    } else {
        $('.bussiness').hide();
        $('#model_department_id').attr('required', false);
        // $('#Profile_bussiness_type_id').attr('required', false);
        // $('#Profile_company').attr('required', false);
        // $('#Profile_juristic').attr('required', false);
        $('#model_department_id').val('');
        // $('#Profile_bussiness_type_id').val('');
        // $('#Profile_company').val('');
        // $('#Profile_juristic').val('');
    }
}

function onAge() {
    var dtToday = new Date();

    var Bday = document.getElementById('Profile_birthday').value;
    var year1 = dtToday.getFullYear();
    var newDate = new Date(Bday);
    var year2 = newDate.getFullYear();
    var theBday = document.getElementById('Profile_age');
    var y = year1 - year2;
    theBday.value = y;
}
</script>

<style type="text/css">
.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year{
    color: black;
}
input.form-control{
    height: 40px;
}
.wizard-header{margin-bottom: 2em;}
.form-control{height: 40px;}
label{font-weight: bold;}
.card{padding: 1em;background-color: rgba(255, 255, 255, 0.5);}
.wizard-card .picture{width: 200px;height: 200px;border-radius: 0;}
.wizard-card.ct-wizard-orange .picture:hover {
    border-color: #26A69A;
}
</style>
<?php 
date_default_timezone_set("Asia/Bangkok");
?>
<div class="container">
    <div class="page-section">
        <div class="row">
            <div class="col-md-12">
                    <?php $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Registration");
                    $this->breadcrumbs = array(
                    UserModule::t("Registration"),
                    );
                    ?>
                    <?php if (Yii::app()->user->hasFlash('registration')): ?>
                    <div class="success">
                        <div class="card wizard-card ct-wizard-orange" id="wizard">
                            <div class="row">
                                <div class="col-xs-12">
                                    <?php echo Yii::app()->user->getFlash('registration'); 
                                    if(Yii::app()->user->hasFlash('error')) {
                                        echo Yii::app()->user->getFlash('error'); 
                                    } else if (Yii::app()->user->hasFlash('contact')){
                                        echo Yii::app()->user->getFlash('contact'); 
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php unset(Yii::app()->session['rule']); else: ?>
                    <div class="form">
                        <?php $form = $this->beginWidget('UActiveForm', array(
                        'id'=>'registration-form',
                        'enableAjaxValidation'=>true,
                        // 'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                        ),
                        'htmlOptions'=>array('enctype'=>'multipart/form-data'),
                        )); ?>
                        <?php echo $form->errorSummary(array($model, $profile)); ?>
                        <div class="card wizard-card ct-wizard-orange" id="wizard">

                            <!--        You can switch "ct-wizard-orange"  with one of the next bright colors: "ct-wizard-blue", "ct-wizard-green", "ct-wizard-orange", "ct-wizard-red"             -->
                            <div class="wizard-header">
                                <h3><strong><?php echo UserModule::t("Registration"); ?>
                                <!-- <small class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></small> --></strong>
                                </h3>
                                <p class="text-center"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
                            </div>
                            <div class="row pd-1em border">
                                <!-- <div class="col-md-3">
                                    <div class="picture-container">
                                        <h4>รูปภาพโปรไฟล์</h4>
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" >
                                                <?php
                                                    // if($model->pic_user!=""){
                                                    $registor = new RegistrationForm;
                                                    $registor->id = $model->id;
                                                    // }
                                                    ?>
                                                    <?php echo Controller::ImageShowUser(Yush::SIZE_THUMB, $model, $model->pic_user, $registor, array('class' => 'picture-src', 'id' => 'wizardPicturePreview')); ?>
                                            </div>
                                            <div>
                                            <span class="btn btn-success btn-small btn-file">
                                                <span class="fileinput-new">เลือกรูปภาพ</span>
                                                <?php echo $form->fileField($model, 'pic_user', array('id' => 'wizard-picture')); ?>
                                            </span>           
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="col-md-7"> 
                                    <div class="form-group">
                                        <label>กลุ่มผู้ใช้</label>

                                         <?php
                                        $UPGroup =  PGroup::model()->findAll(array('condition' => 'id != 1'));

                                        if(!$model->isNewRecord){
                                            $UGroups = json_decode($model->group);
                                            foreach ($UGroups as $key => $uGroup) {
                                                $data_selected[$uGroup]=array('selected' => 'selected');
                                            }                                          
                                        } 
                                    
                                        foreach ($UPGroup as $Group) {
                                                $UGroup[$Group->id] = $Group->group_name;
                                        }


                                        ?>
                                    
                                        <?php $this->widget('booster.widgets.TbSelect2',
                                                    array(
                                                        'name' => 'PGoup[]',
                                                        'data' => $UGroup,
                                                        'options' => array(
                                                            'placeholder' => 'type clever, or is, or just type!',
                                                            'width' => '100%',
                                                        ),
                                                        'htmlOptions' => array(
                                                            'multiple' => 'multiple',
                                                            'options'=> 
                                                                $data_selected
                                                        ),
                                                )
                                            );?>   
                                    </div>                                
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($model, 'username'); ?></label>
                                        <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => 'ชื่อผู้ใช้ (Email)')); ?>
                                        <?php echo $form->error($model, 'username'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($profile, 'identification'); ?></label>
                                        <?php echo $form->textField($profile, 'identification', array('class' => 'form-control','placeholder' => 'รหัสบัตรประชาชน','oninput' => 'fillfield(this.value)')); ?>
                                        <?php echo $form->error($profile, 'identification'); ?>
                                    </div>
                                    <div class="row">
                                    <?php if($model->isNewRecord) { ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'password'); ?></label>
                                                <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => 'รหัสผ่าน (ควรเป็น (A-z0-9) และมากกว่า 4 ตัวอักษร)')); ?>
                                                <?php echo $form->error($model, 'password'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'verifyPassword'); ?></label>
                                                <?php echo $form->passwordField($model, 'verifyPassword', array('class' => 'form-control', 'placeholder' => 'ยืนยันรหัสผ่าน')); ?>
                                                <?php echo $form->error($model, 'verifyPassword'); ?>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'newpassword'); ?></label>
                                                <?php echo $form->passwordField($model, 'newpassword', array('class' => 'form-control', 'placeholder' => 'รหัสผ่าน (ควรเป็น (A-z0-9) และมากกว่า 4 ตัวอักษร)')); ?>
                                                <?php echo $form->error($model, 'newpassword'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'confirmpass'); ?></label>
                                                <?php echo $form->passwordField($model, 'confirmpass', array('class' => 'form-control', 'placeholder' => 'ยืนยันรหัสผ่าน')); ?>
                                                <?php echo $form->error($model, 'confirmpass'); ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($profile, 'title_id'); ?></label>
                                        <?php echo $form->dropDownList($profile, 'title_id', ProfilesTitle::getTitleList(), array('empty' => '---เลือกคำนำหน้าชื่อ---', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                        <?php echo $form->error($profile, 'title_id'); ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'firstname'); ?></label>
                                                <?php echo $form->textField($profile, 'firstname', array('class' => 'form-control', 'placeholder' => 'ชื่อจริง')); ?>
                                                <?php echo $form->error($profile, 'firstname'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'lastname'); ?></label>
                                                <?php echo $form->textField($profile, 'lastname', array('class' => 'form-control', 'placeholder' => 'นามสกุล')); ?>
                                                <?php echo $form->error($profile, 'lastname'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mem" id="pic_cardid">
                                        <label>แนลไฟล์รูปภาพบัตรประชาชน *</label>
                                        <?php echo $form->fileField($model, 'card_id',array('class'=>'form-control')); ?>
                                        <?php echo $form->error($model, 'card_id'); ?>
                                    </div>
                                            <!-- <div class="form-group">
                                                <label for="input"><.?php echo $form->labelEx($profile, 'birthday'); ?></label>
                                                <div>
                                                    <.?php 
                                                    $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                                      'model' => $profile,
                                                      'attribute' => 'birthday',
                                                      'name'=>'Profile[birthday]',
                                                      'options'=>array(
                                                        'showAnim'=>'fold',
                                                        'dateFormat'=>'yy-mm-dd',
                                                        'changeMonth'=>'true', 
                                                        'changeYear'=>'true', 
                                                        'yearRange'=>'1947:2012', 
                                                        'dateFormat'=>'yy-mm-dd',
                                                        'dateFormat'=>'yy-mm-dd',
                                                            'dayNamesMin' => array('อา','จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'),
                                                            'monthNamesShort' => array('มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'),
                                                            'beforeShow' => 'js:function(){  
                                                                if($(this).val() != ""){
                                                                    var arrayDate = $(this).val().split("-");     
                                                                    arrayDate[0] = parseInt(arrayDate[0]) - 543;
                                                                    $(this).val(arrayDate[0] + "-" + arrayDate[1] + "-" + arrayDate[2]);
                                                                }
                                                                setTimeout(function(){
                                                                    $.each($(".ui-datepicker-year option"), function(j, k){
                                                                        var textYear = parseInt($(".ui-datepicker-year option").eq(j).val()) + 543;
                                                                        $(".ui-datepicker-year option").eq(j).text(textYear);
                                                                    });             
                                                                },50);
                                                            }',
                                                            'onClose' => 'js:function(){
                                                                if($(this).val() != "" && $(this).val() == dateBefore){         
                                                                    var arrayDate = dateBefore.split("-");
                                                                    arrayDate[0] = parseInt(arrayDate[0]) + 543;
                                                                    $(this).val(arrayDate[0] + "-" + arrayDate[1] + "-" + arrayDate[2]);    
                                                                }       
                                                            }',
                                                            'onSelect' => 'js:function(dateText, inst){ 
                                                                dateBefore = $(this).val();
                                                                var arrayDate = dateText.split("-");
                                                                arrayDate[0] = parseInt(arrayDate[0]) + 543;
                                                                $(this).val(arrayDate[0] + "-" + arrayDate[1] + "-" + arrayDate[2]);
                                                                    var dtToday = new Date();
                                                                    var Bday = document.getElementById("Profile_birthday").value;
                                                                    var year1 = dtToday.getFullYear();
                                                                    var newDate = new Date(Bday);
                                                                    var year2 = newDate.getFullYear()-543;
                                                                    var theBday = document.getElementById("Profile_age");
                                                                    var y = year1 - year2;
                                                                    theBday.value = y;
                                                            }',   
                                                            'onChangeMonthYear' => 'js:function(){ 
                                                                setTimeout(function(){
                                                                    $.each($(".ui-datepicker-year option"), function(j, k){
                                                                        var textYear = parseInt($(".ui-datepicker-year option").eq(j).val()) + 543;
                                                                        $(".ui-datepicker-year option").eq(j).text(textYear);
                                                                    });             
                                                                },50);
                                                            }', 
                                                      ),
                                                      'htmlOptions'=>array(
                                                        'class'=>'form-control',
                                                        'onchange'=>'onAge()'
                                                      ),
                                                    )); 
                                                    ?>
                                                </div>
                                                <.?php echo $form->error($profile, 'birthday'); ?>
                                            </div> -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'sex'); ?></label>
                                                <?php
                                                if($profile->sex){
                                                    if($profile->sex == 'Male'){
                                                    $profile->sex = 1;
                                                    } else {
                                                        $profile->sex = 2;
                                                    }
                                                }
                                                $sex = array('1' => 'ชาย',
                                                '2' => 'หญิง',);
                                                echo $form->dropDownList($profile, 'sex', $sex, array('empty' => '---เลือกเพศ---', 'class' => 'form-control', 'style' => 'width:100%'));
                                                ?>
                                                <?php echo $form->error($profile, 'sex'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label><?php echo $form->labelEx($model, 'department_id'); ?></label>
                                            <?php
                                            $department_id = array('1' => 'ทั่วไป','2' => 'หน่วยงาน');
                                            echo $form->dropDownList($model, 'department_id', $department_id, array('empty' => '---เลือกประเภทสมาชิก---', 'class' => 'form-control', 'style' => 'width:100%',
                                                'onchange'=>'typeOccupation(this.value)'));
                                            ?>
                                            <?php echo $form->error($model, 'department_id'); ?>
                                            </div>
                                        </div>
                                        <?php
                                        $company = company::model()->findAll();
                                        foreach ($company as $key => $value) {
                                                $company[$key]=$value->company_title;
                                            }
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group bussiness">
                                                <label><?php echo $form->labelEx($model, 'company_id'); ?><span class="required">*</span></label>
                                                <?php
                                                echo $form->dropDownList($model, 'company_id', $company, array('empty' => '---เลือกสำนัก/หน่วยงาน---', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                                <?php echo $form->error($model, 'company_id'); ?>
                                            </div>
                                        </div>
                                        
                                        <!-- <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'age'); ?></label>
                                                <?php echo $form->textField($profile, 'age', array('class' => 'form-control', 'placeholder' => 'อายุ','readonly' => 'readonly')); ?>
                                                <?php echo $form->error($profile, 'age'); ?>
                                            </div>
                                        </div> -->
                                    </div>
                                    <!-- <div class="form-group">
                                        <label><?php echo $form->labelEx($profile, 'education'); ?></label>
                                        <?php
                                        $education = array('ปวช' => 'ปวช',
                                        'ปวส' => 'ปวส',
                                        'ปริญญาตรี' => 'ปริญญาตรี',
                                        'ปริญญาโท' => 'ปริญญาโท',
                                        'ปริญญาเอก' => 'ปริญญาเอก',
                                        'อื่น ๆ' => 'อื่น ๆ',);
                                        echo $form->dropDownList($profile, 'education', $education, array('empty' => '---เลือกวุฒิการศึกษา---', 'class' => 'form-control', 'style' => 'width:100%'));
                                        ?>
                                        <?php echo $form->error($profile, 'education'); ?>
                                    </div> -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'division_id'); ?></label>
                                                <?php
                                                $division = division::model()->findAll();
                                                foreach ($division as $key => $value) {
                                                        $division[$key]=$value->dep_title;
                                                    }
                                                ?>
                                                <?php
                                                echo $form->dropDownList($model, 'division_id', $division, array('empty' => '---เลือกอาชีพ---', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                                <?php echo $form->error($model, 'division_id'); ?>
                                            </div>
                                        </div>
                                        <?php
                                        $position = position::model()->findAll();
                                        foreach ($position as $key => $value) {
                                                $position[$key]=$value->position_title;
                                            }
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'position_id'); ?></label>
                                                <?php
                                                echo $form->dropDownList($model, 'position_id', $position, array('empty' => '---เลือกตำแหน่ง---', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                                <?php echo $form->error($model, 'position_id'); ?>
                                            </div>
                                        </div>
                                        <?php
                                        $my_org = '';
                                        if(!Yii::app()->user->isGuest){
                                            $my_org = json_decode($model->orgchart_lv2);
                                        }
                                        ?>
                                        <?php
                                        $Orgchart = Orgchart::model()->findAll(array(
                                                            'condition' => 'active = "y"',
                                                            'order' => 'id ASC'
                                                            )
                                                        );
                                        ?>
                                    </div>

                                       <?php
                                            $my_group = '';
                                            if(!Yii::app()->user->isGuest){
                                                $my_group = json_decode($model->group);
                                            }
                                        ?>
                                       
                                
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">เลือกหลักสูตร</label>
                                            <br>
                                            <!-- <link rel="stylesheet" type="text/css" href="<.?php echo Yii::app()->theme->baseUrl; ?>/multiple-select.css" media="screen"> -->
                                                <select multiple="multiple" name="Orgchart[]" style="width: 300px; height: 100px;" id="select">
                                                    <?php
                                                    if($Orgchart) {
                                                            foreach($Orgchart as $Course) {
                                                            ?>
                                                            <option <?= in_array($Course->id, $my_org) ? 'selected' : '' ?> value="<?= $Course->id ?>"> <?php echo $Course->title ?>
                                                            </option>
                                                            <?php
                                                            }
                                                    }
                                                    ?>
                                                </select>
                                                <!-- <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/multiple-select.js"></script> -->
                                                <script>
                                                    
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <script>                                         
                                            $("#select").multipleSelect({
                                                placeholder: "กรุณาเลือกหลักสูตร2",
                                                                // position: 'down'
                                            });
                                    </script>
                                    <!-- <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group bussiness">
                                                <label><?php echo $form->labelEx($profile, 'bussiness_model_id'); ?> <span class="required">*</span></label>
                                                <?php
                                                echo $form->dropDownList($profile, 'bussiness_model_id', BusinessModel::getTypeList(), array('empty' => '---รูปแบบธุรกิจ---', 'class' => 'form-control', 'style' => 'width:100%'));?>
                                                <?php echo $form->error($profile, 'bussiness_model_id'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group bussiness">
                                                <label><?php echo $form->labelEx($profile, 'bussiness_type_id'); ?> <span class="required">*</span></label>
                                                <?php
                                                echo $form->dropDownList($profile, 'bussiness_type_id', BusinessType::getTypeList(), array('empty' => '---ประเภทของธุรกิจ---', 'class' => 'form-control', 'style' => 'width:100%')); 
                                                ?>
                                                <?php echo $form->error($profile, 'bussiness_type_id'); ?>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group bussiness">
                                                <label><?php echo $form->labelEx($profile, 'company'); ?> <span class="required">*</span></label>
                                                <?php echo $form->textField($profile, 'company', array('class' => 'form-control', 'placeholder' => 'ชื่อหน่วยงาน/บริษัท ')); ?>
                                                <?php echo $form->error($profile, 'company'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group bussiness">
                                                <label><?php echo $form->labelEx($profile, 'juristic'); ?> <span class="required">*</span></label>
                                                <?php echo $form->textField($profile, 'juristic', array('class' => 'form-control', 'placeholder' => 'เลขทะเบียนนิติบุคคล')); ?>
                                                <?php echo $form->error($profile, 'juristic'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                    $('.webcheck').click(function(){
                                    var isChecked = jQuery("input[name=webcheck]:checked").val();
                                        if(isChecked == 0){
                                            $(".web").blur();
                                            $('#web').val('');
                                            $('#web').attr('required', false);
                                        }else {
                                            $(".web").focus();
                                            $('#web').attr('required', true);
                                        }
                                    });
                                    
                                    $('#web').click(function(){
                                        $('input:radio[id="webcheck1"]').prop('checked', true);
                                        $('#web').attr('required', true);
                                    });
                                    </script> -->
                                    <!-- <div class="form-group">
                                        <label><?php echo $form->labelEx($profile, 'address'); ?></label>
                                        <?php echo $form->textArea($profile, 'address', array('class' => 'form-control')); ?>
                                        <?php echo $form->error($profile, 'address'); ?>
                                    </div> -->
                                    <!-- <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'tel'); ?> (02)</label>
                                                <?php echo $form->textField($profile, 'tel', array('class' => 'form-control', 'placeholder' => 'เบอร์โทรศัพท์')); ?>
                                                <?php echo $form->error($profile, 'tel'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'phone'); ?></label>
                                                <?php echo $form->textField($profile, 'phone', array('class' => 'form-control', 'placeholder' => 'เบอร์โทรศัพท์เคลื่อนที่')); ?>
                                                <?php echo $form->error($profile, 'phone'); ?>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'fax'); ?></label>
                                                <?php echo $form->textField($profile, 'fax', array('class' => 'form-control', 'placeholder' => 'เบอร์โทรสาร')); ?>
                                                <?php echo $form->error($profile, 'fax'); ?>
                                            </div>
                                        </div>
                                    </div> -->
                                   <!--  <div class="form-group">
                                        <label>อัพโหลดเอกสาร PDF</label> -->
     <!--                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                            <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">เลือกไฟล์</span><span class="fileinput-exists">เปลี่ยน</span> -->
                                            <?php //echo $form->fileField($profile, 'file_user',array('class'=>'wizard-picture')); ?>
                                            <!-- </span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                        </div> -->
                                        <!-- 
                                        <?php echo $form->error($profile, 'file_user'); ?> -->
                                    <!-- </div> -->
                                    <!-- <div class="form-group">
                                        <label>หน่วยงาน</label> -->
                                        <?php
                                        // $orgchart = OrgChart::model()->findAll(array(
                                        //     'condition' => 'level=2',
                                        // ));
                                        // $orgchart = CHtml::listData($orgchart, 'id', 'title');
                                        // if ($model->department_id != '') {
                                        //     $orgchart_select = OrgChart::model()->find(array(
                                        //         'condition' => 'id=' . $model->department_id,
                                        //     ));
                                        //     $model->orgchart_lv2 = $orgchart_select->parent_id;
                                        // }
                                        // echo $form->dropDownList($model, 'orgchart_lv2', $orgchart, array(
                                        //     'empty' => '---หน่วยงาน---',
                                        //     'class' => 'form-control',
                                        //     'ajax' =>
                                        //         array('type' => 'POST',
                                        //             'url' => CController::createUrl('/user/registration/sub_category'), //url to call.
                                        //             'update' => '#' . CHtml::activeId($model, 'department_id'), // here for a specific item, there should be different update
                                        //             'data' => array('orgchart_lv2' => 'js:this.value'),
                                        //         ))); ?>
                                        <?php // echo $form->error($model, 'orgchart_lv2'); ?>
                                    <!-- </div>
                                    <div class="form-group">
                                        <label>แผนก</label> -->
                                        <?php
                                        // if ($model->department_id != '') {
                                        //     $data = $this->loadDepartment($model->department_id);
                                        // } else {
                                        //     $data = array();
                                        // }
                                        // echo $form->dropDownList($model, 'department_id', $data, array('empty' => '---แผนก---', 'class' => 'form-control')); ?>
                                        <?php //echo $form->error($model, 'department_id'); ?>
                                    <!-- </div>
                                    <div class="form-group">
                                        <label>หน่วยงาน</label> -->
                                        <?php
                                        //                                             echo $form->dropDownList($model, 'company_id', Company::getCompanyList(), array(
                                        //                                                 'empty' => '---เลือกหน่วยงาน---',
                                        //                                                 'class' => 'form-control',
                                        //                                                 'style' => 'width:100%',
                                        //                                                 'ajax' =>
                                        //                                                     array('type' => 'POST',
                                        //                                                         'dataType' => 'json',
                                        //                                                         'url' => CController::createUrl('/user/registration/division'), //url to call.
                                        // //                                                    'update' => '#' . CHtml::activeId($model, 'division_id'), // here for a specific item, there should be different update
                                        //                                                         'success' => 'function(data){
                                        //                                                         $("#division_id").empty();
                                        //                                                         $("#division_id").append(data.data_dsivision);
                                        //                                                         $("#position_id").empty();
                                        //                                                         $("#position_id").append(data.data_position);
                                        //                                                     }',
                                        //                                                         'data' => array('company_id' => 'js:this.value'),
                                        //                                                     ))); ?>
                                        <?php //echo $form->error($model, 'company_id'); ?>
                                    <!-- </div>
                                    <div class="form-group">
                                        <label>ศูนย์/แผนก</label> -->
                                        <?php
                                        //                                        var_dump($model->division_id);
                                        //echo $form->dropDownList($model, 'division_id', Division::getDivisionList(), array('empty' => '---เลือก ศุนย์/แผนก---', 'class' => 'form-control', 'style' => 'width:100%', 'id' => 'division_id')); ?>
                                        <?php //echo $form->error($model, 'division_id'); ?>
                                    <!-- </div>
                                    <div class="form-group">
                                        <label>ตำแหน่ง</label> -->
                                        <?php
                                        //echo $form->dropDownList($model, 'position_id', Position::getPositionList(), array('empty' => '---เลือกตำแหน่ง---', 'class' => 'form-control', 'style' => 'width:100%','id'=>'position_id')); ?>
                                        <?php //echo $form->error($model, 'position_id'); ?>
                                        <!-- </div> -->
                                        <?php
                                        // $profileFields = $profile->getFields();
                                        // if ($profileFields) {
                                        //     foreach ($profileFields as $field) {
                                        ?>
                                        <!-- <div class="form-group"> -->
                                        <?php // echo $form->labelEx($profile, $field->varname); ?>
                                        <?php
                                        // if ($widgetEdit = $field->widgetEdit($profile)) {
                                        //     echo $widgetEdit;
                                        // } elseif ($field->range) {
                                        //     echo $form->dropDownList($profile, $field->varname, Profile::range($field->range));
                                        // } elseif ($field->field_type == "TEXT") {
                                        //     echo $form->textArea($profile, $field->varname, array('rows' => 6, 'cols' => 50, 'class' => 'form-control'));
                                        // } else {
                                        //     echo $form->textField($profile, $field->varname, array('size' => 60, 'class' => 'form-control', 'maxlength' => (($field->field_size) ? $field->field_size : 255)));
                                        // }
                                        ?>
                                        <?php // echo $form->error($profile, $field->varname); ?>
                                        <!-- </div> -->
                                        <?php
                                        //     }
                                        // }
                                        ?>
                                        <div class="form-group" style="text-align: right;">
                                            <?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t("Register") : 'บันทึก', array('class' => 'btn btn-primary',)); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <?php $this->endWidget(); ?>
                                        
                            </div><!-- form -->
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>