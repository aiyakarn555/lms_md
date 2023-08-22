<?php
/* @var $this PopupController */
/* @var $data Popup */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('con_firstname')); ?>:</b>
	<?php echo CHtml::encode($data->con_firstname); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('con_lastname')); ?>:</b>
	<?php echo CHtml::encode($data->con_lastname); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('con_firstname_en')); ?>:</b>
	<?php echo CHtml::encode($data->con_firstname_en); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('con_lastname_en')); ?>:</b>
	<?php echo CHtml::encode($data->con_lastname_en); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('con_position')); ?>:</b>
	<?php echo CHtml::encode($data->con_position); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('con_position_en')); ?>:</b>
	<?php echo CHtml::encode($data->con_position_en); ?>
	<br />	
	<b><?php echo CHtml::encode($data->getAttributeLabel('con_email')); ?>:</b>
	<?php echo CHtml::encode($data->con_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('con_image')); ?>:</b>
	<?php echo CHtml::encode($data->con_image); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date')); ?>:</b>
	<?php echo CHtml::encode($data->start_date); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date')); ?>:</b>
	<?php echo CHtml::encode($data->end_date); ?>
	<br />

	

	<?php /*
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />

	*/ ?>

</div>