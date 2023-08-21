<?php
/* @var $this MGradingController */
/* @var $data MGrading */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Gra_nID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Gra_nID), array('view', 'id'=>$data->Gra_nID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Gra_nScore')); ?>:</b>
	<?php echo CHtml::encode($data->Gra_nScore); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Gra_cDetailTH')); ?>:</b>
	<?php echo CHtml::encode($data->Gra_cDetailTH); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Gra_cDetailEN')); ?>:</b>
	<?php echo CHtml::encode($data->Gra_cDetailEN); ?>
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

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('dUpdateDate')); ?>:</b>
	<?php echo CHtml::encode($data->dUpdateDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cActive')); ?>:</b>
	<?php echo CHtml::encode($data->cActive); ?>
	<br />

	*/ ?>

</div>