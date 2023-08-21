<?php
/* @var $this FaqController */
/* @var $data Faq */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('faq_nid_')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->faq_nid_), array('view', 'id'=>$data->faq_nid_)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('faq_ENtopic')); ?>:</b>
	<?php echo CHtml::encode($data->faq_ENtopic); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('faq_THtopic')); ?>:</b>
	<?php echo CHtml::encode($data->faq_THtopic); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('faq_ENanswer')); ?>:</b>
	<?php echo CHtml::encode($data->faq_ENanswer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('faq_THanswer')); ?>:</b>
	<?php echo CHtml::encode($data->faq_THanswer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('faq_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->faq_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('faq_hideStatus')); ?>:</b>
	<?php echo CHtml::encode($data->faq_hideStatus); ?>
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