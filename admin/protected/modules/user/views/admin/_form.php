<!-- <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/gsdk-base.css" rel="stylesheet"/> -->
<!-- <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/bootstrap.min.css" rel="stylesheet"/> -->
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

             // $("#User_division_id").bind("change", function() {
             //     $.ajax({
             //         type: "GET", 
             //         url: "getAjaxDepartment",
             //         data: "division_id="+$("#User_division_id").val(),
             //         success: function(html) {
             //             $("#User_department_id").html(html);
             //             $("#User_position_id").html("<option value=''> เลือกตำแหน่ง</option>");
             //            dropDown_position.selectedIndex = 0;
             //         }
             //     });
             // });

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
.errorMessage{
    color:red;
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
                    // $this->breadcrumbs = array(
                    // UserModule::t("Registration"),
                    // );
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
                        <?php //echo $form->errorSummary(array($model, $profile)); ?>

                        <!-- <div class="card wizard-card ct-wizard-orange" id="wizard"> -->

                            <!--        You can switch "ct-wizard-orange"  with one of the next bright colors: "ct-wizard-blue", "ct-wizard-green", "ct-wizard-orange", "ct-wizard-red"             -->
                            <div class="wizard-header">
                                <h3><strong><?php echo UserModule::t("Registration"); ?>
                                <!-- <small class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></small> --></strong>
                                </h3>
                                <p class="text-center"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
                            </div>
                             <!-- <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label for="">เลือกหลักสูตร</label>
                                            <br>
                                            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/multiple-select.css" media="screen">
                                                <select multiple="multiple" name="Orgchart[]" multiple style="width: 300px; height: 100px;" id="select">
                                                    <?php
                                                    $my_org = '';
                                                    if(!Yii::app()->user->isGuest){
                                                        $my_org = json_decode($model->orgchart_lv2);
                                                    }
                                                    ?>
                                                    <?php
                                                    $Orgchart = OrgChart::model()->findAll(array(
                                                                        'condition' => 'active = "y"',
                                                                        'order' => 'id ASC'
                                                                        )
                                                                    );
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
                                                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/multiple-select.js"></script>
                                                <script>
                                                    $("#select").multipleSelect({
                                                        placeholder: "กรุณาเลือกหลักสูตร",
                                                        position: 'down'
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div> -->
                            <div class="row pd-1em border">
                                    
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($model, 'username'); ?></label>
                                        <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => 'ชื่อผู้ใช้ (Email)')); ?>
                                        <?php echo $form->error($model, 'username'); ?>
                                    </div>
                                  
                                      <div class="form-group">
                                        <label><?php echo $form->labelEx($profile, 'identification'); ?></label>
                                        <?php echo $form->textField($profile, 'identification', array('maxlength'=>13,'class' => 'form-control','placeholder' => 'รหัสบัตรประชาชน','oninput' => 'fillfield(this.value)')); ?>
                                        <?php echo $form->error($profile, 'identification'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($profile, 'passport'); ?></label>
                                        <?php echo $form->textField($profile, 'passport', array('maxlength'=>13,'class' => 'form-control','placeholder' => 'หนังสือเดินทาง')); ?>
                                        <?php echo $form->error($profile, 'passport'); ?>
                                    </div>
                                    
                                    
                                    <div class="row">
                                    <?php if($model->isNewRecord) { ?>
                                        <!-- <div class="col-md-6">
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
                                        </div> -->
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
                                   <!--  <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'firstname_en'); ?></label>
                                                <?php echo $form->textField($profile, 'firstname_en', array('class' => 'form-control', 'placeholder' => 'ชื่อจริง(EN)')); ?>
                                                <?php echo $form->error($profile, 'firstname_en'); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'lastname_en'); ?></label>
                                                <?php echo $form->textField($profile, 'lastname_en', array('class' => 'form-control', 'placeholder' => 'นามสกุล(EN)')); ?>
                                                <?php echo $form->error($profile, 'lastname_en'); ?>
                                            </div>
                                        </div>
                                    </div> -->
                                            
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($profile, 'tel'); ?></label>
                                                <?php echo $form->textField($profile, 'tel', array('class' => 'form-control', 'placeholder' => 'เบอร์โทรศัพท์')); ?>
                                                <?php echo $form->error($profile, 'tel'); ?>
                                            </div>
                                        </div>  

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'email'); ?></label>
                                                <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => 'อีเมล')); ?>
                                                <?php echo $form->error($model, 'email'); ?>
                                            </div>
                                        </div>  
                                    </div>
                                    
                                    <!-- <div class="row">
                                        <?php
                                        $companydata = Company::model()->getCompanyList();
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group bussiness">
                                                <label><?php echo $form->labelEx($model, 'company_id'); ?></label>
                                                <?php
                                                echo $form->dropDownList($model, 'company_id', $companydata, array('empty' => 'เลือกฝ่าย', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                                <?php echo $form->error($model, 'company_id'); ?>
                                            </div>
                                        </div>
                                        <?php
                                            $divisiondata = (!$model->company_id) ? array():Division::model()->getDivisionList($model->company_id);
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'division_id'); ?></label>
                                                
                                                <?php
                                                echo $form->dropDownList($model, 'division_id', $divisiondata, array('empty' => 'เลือกกอง', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                                <?php echo $form->error($model, 'division_id'); ?>
                                            </div>
                                        </div>

                                        <?php
                                            $departmentdata = (!$model->division_id)?array():Department::model()->getDepartmentList($model->division_id);
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'department_id'); ?></label>
                                                <?php
                                                echo $form->dropDownList($model, 'department_id', $departmentdata, array('empty' => 'เลือกแผนก', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                                <?php echo $form->error($model, 'department_id'); ?>
                                            </div>
                                        </div>

                                        <?php
                                        // $positiondata = ($model->isNewRecord)?array():position::model()->getPositionList();
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'position_id'); ?></label>
                                                <?php
                                                echo $form->textField($model, 'position_name', array('class' => 'form-control', 'style' => 'width:100%')); 
                                                // echo $form->dropDownList($model, 'position_id', $positiondata, array('empty' => 'เลือกตำแหน่ง', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                                <?php echo $form->error($model, 'position_name'); ?>
                                            </div>
                                        </div>
                                       
                                    </div> -->

                                    <div class="row">
                                        <!-- <?php
                                        $companydata = Company::model()->getCompanyList();
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group bussiness">
                                                <label><?php echo $form->labelEx($model, 'company_id'); ?></label>
                                                <?php
                                                echo $form->dropDownList($model, 'company_id', $companydata, array('empty' => 'เลือกฝ่าย', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                                <?php echo $form->error($model, 'company_id'); ?>
                                            </div>
                                        </div> -->
                                        
                                         <?php

                                            $department = Department::model()->getDepartmentListNew();
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'department_id'); ?></label>
                                                <?php
                                                echo $form->dropDownList($model, 'department_id', $department, array('empty' => 'เลือกแผนก', 'class' => 'form-control department', 'style' => 'width:100%')); 
                                                ?>
                                                <?php echo $form->error($model, 'department_id'); ?>
                                            </div>
                                        </div>
                                        <?php   
                                         $Positiondata = Position::model()->getPositionListNew();
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'position_id'); ?></label>
                                                
                                                <?php
                                                echo $form->dropDownList($model, 'position_id', $Positiondata, array('empty' => 'เลือกตำแหน่ง', 'class' => 'form-control position', 'style' => 'width:100%')); ?>
                                                <?php echo $form->error($model, 'position_id'); ?>
                                            </div>
                                        </div>

                                       

                                        <?php
                                            $Branch = Branch::model()->getBranchList();
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php //echo $form->labelEx($model, 'branch_id'); ?></label>
                                                <label class="label_branch">ระดับ</label>
                                                <?php
                                                echo $form->dropDownList($model, 'branch_id', $Branch, array('empty' => 'เลือกระดับ', 'class' => 'form-control branch', 'style' => 'width:100%')); ?>
                                                <?php echo $form->error($model, 'branch_id'); ?>
                                            </div>
                                        </div>
                                        <?php if(!$model->isNewRecord): ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'status'); ?></label>
                                                <?php   
                                                $statusdata = array('1'=>'เปิดใช้งาน','0'=>'ระงับการใช้งาน');

                                                ?>
                                                <?php
                                                $htmlOptions = array('class' => 'form-control');
                                                echo $form->dropDownList($model, 'status', $statusdata, $htmlOptions);
                                                ?>
                                                <?php echo $form->error($model, 'status', array('class' => 'error2')); ?>
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label><?php echo $form->labelEx($model, 'superuser'); ?></label>
                                                <?php   
                                                $statusdata = array('1'=>'ผู้ดูแลระบบ','0'=>'ผู้ใช้งาน');

                                                ?>
                                                <?php
                                                $htmlOptions = array('class' => 'form-control');
                                                echo $form->dropDownList($model, 'superuser', $statusdata, $htmlOptions);
                                                ?>
                                                <?php echo $form->error($model, 'superuser', array('class' => 'error2')); ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                   
                                    <div class="form-group" style="text-align: right;">
                                        <?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t("Register") : 'บันทึก', array('class' => 'btn btn-primary',)); ?>
                                    </div>
                                </div>

                            </div>
                            <?php $this->endWidget(); ?>
                                        
                            <!-- </div> --><!-- form -->
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
                            $('.branch').hide();
                            $('.label_branch').hide();
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
                                if (data == 'n') {
                           
                                    $('.branch').hide();
                                    $('.label_branch').hide();
                                }else{
                                  
                                    $('.branch').show();
                                    $('.label_branch').show();
                                    $('.branch').empty();
                                    $('.branch').append(data);
                                }
                            }
                        });
                });
        </script>