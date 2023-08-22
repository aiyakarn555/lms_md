<?php
/* @var $this FeaturedLinksController */
/* @var $data FeaturedLinks */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('link_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->link_id), array('view', 'id'=>$data->link_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link_image')); ?>:</b>
	<?php echo CHtml::encode($data->link_image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link_name')); ?>:</b>
	<?php echo CHtml::encode($data->link_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link_url')); ?>:</b>
	<?php echo CHtml::encode($data->link_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('createby')); ?>:</b>
	<?php echo CHtml::encode($data->createby); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('createdate')); ?>:</b>
	<?php echo CHtml::encode($data->createdate); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('updateby')); ?>:</b>
	<?php echo CHtml::encode($data->updateby); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updatedate')); ?>:</b>
	<?php echo CHtml::encode($data->updatedate); ?>
	<br />

	*/ ?>

</div>