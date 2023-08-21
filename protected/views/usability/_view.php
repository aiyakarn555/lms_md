<?php
/* @var $this UsabilityController */
/* @var $data Usability */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('usa_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->usa_id), array('view', 'id'=>$data->usa_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usa_title')); ?>:</b>
	<?php echo CHtml::encode($data->usa_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usa_detail')); ?>:</b>
	<?php echo CHtml::encode($data->usa_detail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_by')); ?>:</b>
	<?php echo CHtml::encode($data->create_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_date')); ?>:</b>
	<?php echo CHtml::encode($data->update_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_by')); ?>:</b>
	<?php echo CHtml::encode($data->update_by); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />

	*/ ?>

</div>