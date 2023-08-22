<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/gsdk-base.css" rel="stylesheet" />

<div class="container">
    <div class="page-section">
        <div class="row">
            <div class="col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2">

<div class="wizard-container panel-body">
<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");
$this->breadcrumbs=array(
	UserModule::t("Registration"),
);
?>

<?php if(Yii::app()->user->hasFlash('registration')): ?>
<div class="success">
	<div class="card wizard-card ct-wizard-orange" id="wizard">
		<div class="row">
			<div class="col-xs-12">
<?php echo Yii::app()->user->getFlash('registration'); ?>
			</div>
		</div>
	</div>
</div>
<?php else: ?>

<div class="form">
<?php $form=$this->beginWidget('UActiveForm', array(
	'id'=>'registration-form',
	'enableAjaxValidation'=>true,
	'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>
	
	<?php echo $form->errorSummary(array($model,$profile)); ?>
	

	<div class="card wizard-card ct-wizard-orange" id="wizard">
                            <!--        You can switch "ct-wizard-orange"  with one of the next bright colors: "ct-wizard-blue", "ct-wizard-green", "ct-wizard-orange", "ct-wizard-red"             -->
                            <div class="wizard-header">
                                <h3>
                                    <b><?php echo UserModule::t("Registration"); ?></b><br>
                                    	<small class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></small>
                                </h3>
                            </div>


                            <div class="row">
                                <div class="col-sm-12" align="center">
                                    <div class="picture-container">
                                        <div class="picture">
                                            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/default-avatar.png" class="picture-src" id="wizardPicturePreview" title=""/>
                                            <?php echo $form->fileField($model,'pic_user',array('id'=>'wizard-picture')); ?>
                                        </div>
                                        <h6><?php echo UserModule::t("Choose Picture");?></h6>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-6"></div> -->
                                <div class="col-sm-10 col-sm-offset-1">
                                	<div class="form-group">
                                	<label>หน่วยงาน</label>
										<?php
										$orgchart = OrgChart::model()->findAll(array(
											'condition' =>'level=2', 
											));
										$orgchart = CHtml::listData($orgchart,'id','title');
									    echo CHtml::dropDownList('department', '', $orgchart,array(
						                    'empty'=>'---หน่ยงาน---',
						                    'class'=>'form-control',
						                    'ajax' =>
						                        array('type'=>'POST',
						                            'url'=>CController::createUrl('/user/admin/sub_category'), //url to call.
						                            'update'=>'#department_id', // here for a specific item, there should be different update
						                            'data'=>array('department'=>'js:this.value'),
						                        ))); ?>
                                    </div>
									<div class="form-group">
										<?php echo $form->dropDownList($model'department_id','',array('id'=>'department_id','empty'=>'---Sub Categories---','class'=>'form-control')); ?>
										<?php echo $form->error($model,'department_id'); ?>
									</div>
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($model,'username'); ?></label>
                                        <?php echo $form->textField($model,'username',array('class'=>'form-control','placeholder'=>'ชื่อผู้ใช้')); ?>
                                        <?php echo $form->error($model,'username'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($model,'password'); ?></label>
                                        <?php echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>'รหัสผ่าน (ข้อมูลควรเป็น (A-z0-9) และต้องมากกว่า 6 ตัวอักษร)')); ?>
                                        <?php echo $form->error($model,'password'); ?>
                                        <!-- <p class="hint">
										<?php //echo UserModule::t("Minimal password length 4 symbols."); ?>
										</p> -->
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($model,'verifyPassword'); ?></label>
                                        <?php echo $form->passwordField($model,'verifyPassword',array('class'=>'form-control','placeholder'=>'ยืนยันรหัสผ่าน')); ?>
                                        <?php echo $form->error($model,'verifyPassword'); ?>
                                    </div>
                                
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($model,'email'); ?></label>
                                        <?php echo $form->textField($model,'email',array('class'=>'form-control','placeholder'=>'E-Mail')); ?>
                                        <?php echo $form->error($model,'email'); ?>
                                    </div>

                                    <div class="form-group">
                                    <div class="row">
										<?php 
											$profileFields=$profile->getFields();
											if ($profileFields) {
											foreach($profileFields as $field) {
										?>
										<div class="col-sm-6">
										<?php echo $form->labelEx($profile,$field->varname); ?>
										<?php 
											if ($widgetEdit = $field->widgetEdit($profile)) {
											echo $widgetEdit;
											} elseif ($field->range) {
											echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
											} elseif ($field->field_type=="TEXT") {
											echo$form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50,'class'=>'form-control'));
											} else {
											echo $form->textField($profile,$field->varname,array('size'=>60,'class'=>'form-control','maxlength'=>(($field->field_size)?$field->field_size:255)));
											}
										?>
										<?php echo $form->error($profile,$field->varname); ?>
										</div>	
										<?php
										}
										}
										?>
										</div>
										</div>

									<?php if (UserModule::doCaptcha('registration')): ?>
									<div class="form-group">
									<?php echo $form->labelEx($model,'verifyCode'); ?>

									<?php $this->widget('CCaptcha'); ?>
									<?php echo $form->textField($model,'verifyCode',array('class'=>'form-control')); ?>
									<?php echo $form->error($model,'verifyCode'); ?>

									<p class="hint" style="margin-top:5px;"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
									<br/><?php echo UserModule::t("Letters are not case-sensitive."); ?></p>
									 </div>
									<?php endif; ?>

									<div class="form-group" style="text-align: right;">
                                    <?php echo CHtml::submitButton(UserModule::t("Register"),array('class'=>'btn btn-primary',)); ?>
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
</div>