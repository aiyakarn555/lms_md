<?php
/* @var $this ChatroomController */
/* @var $model Chatroom */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'room_id'); ?>
		<?php echo $form->textField($model,'room_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_code'); ?>
		<?php echo $form->textField($model,'room_code',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'room_user'); ?>
		<?php echo $form->textField($model,'room_user',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->