<?php
/* @var $this MSubchoiceController */
/* @var $model MSubchoice */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Sch_nID'); ?>
		<?php echo $form->textField($model,'Sch_nID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Sch_cNameTH'); ?>
		<?php echo $form->textArea($model,'Sch_cNameTH',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Sch_cNameEN'); ?>
		<?php echo $form->textArea($model,'Sch_cNameEN',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Cho_nScore'); ?>
		<?php echo $form->textField($model,'Cho_nScore'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'stat_txt'); ?>
		<?php echo $form->textField($model,'stat_txt'); ?>
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
		<?php echo $form->label($model,'Cho_nID'); ?>
		<?php echo $form->textField($model,'Cho_nID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Tan_nID'); ?>
		<?php echo $form->textField($model,'Tan_nID'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->