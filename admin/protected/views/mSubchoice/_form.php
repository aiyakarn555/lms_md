<?php
/* @var $this MSubchoiceController */
/* @var $model MSubchoice */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'msubchoice-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Sch_cNameTH'); ?>
		<?php echo $form->textArea($model,'Sch_cNameTH',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Sch_cNameTH'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Sch_cNameEN'); ?>
		<?php echo $form->textArea($model,'Sch_cNameEN',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Sch_cNameEN'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Cho_nScore'); ?>
		<?php echo $form->textField($model,'Cho_nScore'); ?>
		<?php echo $form->error($model,'Cho_nScore'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stat_txt'); ?>
		<?php echo $form->textField($model,'stat_txt'); ?>
		<?php echo $form->error($model,'stat_txt'); ?>
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
		<?php echo $form->labelEx($model,'Cho_nID'); ?>
		<?php echo $form->textField($model,'Cho_nID'); ?>
		<?php echo $form->error($model,'Cho_nID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Tan_nID'); ?>
		<?php echo $form->textField($model,'Tan_nID'); ?>
		<?php echo $form->error($model,'Tan_nID'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->