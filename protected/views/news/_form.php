<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'news-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cms_title'); ?>
		<?php echo $form->textField($model,'cms_title',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'cms_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cms_short_title'); ?>
		<?php echo $form->textArea($model,'cms_short_title',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'cms_short_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cms_detail'); ?>
		<?php echo $form->textArea($model,'cms_detail',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'cms_detail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cms_picture'); ?>
		<?php echo $form->textField($model,'cms_picture',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'cms_picture'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_date'); ?>
		<?php echo $form->textField($model,'create_date'); ?>
		<?php echo $form->error($model,'create_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_by'); ?>
		<?php echo $form->textField($model,'create_by'); ?>
		<?php echo $form->error($model,'create_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'update_date'); ?>
		<?php echo $form->textField($model,'update_date'); ?>
		<?php echo $form->error($model,'update_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'update_by'); ?>
		<?php echo $form->textField($model,'update_by'); ?>
		<?php echo $form->error($model,'update_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->textField($model,'active',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->