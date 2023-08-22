<?php
/* @var $this SignatureController */
/* @var $data Signature */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('sign_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->sign_id), array('view', 'id'=>$data->sign_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sign_title')); ?>:</b>
	<?php echo CHtml::encode($data->sign_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sign_hide')); ?>:</b>
	<?php echo CHtml::encode($data->sign_hide); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sign_path')); ?>:</b>
	<?php echo CHtml::encode($data->sign_path); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_by')); ?>:</b>
	<?php echo CHtml::encode($data->create_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />


</div>