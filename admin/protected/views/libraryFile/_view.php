<?php
/* @var $this LibraryFileController */
/* @var $data LibraryFile */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('library_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->library_id), array('view', 'id'=>$data->library_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sortOrder')); ?>:</b>
	<?php echo CHtml::encode($data->sortOrder); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('library_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->library_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('library_name')); ?>:</b>
	<?php echo CHtml::encode($data->library_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('library_name_en')); ?>:</b>
	<?php echo CHtml::encode($data->library_name_en); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('library_filename')); ?>:</b>
	<?php echo CHtml::encode($data->library_filename); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<?php /*
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