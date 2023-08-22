<?php
/* @var $this GenerationController */
/* @var $data Generation */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_gen')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_gen), array('view', 'id'=>$data->id_gen)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date')); ?>:</b>
	<?php echo CHtml::encode($data->start_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date')); ?>:</b>
	<?php echo CHtml::encode($data->end_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />


</div>