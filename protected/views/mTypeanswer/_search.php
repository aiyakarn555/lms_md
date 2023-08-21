<?php
/* @var $this MTypeanswerController */
/* @var $model MTypeanswer */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Tan_nID'); ?>
		<?php echo $form->textField($model,'Tan_nID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Tan_cNameTH'); ?>
		<?php echo $form->textArea($model,'Tan_cNameTH',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Tan_cNameEN'); ?>
		<?php echo $form->textArea($model,'Tan_cNameEN',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Tan_cDescriptionTH'); ?>
		<?php echo $form->textArea($model,'Tan_cDescriptionTH',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Tan_cDescriptionEN'); ?>
		<?php echo $form->textArea($model,'Tan_cDescriptionEN',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Tan_cRulesTH'); ?>
		<?php echo $form->textArea($model,'Tan_cRulesTH',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Tan_cRulesEN'); ?>
		<?php echo $form->textArea($model,'Tan_cRulesEN',array('rows'=>6, 'cols'=>50)); ?>
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