<?php
/* @var $this TQuestionnairequestionController */
/* @var $data TQuestionnairequestion */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Qna_nID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Qna_nID), array('view', 'id'=>$data->Qna_nID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Que_cNameTH')); ?>:</b>
	<?php echo CHtml::encode($data->Que_cNameTH); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Que_cNameEN')); ?>:</b>
	<?php echo CHtml::encode($data->Que_cNameEN); ?>
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

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('cActive')); ?>:</b>
	<?php echo CHtml::encode($data->cActive); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Que_nID')); ?>:</b>
	<?php echo CHtml::encode($data->Que_nID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Yna_nID')); ?>:</b>
	<?php echo CHtml::encode($data->Yna_nID); ?>
	<br />

	*/ ?>

</div>