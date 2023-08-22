<div>

<?php $form=$this->beginWidget('CActiveForm'); ?>

	<div>
		<?php echo $form->dropDownList($model, 'itemname', $itemnameSelectOptions); ?>
		<?php echo $form->error($model, 'itemname'); ?>
	</div>

	<div class="buttons">
		<?php echo CHtml::submitButton(Rights::t('core', 'Assign')); ?>
	</div>

<?php $this->endWidget(); ?>

</div>