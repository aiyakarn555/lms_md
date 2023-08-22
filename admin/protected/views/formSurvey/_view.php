<?php
/* @var $this FormSurveyController */
/* @var $data FormSurvey */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('fs_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->fs_id), array('view', 'id'=>$data->fs_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fs_head')); ?>:</b>
	<?php echo CHtml::encode($data->fs_head); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fs_title')); ?>:</b>
	<?php echo CHtml::encode($data->fs_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fs_type')); ?>:</b>
	<?php echo CHtml::encode($data->fs_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('startdate')); ?>:</b>
	<?php echo CHtml::encode($data->startdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('enddate')); ?>:</b>
	<?php echo CHtml::encode($data->enddate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_date); ?>
	<br />

	<?php /*
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