<?php
/* @var $this DivisionController */
/* @var $data Division */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('division_id')); ?>:</b>
	<?php echo CHtml::encode($data->division_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dep_title')); ?>:</b>
	<?php echo CHtml::encode($data->dep_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_date); ?>
	<br />


</div>