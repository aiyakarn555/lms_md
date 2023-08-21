<?php
/* @var $this MSubchoiceController */
/* @var $data MSubchoice */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Sch_nID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Sch_nID), array('view', 'id'=>$data->Sch_nID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Sch_cNameTH')); ?>:</b>
	<?php echo CHtml::encode($data->Sch_cNameTH); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Sch_cNameEN')); ?>:</b>
	<?php echo CHtml::encode($data->Sch_cNameEN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Cho_nScore')); ?>:</b>
	<?php echo CHtml::encode($data->Cho_nScore); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stat_txt')); ?>:</b>
	<?php echo CHtml::encode($data->stat_txt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cCreateBy')); ?>:</b>
	<?php echo CHtml::encode($data->cCreateBy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dCreateDate')); ?>:</b>
	<?php echo CHtml::encode($data->dCreateDate); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('cUpdateBy')); ?>:</b>
	<?php echo CHtml::encode($data->cUpdateBy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dUpdateDate')); ?>:</b>
	<?php echo CHtml::encode($data->dUpdateDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cActive')); ?>:</b>
	<?php echo CHtml::encode($data->cActive); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Cho_nID')); ?>:</b>
	<?php echo CHtml::encode($data->Cho_nID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tan_nID')); ?>:</b>
	<?php echo CHtml::encode($data->Tan_nID); ?>
	<br />

	*/ ?>

</div>