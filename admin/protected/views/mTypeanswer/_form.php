<?php
/* @var $this MTypeanswerController */
/* @var $model MTypeanswer */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mtypeanswer-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Tan_cNameTH'); ?>
		<?php echo $form->textArea($model,'Tan_cNameTH',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Tan_cNameTH'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Tan_cNameEN'); ?>
		<?php echo $form->textArea($model,'Tan_cNameEN',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Tan_cNameEN'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Tan_cDescriptionTH'); ?>
		<?php echo $form->textArea($model,'Tan_cDescriptionTH',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Tan_cDescriptionTH'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Tan_cDescriptionEN'); ?>
		<?php echo $form->textArea($model,'Tan_cDescriptionEN',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Tan_cDescriptionEN'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Tan_cRulesTH'); ?>
		<?php echo $form->textArea($model,'Tan_cRulesTH',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Tan_cRulesTH'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Tan_cRulesEN'); ?>
		<?php echo $form->textArea($model,'Tan_cRulesEN',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Tan_cRulesEN'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cCreateBy'); ?>
		<?php echo $form->textField($model,'cCreateBy',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'cCreateBy'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dCreateDate'); ?>
		<?php echo $form->textField($model,'dCreateDate'); ?>
		<?php echo $form->error($model,'dCreateDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cUpdateBy'); ?>
		<?php echo $form->textField($model,'cUpdateBy',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'cUpdateBy'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dUpdateDate'); ?>
		<?php echo $form->textField($model,'dUpdateDate'); ?>
		<?php echo $form->error($model,'dUpdateDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cActive'); ?>
		<?php echo $form->textField($model,'cActive',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'cActive'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->