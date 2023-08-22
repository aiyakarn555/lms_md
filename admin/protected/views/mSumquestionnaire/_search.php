<?php
/* @var $this MSumquestionnaireController */
/* @var $model MSumquestionnaire */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Sna_nID'); ?>
		<?php echo $form->textField($model,'Sna_nID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cCreateBy'); ?>
		<?php echo $form->textField($model,'cCreateBy',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dCreateDate'); ?>
		<?php echo $form->textField($model,'dCreateDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cUpdateBy'); ?>
		<?php echo $form->textField($model,'cUpdateBy',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dUpdateDate'); ?>
		<?php echo $form->textField($model,'dUpdateDate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cActive'); ?>
		<?php echo $form->textField($model,'cActive',array('size'=>1,'maxlength'=>1)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Que_nID'); ?>
		<?php echo $form->textField($model,'Que_nID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Cho_nID'); ?>
		<?php echo $form->textField($model,'Cho_nID'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->