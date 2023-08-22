<!-- <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/gsdk-base.css" rel="stylesheet"/> -->
<!-- <link href="<?php //echo Yii::app()->theme->baseUrl; ?>/assets/css/bootstrap.min.css" rel="stylesheet"/> -->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/multiple-select.css" media="screen"/>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/multiple-select.js"></script>

<script>
function fillfield(val){
    $('#User_bookkeeper_id').val(val);
}
$(function(){
    //                      var dropDown_department = document.getElementById("User_department_id");
    //                      var dropDown_position = document.getElementById("User_position_id");
    // $("#User_company_id").bind("change", function() {
    //              $.ajax({
    //                  type: "GET", 
    //                  url: "getAjaxDivision",
    //                  data: "company_id="+$("#User_company_id").val(),
    //                  success: function(html) {
    //                      $("#User_division_id").html(html);
    //                      $("#User_department_id").html("<option value=''> เลือกแผนก</option>");
    //                     dropDown_department.selectedIndex = 0;
    //                      $("#User_position_id").html("<option value=''> เลือกตำแหน่ง</option>");
    //                     dropDown_position.selectedIndex = 0;
    //                  }
    //              });
    //          });

    //          $("#User_division_id").bind("change", function() {
    //              $.ajax({
    //                  type: "GET", 
    //                  url: "getAjaxDepartment",
    //                  data: "division_id="+$("#User_division_id").val(),
    //                  success: function(html) {
    //                      $("#User_department_id").html(html);
    //                      $("#User_position_id").html("<option value=''> เลือกตำแหน่ง</option>");
    //                     dropDown_position.selectedIndex = 0;
    //                  }
    //              });
    //          });

             // $("#User_department_id").bind("change", function() {
             //     $.ajax({
             //         type: "GET", 
             //         url: "getAjaxPosition",
             //         data: "department_id="+$("#User_department_id").val(),
             //         success: function(html) {
             //             $("#User_position_id").html(html);
             //         }
             //     });
             // });
});
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
                    <?php 
                    $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Registration");
                   /* $this->breadcrumbs = array(
                    UserModule::t("Registration"),
                    );*/
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
                        // 'enableAjaxValidation'=>true,
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
                                        <br>
                                        <?php
                                        $UPGroup =  PGroup::model()->findAll();
                                        $UPGrouplist = CHtml::listData($UPGroup,'id','group_name');
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
                                        <?php 
                                        // foreach ($UPGrouplist as $key => $value) {
                                        //         echo CHtml::checkBox('PGoup[]', (in_array($key, $UGroups))?TRUE:FALSE, array('value'=>$key,'class'=>'inline'));
                                        //         echo '<label>'.$value.'</label></br>';
                                        // }
                                        ?>
                                        <?php  $this->widget('booster.widgets.TbSelect2',
                                         array(
                                             'name' => 'PGoup[]',
                                             'data' => $UGroup,
                                             'options' => array(
                                                 'placeholder' => 'Group',
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
                                 <div class="form-group" id="div_institution_id" style="display:none">
                                    <label>สถานบัน <b style="color: red"> *</b> : </label>
                                    <select style="width: 500px;" class="form-select " aria-label="Default select example" id="institution_id" name="institution_id">
                                        <?php
                                        $Institution = Institution::model()->findAll();
                                        if($Institution) {
                                            foreach($Institution as $ins) {
                                                ?>
                                                <option <?= ( $_GET['institution_id'] == $ins->code ? 'selected="selected"' : '' ) ?> value="<?= $ins->code ?>"><?= $ins->institution_name ?></option>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="">ยังไม่มีสถานบัน</option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>                            
                                     <div class="form-group">
                                        <label><?php echo $form->labelEx($model, 'username'); ?></label>
                                        <?php echo $form->textField($model, 'username', array('required' => 'required','class' => 'form-control', 'placeholder' => 'ชื่อผู้ใช้ (Email)')); ?>
                                        <?php echo $form->error($model, 'username'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($model, 'email'); ?></label>
                                        <?php echo $form->textField($model, 'email', array('required' => 'required','class' => 'form-control', 'placeholder' => 'Email')); ?>
                                        <?php echo $form->error($model, 'email'); ?>
                                    </div>
                                    <div class="row">
                                    <?php if($model->isNewRecord) { ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Password </label>
                                                <?php echo $form->passwordField($model, 'password', array('required' => 'required','class' => 'form-control', 'placeholder' => 'รหัสผ่าน (ควรเป็น (A-z0-9) และมากกว่า 4 ตัวอักษร)')); ?>
                                                <?php echo $form->error($model, 'password'); ?>
                                                <p style="color: red;font-size: 10px;"> (ควรเป็น (A-z0-9) และมากกว่า 4 ตัวอักษร)</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ยืนยัน Password</label>
                                                <?php echo $form->passwordField($model, 'verifyPassword', array('required' => 'required','class' => 'form-control', 'placeholder' => 'ยืนยันรหัสผ่าน')); ?>
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'firstname'); ?></label>
                                                <?php echo $form->textField($profile, 'firstname', array('required' => 'required','class' => 'form-control', 'placeholder' => 'ชื่อจริง')); ?>
                                                <?php echo $form->error($profile, 'firstname'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'lastname'); ?></label>
                                                <?php echo $form->textField($profile, 'lastname', array('required' => 'required','class' => 'form-control', 'placeholder' => 'นามสกุล')); ?>
                                                <?php echo $form->error($profile, 'lastname'); ?>
                                            </div>
                                        </div>
                                    </div>             
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
        <script type="text/javascript">
            $('.branch').hide();
            $('.label_branch').hide();
            $(".department").change(function() {
                    var id = $(".department").val();
                    $.ajax({
                        type: 'POST',
                        url: "<?= Yii::app()->createUrl('user/admin/ListPosition'); ?>",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            $('.position').empty();
                            $('.position').append(data);
                        }
                    });
                });
                 $(".position").change(function() {
                    var id = $(".position").val();
                    $.ajax({
                        type: 'POST',
                        url: "<?= Yii::app()->createUrl('user/admin/ListBranch'); ?>",
                        data: {
                            id: id
                        },
                        success: function(data) {
                                console.log(data);
                                if (data == '<option value ="">เลือกระดับ</option>') {
                                    console.log(555);
                                    $('.branch').hide();
                                    $('.label_branch').hide();
                                }else{
                                    console.log(666);
                                    $('.branch').show();
                                    $('.label_branch').show();
                                    $('.branch').empty();
                                    $('.branch').append(data);
                                }
                            }
                        });
                });


                 $("#PGoup").change(function(){
                    if( (Array.isArray($("#PGoup").val())) && ($("#PGoup").val()).includes("2")){
                        $("#div_institution_id").show();
                    }else{
                        $("#div_institution_id").hide();
                    }
                });
            </script>