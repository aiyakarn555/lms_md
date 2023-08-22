<?php
/* @var $this SignatureController */
/* @var $model Signature */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'sign_id'); ?>
		<?php echo $form->textField($model,'sign_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sign_title'); ?>
		<?php echo $form->textField($model,'sign_title',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sign_hide'); ?>
		<?php echo $form->textField($model,'sign_hide'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sign_path'); ?>
		<?php echo $form->textField($model,'sign_path',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_date'); ?>
		<?php echo $form->textField($model,'create_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'create_by'); ?>
		<?php echo $form->textField($model,'create_by',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'active'); ?>
		<?php echo $form->textField($model,'active'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->