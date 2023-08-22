<?php
/* @var $this LibraryFileController */
/* @var $model LibraryFile */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'library_id'); ?>
		<?php echo $form->textField($model,'library_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sortOrder'); ?>
		<?php echo $form->textField($model,'sortOrder'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'library_type_id'); ?>
		<?php echo $form->textField($model,'library_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'library_name'); ?>
		<?php echo $form->textField($model,'library_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'library_name_en'); ?>
		<?php echo $form->textField($model,'library_name_en',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'library_filename'); ?>
		<?php echo $form->textField($model,'library_filename',array('size'=>60,'maxlength'=>255)); ?>
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