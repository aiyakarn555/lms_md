<?php
/* @var $this MGroupquestionnaireController */
/* @var $model MGroupquestionnaire */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Gna_nID'); ?>
		<?php echo $form->textField($model,'Gna_nID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Gna_cNameTH'); ?>
		<?php echo $form->textArea($model,'Gna_cNameTH',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Gna_cNameEN'); ?>
		<?php echo $form->textArea($model,'Gna_cNameEN',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Gna_dStart'); ?>
		<?php echo $form->textField($model,'Gna_dStart'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Gna_dEnd'); ?>
		<?php echo $form->textField($model,'Gna_dEnd'); ?>
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

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->