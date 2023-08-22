<?php
/* @var $this MaildetailController */
/* @var $data Maildetail */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mail_title')); ?>:</b>
	<?php echo CHtml::encode($data->mail_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mail_detail')); ?>:</b>
	<?php echo CHtml::encode($data->mail_detail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />


</div>