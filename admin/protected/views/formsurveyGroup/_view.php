<?php
/* @var $this FormsurveyGroupController */
/* @var $data FormsurveyGroup */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('fg_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->fg_id), array('view', 'id'=>$data->fg_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fg_title')); ?>:</b>
	<?php echo CHtml::encode($data->fg_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lesson_id')); ?>:</b>
	<?php echo CHtml::encode($data->lesson_id); ?>
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