<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cate_type'); ?>
		<?php echo $form->textField($model,'cate_type'); ?>
		<?php echo $form->error($model,'cate_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cate_title'); ?>
		<?php echo $form->textField($model,'cate_title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'cate_title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cate_short_detail'); ?>
		<?php echo $form->textField($model,'cate_short_detail',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'cate_short_detail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cate_detail'); ?>
		<?php echo $form->textArea($model,'cate_detail',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'cate_detail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_date'); ?>
		<?php echo $form->textField($model,'create_date'); ?>
		<?php echo $form->error($model,'create_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cate_image'); ?>
		<?php echo $form->textField($model,'cate_image',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'cate_image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cate_show'); ?>
		<?php echo $form->textField($model,'cate_show'); ?>
		<?php echo $form->error($model,'cate_show'); ?>
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

	<div class="row">
		<?php echo $form->labelEx($model,'special_category'); ?>
		<?php echo $form->textField($model,'special_category',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'special_category'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->