<?php
/* @var $this ConfigCaptchaController */
/* @var $model ConfigCaptcha */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'capid'); ?>
		<?php echo $form->textField($model,'capid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cid'); ?>
		<?php echo $form->textField($model,'cid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'lid'); ?>
		<?php echo $form->textField($model,'lid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'capt_name'); ?>
		<?php echo $form->textField($model,'capt_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'capt_time_random'); ?>
		<?php echo $form->textField($model,'capt_time_random'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'capt_time_back'); ?>
		<?php echo $form->textField($model,'capt_time_back'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'capt_times'); ?>
		<?php echo $form->textField($model,'capt_times'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'capt_hide'); ?>
		<?php echo $form->textField($model,'capt_hide',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'capt_active'); ?>
		<?php echo $form->textField($model,'capt_active',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_by'); ?>
		<?php echo $form->textField($model,'updated_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_date'); ?>
		<?php echo $form->textField($model,'updated_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->