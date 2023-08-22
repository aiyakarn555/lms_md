<?php
/* @var $this ReportProblemController */
/* @var $model ReportProblem */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'report-problem-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'firstname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'lastname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tel'); ?>
		<?php echo $form->textField($model,'tel',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'tel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'report_type'); ?>
		<?php echo $form->textField($model,'report_type',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'report_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'report_title'); ?>
		<?php echo $form->textField($model,'report_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'report_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'report_detail'); ?>
		<?php echo $form->textArea($model,'report_detail',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'report_detail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'report_pic'); ?>
		<?php echo $form->textField($model,'report_pic',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'report_pic'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->