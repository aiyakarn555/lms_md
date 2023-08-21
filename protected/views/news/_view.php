<?php
/* @var $this NewsController */
/* @var $data News */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('cms_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->cms_id), array('view', 'id'=>$data->cms_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cms_title')); ?>:</b>
	<?php echo CHtml::encode($data->cms_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cms_short_title')); ?>:</b>
	<?php echo CHtml::encode($data->cms_short_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cms_detail')); ?>:</b>
	<?php echo CHtml::encode($data->cms_detail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cms_picture')); ?>:</b>
	<?php echo CHtml::encode($data->cms_picture); ?>
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