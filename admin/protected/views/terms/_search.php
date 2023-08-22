<?php
/* @var $this termsController */
/* @var $model terms */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'terms_title'); ?>
		<?php echo $form->textField($model,'terms_title',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons search'),'<i></i> ค้นหา'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
