<?php
/* @var $this TAnswerquestionnaireController */
/* @var $data TAnswerquestionnaire */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Ans_nID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Ans_nID), array('view', 'id'=>$data->Ans_nID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Cho_cNameTH')); ?>:</b>
	<?php echo CHtml::encode($data->Cho_cNameTH); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Cho_cNameEN')); ?>:</b>
	<?php echo CHtml::encode($data->Cho_cNameEN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Sch_cNameTH')); ?>:</b>
	<?php echo CHtml::encode($data->Sch_cNameTH); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Sch_cNameEN')); ?>:</b>
	<?php echo CHtml::encode($data->Sch_cNameEN); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Ans_Description')); ?>:</b>
	<?php echo CHtml::encode($data->Ans_Description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Ans_cOther')); ?>:</b>
	<?php echo CHtml::encode($data->Ans_cOther); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Ans_cComment')); ?>:</b>
	<?php echo CHtml::encode($data->Ans_cComment); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('Gra_nID')); ?>:</b>
	<?php echo CHtml::encode($data->Gra_nID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Qna_nID')); ?>:</b>
	<?php echo CHtml::encode($data->Qna_nID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Cho_nID')); ?>:</b>
	<?php echo CHtml::encode($data->Cho_nID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Sch_nID')); ?>:</b>
	<?php echo CHtml::encode($data->Sch_nID); ?>
	<br />

	*/ ?>

</div>