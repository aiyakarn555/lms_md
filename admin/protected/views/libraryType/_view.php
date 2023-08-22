<?php
/* @var $this LibraryTypeController */
/* @var $data LibraryType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('library_type_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->library_type_id), array('view', 'id'=>$data->library_type_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sortOrder')); ?>:</b>
	<?php echo CHtml::encode($data->sortOrder); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('library_type_name')); ?>:</b>
	<?php echo CHtml::encode($data->library_type_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('library_type_name_en')); ?>:</b>
	<?php echo CHtml::encode($data->library_type_name_en); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('library_type')); ?>:</b>
	<?php echo CHtml::encode($data->library_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_by')); ?>:</b>
	<?php echo CHtml::encode($data->updated_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_date')); ?>:</b>
	<?php echo CHtml::encode($data->updated_date); ?>
	<br />

	*/ ?>

</div>