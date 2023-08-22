<?php
/* @var $this ConfigCaptchaController */
/* @var $data ConfigCaptcha */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('capid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->capid), array('view', 'id'=>$data->capid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cid')); ?>:</b>
	<?php echo CHtml::encode($data->cid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lid')); ?>:</b>
	<?php echo CHtml::encode($data->lid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('capt_name')); ?>:</b>
	<?php echo CHtml::encode($data->capt_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('capt_time_random')); ?>:</b>
	<?php echo CHtml::encode($data->capt_time_random); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('capt_time_back')); ?>:</b>
	<?php echo CHtml::encode($data->capt_time_back); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('capt_times')); ?>:</b>
	<?php echo CHtml::encode($data->capt_times); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('capt_hide')); ?>:</b>
	<?php echo CHtml::encode($data->capt_hide); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('capt_active')); ?>:</b>
	<?php echo CHtml::encode($data->capt_active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_by')); ?>:</b>
	<?php echo CHtml::encode($data->updated_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_date')); ?>:</b>
	<?php echo CHtml::encode($data->updated_date); ?>
	<br />

	*/ ?>

</div>