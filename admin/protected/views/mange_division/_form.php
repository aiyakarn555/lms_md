<?php
/* @var $this Mange_divisionController */
/* @var $model TblDivision */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tbl-division-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<?php
 $model_company = CHtml::listData(TblCompany::model()->findAll(),'company_id','company_title');
?>

	<div class="row">
		<?php echo $form->labelEx($model,'company_id'); ?>
		<?php echo $form->dropDownList($model,'company_id',$model_company); ?>
		<?php echo $form->error($model,'company_id'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'div_title'); ?>
		<?php echo $form->textField($model,'div_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'div_title'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->