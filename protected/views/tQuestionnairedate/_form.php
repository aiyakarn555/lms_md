<?php
/* @var $this TQuestionnairedateController */
/* @var $model TQuestionnairedate */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tquestionnairedate-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Yna_dDate'); ?>
		<?php echo $form->textField($model,'Yna_dDate'); ?>
		<?php echo $form->error($model,'Yna_dDate'); ?>
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

	<div class="row">
		<?php echo $form->labelEx($model,'Gna_nID'); ?>
		<?php echo $form->textField($model,'Gna_nID'); ?>
		<?php echo $form->error($model,'Gna_nID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Mem_nID'); ?>
		<?php echo $form->textField($model,'Mem_nID'); ?>
		<?php echo $form->error($model,'Mem_nID'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->