<?php
/* @var $this ChatroomController */
/* @var $model Chatroom */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'chatroom-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'room_code'); ?>
		<?php echo $form->textField($model,'room_code',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'room_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'room_user'); ?>
		<?php echo $form->textField($model,'room_user',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'room_user'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->