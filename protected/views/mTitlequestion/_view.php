<?php
/* @var $this MTitlequestionController */
/* @var $data MTitlequestion */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tit_nID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Tit_nID), array('view', 'id'=>$data->Tit_nID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tit_cNameTH')); ?>:</b>
	<?php echo CHtml::encode($data->Tit_cNameTH); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tit_cNameEN')); ?>:</b>
	<?php echo CHtml::encode($data->Tit_cNameEN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tit_cDetailTH')); ?>:</b>
	<?php echo CHtml::encode($data->Tit_cDetailTH); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tit_cDetailEN')); ?>:</b>
	<?php echo CHtml::encode($data->Tit_cDetailEN); ?>
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