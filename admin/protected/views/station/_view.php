<?php
/* @var $this StationController */
/* @var $data Station */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('station_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->station_id), array('view', 'id'=>$data->station_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('station_title')); ?>:</b>
	<?php echo CHtml::encode($data->station_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />


</div>