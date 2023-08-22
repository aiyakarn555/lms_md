<?php
/* @var $this CertificateController */
/* @var $data Certificate */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('cert_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->cert_id), array('view', 'id'=>$data->cert_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cert_name')); ?>:</b>
	<?php echo CHtml::encode($data->cert_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cert_background')); ?>:</b>
	<?php echo CHtml::encode($data->cert_background); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cert_signature')); ?>:</b>
	<?php echo CHtml::encode($data->cert_signature); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cert_hide')); ?>:</b>
	<?php echo CHtml::encode($data->cert_hide); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_by')); ?>:</b>
	<?php echo CHtml::encode($data->create_by); ?>
	<br />

	<?php /*
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