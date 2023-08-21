<?php
/* @var $this TAnswerquestionnaireController */
/* @var $model TAnswerquestionnaire */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Ans_nID'); ?>
		<?php echo $form->textField($model,'Ans_nID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Cho_cNameTH'); ?>
		<?php echo $form->textArea($model,'Cho_cNameTH',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Cho_cNameEN'); ?>
		<?php echo $form->textArea($model,'Cho_cNameEN',array('rows'=>6, 'cols'=>50)); ?>
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
		<?php echo $form->label($model,'Ans_Description'); ?>
		<?php echo $form->textArea($model,'Ans_Description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Ans_cOther'); ?>
		<?php echo $form->textArea($model,'Ans_cOther',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Ans_cComment'); ?>
		<?php echo $form->textArea($model,'Ans_cComment',array('rows'=>6, 'cols'=>50)); ?>
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
		<?php echo $form->label($model,'Gra_nID'); ?>
		<?php echo $form->textField($model,'Gra_nID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Qna_nID'); ?>
		<?php echo $form->textField($model,'Qna_nID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Cho_nID'); ?>
		<?php echo $form->textField($model,'Cho_nID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Sch_nID'); ?>
		<?php echo $form->textField($model,'Sch_nID'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->