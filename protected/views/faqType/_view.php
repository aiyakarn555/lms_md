<?php
/* @var $this FaqTypeController */
/* @var $data FaqType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('faq_type_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->faq_type_id), array('view', 'id'=>$data->faq_type_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('faq_type_title_TH')); ?>:</b>
	<?php echo CHtml::encode($data->faq_type_title_TH); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('faq_type_title_EN')); ?>:</b>
	<?php echo CHtml::encode($data->faq_type_title_EN); ?>
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