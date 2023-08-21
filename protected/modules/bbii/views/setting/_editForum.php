<?php
/* @var $this SettingController */
/* @var $model BbiiForum */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'edit-forum-form',
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
		'validateOnChange'=>false,
	)
)); ?>

	<p class="note"><?php echo Yii::t('BbiiModule.bbii', '<span class="required"></span>'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label"><?php echo $form->labelEx($model,'name'); ?></label>
		<div class="col-sm-9">
			<div class="form-control-material">
				<?php echo $form->textField($model,'name',array('size'=>40,'class'=>'form-control','placeholder'=>'Name')); ?>
				<label for="exampleInputEmail1">Name</label>
				<?php echo $form->error($model,'name'); ?>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label"><?php echo $form->labelEx($model,'subtitle'); ?></label>
		<div class="col-sm-9">
			<div class="form-control-material">
				<?php echo $form->textField($model,'subtitle',array('size'=>80,'class'=>'form-control','placeholder'=>'Subtitle')); ?>
				<label for="exampleInputEmail1">Subtitle</label>
				<?php echo $form->error($model,'subtitle'); ?>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'cat_id', array('id'=>'label_cat_id')); ?></label>
		<div class="col-sm-9">
			<?php echo $form->dropDownList($model,'cat_id',CHtml::listData(BbiiForum::model()->categories()->findAll(), 'id', 'name'), array('empty'=>'','class'=>'selectpicker'));  ?>
			<?php echo $form->error($model,'cat_id'); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'public', array('id'=>'label_public')); ?></label>
		<div class="col-sm-9">
			<?php echo $form->dropDownList($model,'public',array('0'=>Yii::t('BbiiModule.bbii', 'No'),'1'=>Yii::t('BbiiModule.bbii', 'Yes')), array('class'=>'selectpicker')); ?>
			<?php echo $form->error($model,'public'); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'locked', array('id'=>'label_locked')); ?></label>
		<div class="col-sm-9">
			<?php echo $form->dropDownList($model,'locked',array('0'=>Yii::t('BbiiModule.bbii', 'No'),'1'=>Yii::t('BbiiModule.bbii', 'Yes')), array('class'=>'selectpicker')); ?>
			<?php echo $form->error($model,'locked'); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'moderated', array('id'=>'label_moderated')); ?></label>
		<div class="col-sm-9">
			<?php echo $form->dropDownList($model,'moderated',array('0'=>Yii::t('BbiiModule.bbii', 'No'),'1'=>Yii::t('BbiiModule.bbii', 'Yes')), array('class'=>'selectpicker')); ?>
			<?php echo $form->error($model,'moderated'); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'membergroup_id', array('id'=>'label_membergroup')); ?></label>
		<div class="col-sm-9">
			<?php echo $form->dropDownList($model,'membergroup_id',CHtml::listData(BbiiMembergroup::model()->specific()->findAll(), 'id', 'name'), array('empty'=>'','class'=>'selectpicker')); ?>
			<?php echo $form->error($model,'membergroup_id'); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'poll', array('id'=>'label_poll')); ?></label>
		<div class="col-sm-9">
			<?php echo $form->dropDownList($model,'poll',array('0'=>Yii::t('BbiiModule.bbii', 'No polls'),'1'=>Yii::t('BbiiModule.bbii', 'Moderator polls'),'2'=>Yii::t('BbiiModule.bbii', 'User polls')), array('class'=>'selectpicker')); ?>
			<?php echo $form->error($model,'poll'); ?>
		</div>
	</div>
	
	<div class="row">
		<?php echo $form->hiddenField($model,'id'); ?>
		<?php echo $form->hiddenField($model,'type'); ?>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->