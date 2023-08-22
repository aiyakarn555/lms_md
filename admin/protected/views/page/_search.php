<?php
/* @var $this PageController */
/* @var $model Page */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'page_num'); ?>
		<?php echo $form->textField($model,'page_num',array('class'=>'span6')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons search'),'<i></i> ค้นหา'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->