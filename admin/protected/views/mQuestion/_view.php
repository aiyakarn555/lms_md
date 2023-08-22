<?php
/* @var $this MQuestionController */
/* @var $data MQuestion */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Que_nID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Que_nID), array('view', 'id'=>$data->Que_nID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Que_cNameTH')); ?>:</b>
	<?php echo CHtml::encode($data->Que_cNameTH); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Que_cNameEN')); ?>:</b>
	<?php echo CHtml::encode($data->Que_cNameEN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Que_cDetailTH')); ?>:</b>
	<?php echo CHtml::encode($data->Que_cDetailTH); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Que_cDetailEN')); ?>:</b>
	<?php echo CHtml::encode($data->Que_cDetailEN); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tit_nID')); ?>:</b>
	<?php echo CHtml::encode($data->Tit_nID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tan_nID')); ?>:</b>
	<?php echo CHtml::encode($data->Tan_nID); ?>
	<br />

	*/ ?>

</div>