<?php
/* @var $this TQuestionnairedateController */
/* @var $data TQuestionnairedate */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Yna_nID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Yna_nID), array('view', 'id'=>$data->Yna_nID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Yna_dDate')); ?>:</b>
	<?php echo CHtml::encode($data->Yna_dDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cCreateBy')); ?>:</b>
	<?php echo CHtml::encode($data->cCreateBy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dCreateDate')); ?>:</b>
	<?php echo CHtml::encode($data->dCreateDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cUpdateBy')); ?>:</b>
	<?php echo CHtml::encode($data->cUpdateBy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dUpdateDate')); ?>:</b>
	<?php echo CHtml::encode($data->dUpdateDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cActive')); ?>:</b>
	<?php echo CHtml::encode($data->cActive); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Gna_nID')); ?>:</b>
	<?php echo CHtml::encode($data->Gna_nID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Mem_nID')); ?>:</b>
	<?php echo CHtml::encode($data->Mem_nID); ?>
	<br />

	*/ ?>

</div>