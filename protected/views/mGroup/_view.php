<?php
/* @var $this MGroupController */
/* @var $data MGroup */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Gro_nID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Gro_nID), array('view', 'id'=>$data->Gro_nID)); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('cUpdateDate')); ?>:</b>
	<?php echo CHtml::encode($data->cUpdateDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cActive')); ?>:</b>
	<?php echo CHtml::encode($data->cActive); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Gna_nID')); ?>:</b>
	<?php echo CHtml::encode($data->Gna_nID); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Sna_nID')); ?>:</b>
	<?php echo CHtml::encode($data->Sna_nID); ?>
	<br />

	*/ ?>

</div>