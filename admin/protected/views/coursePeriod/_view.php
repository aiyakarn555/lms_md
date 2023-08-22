<?php
/* @var $this CoursePeriodController */
/* @var $data CoursePeriod */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_course')); ?>:</b>
	<?php echo CHtml::encode($data->id_course); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('startdate')); ?>:</b>
	<?php echo CHtml::encode($data->startdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('enddate')); ?>:</b>
	<?php echo CHtml::encode($data->enddate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hour_accounting')); ?>:</b>
	<?php echo CHtml::encode($data->hour_accounting); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('hour_etc')); ?>:</b>
	<?php echo CHtml::encode($data->hour_etc); ?>
	<br />


</div>