<?php
/* @var $this FaqController */
/* @var $model Faq */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'faq-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'faq_ENtopic'); ?>
		<?php echo $form->textField($model,'faq_ENtopic',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'faq_ENtopic'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'faq_THtopic'); ?>
		<?php echo $form->textField($model,'faq_THtopic',array('size'=>60,'maxlength'=>250)); ?>
		<?php echo $form->error($model,'faq_THtopic'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'faq_ENanswer'); ?>
		<?php echo $form->textArea($model,'faq_ENanswer',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'faq_ENanswer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'faq_THanswer'); ?>
		<?php echo $form->textArea($model,'faq_THanswer',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'faq_THanswer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'faq_type_id'); ?>
		<?php echo $form->textField($model,'faq_type_id'); ?>
		<?php echo $form->error($model,'faq_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'faq_hideStatus'); ?>
		<?php echo $form->textField($model,'faq_hideStatus'); ?>
		<?php echo $form->error($model,'faq_hideStatus'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_date'); ?>
		<?php echo $form->textField($model,'create_date'); ?>
		<?php echo $form->error($model,'create_date'); ?>
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

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->