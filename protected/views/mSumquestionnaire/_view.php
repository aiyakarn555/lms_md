<?php
/* @var $this MSumquestionnaireController */
/* @var $data MSumquestionnaire */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Sna_nID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Sna_nID), array('view', 'id'=>$data->Sna_nID)); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('Que_nID')); ?>:</b>
	<?php echo CHtml::encode($data->Que_nID); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Cho_nID')); ?>:</b>
	<?php echo CHtml::encode($data->Cho_nID); ?>
	<br />

	*/ ?>

</div>