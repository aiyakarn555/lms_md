<?php
/* @var $this CategoryController */
/* @var $data Category */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('cate_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->cate_id), array('view', 'id'=>$data->cate_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cate_type')); ?>:</b>
	<?php echo CHtml::encode($data->cate_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cate_title')); ?>:</b>
	<?php echo CHtml::encode($data->cate_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cate_short_detail')); ?>:</b>
	<?php echo CHtml::encode($data->cate_short_detail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cate_detail')); ?>:</b>
	<?php echo CHtml::encode($data->cate_detail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cate_image')); ?>:</b>
	<?php echo CHtml::encode($data->cate_image); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('cate_show')); ?>:</b>
	<?php echo CHtml::encode($data->cate_show); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('special_category')); ?>:</b>
	<?php echo CHtml::encode($data->special_category); ?>
	<br />

	*/ ?>

</div>