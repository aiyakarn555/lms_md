<?php
/* @var $this MGroupquestionnaireController */
/* @var $data MGroupquestionnaire */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Gna_nID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Gna_nID), array('view', 'id'=>$data->Gna_nID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Gna_cNameTH')); ?>:</b>
	<?php echo CHtml::encode($data->Gna_cNameTH); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Gna_cNameEN')); ?>:</b>
	<?php echo CHtml::encode($data->Gna_cNameEN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Gna_dStart')); ?>:</b>
	<?php echo CHtml::encode($data->Gna_dStart); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Gna_dEnd')); ?>:</b>
	<?php echo CHtml::encode($data->Gna_dEnd); ?>
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

	*/ ?>

</div>