<?php
/* @var $this MTypeanswerController */
/* @var $data MTypeanswer */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tan_nID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Tan_nID), array('view', 'id'=>$data->Tan_nID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tan_cNameTH')); ?>:</b>
	<?php echo CHtml::encode($data->Tan_cNameTH); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tan_cNameEN')); ?>:</b>
	<?php echo CHtml::encode($data->Tan_cNameEN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tan_cDescriptionTH')); ?>:</b>
	<?php echo CHtml::encode($data->Tan_cDescriptionTH); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tan_cDescriptionEN')); ?>:</b>
	<?php echo CHtml::encode($data->Tan_cDescriptionEN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tan_cRulesTH')); ?>:</b>
	<?php echo CHtml::encode($data->Tan_cRulesTH); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Tan_cRulesEN')); ?>:</b>
	<?php echo CHtml::encode($data->Tan_cRulesEN); ?>
	<br />

	<?php /*
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

	*/ ?>

</div>