<?php
/* @var $this ReportProblemController */
/* @var $data ReportProblem */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('firstname')); ?>:</b>
	<?php echo CHtml::encode($data->firstname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastname')); ?>:</b>
	<?php echo CHtml::encode($data->lastname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tel')); ?>:</b>
	<?php echo CHtml::encode($data->tel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('report_type')); ?>:</b>
	<?php echo CHtml::encode($data->report_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('report_title')); ?>:</b>
	<?php echo CHtml::encode($data->report_title); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('report_detail')); ?>:</b>
	<?php echo CHtml::encode($data->report_detail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('report_pic')); ?>:</b>
	<?php echo CHtml::encode($data->report_pic); ?>
	<br />

	*/ ?>

</div>