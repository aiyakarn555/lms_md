<?php
/* @var $this OrderController */
/* @var $data Order */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->order_id), array('view', 'id'=>$data->order_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_cost')); ?>:</b>
	<?php echo CHtml::encode($data->order_cost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_countnum')); ?>:</b>
	<?php echo CHtml::encode($data->order_countnum); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_countall')); ?>:</b>
	<?php echo CHtml::encode($data->order_countall); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_file')); ?>:</b>
	<?php echo CHtml::encode($data->order_file); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('con_user')); ?>:</b>
	<?php echo CHtml::encode($data->con_user); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('con_admin')); ?>:</b>
	<?php echo CHtml::encode($data->con_admin); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />

	*/ ?>

</div>