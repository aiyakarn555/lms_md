<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/gsdk-base.css" rel="stylesheet"/>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/bootstrap.min.css" rel="stylesheet"/>
<?php 
    // var_dump($model->auditor_id); 
    // var_dump($profile->type_user); exit();
    
?>


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
                    <?php $this->pageTitle = Yii::app()->name;
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
                        <?php echo $form->errorSummary(array($model)); ?>
                        <div class="card wizard-card ct-wizard-orange" id="wizard">

                            <!--        You can switch "ct-wizard-orange"  with one of the next bright colors: "ct-wizard-blue", "ct-wizard-green", "ct-wizard-orange", "ct-wizard-red"             -->
                            <div class="wizard-header">
                                <h3><strong><?php echo 'ข้อมูลส่วนตัวและภาพบัตรประชาชน'; ?>
                                </h3>
                            </div>
                            <div class="row pd-1em border">
                                

                                <div class="col-md-11">

                                    <div class="form-group">
                                        <label>เลขบัตรประชาชน</label>
                                        <?php echo $form->textField($model, 'username', array('class' => 'form-control','disabled' => 'disabled')); ?>
                                    </div>
                                    <div class="form-group mem" id="bookkeeper">
                                        <label>ประเภทสมาชิก</label>
                                        <input class="form-control" disabled="disabled" name="Profile[type_user]" id="Profile_type_user" type="text" maxlength="255" value="<?php echo $model->profile->type_name->name ?>">
                                    </div>
                                    <div class="form-group mem" id="auditor">
                                        <label>ชื่อจริง</label>
                                        <?php echo $form->textField($profile, 'firstname', array('class' => 'form-control','disabled' => 'disabled')); ?>
                                    </div>
                                    <div class="form-group mem" id="bookkeeper">
                                        <label>นามสกุล</label>
                                        <?php echo $form->textField($profile, 'lastname', array('class' => 'form-control','disabled' => 'disabled')); ?>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mem">
                                            <h4>รูปภาพบัตรประชาชน</h4>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" >
                                                    <?php
                                                        // if($model->pic_user!=""){
                                                        $registor = new RegistrationForm;
                                                        $registor->id = $model->id;
                                                        // }
                                                        ?>
                                                        <?php echo Controller::ImageShowUser(Yush::SIZE_THUMB, $model, $model->pic_cardid, $registor, array('class' => 'picture-src', 'id' => 'wizardPicturePreview')); ?>
                                                </div>
                                                <div>
                                                <span class="btn btn-success btn-small btn-file">
                                                    <span class="fileinput-new">แนลไฟล์รูปภาพบัตรประชาชน</span>
                                                    <?php echo $form->fileField($model, 'pic_user', array('id' => 'wizard-picture')); ?>
                                                </span>           
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                    <div class="form-group" style="text-align: left;">
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