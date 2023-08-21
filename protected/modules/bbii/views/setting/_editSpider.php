<?php
/* @var $this SettingController */
/* @var $model BbiiSpider */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'edit-spider-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note"><?php echo Yii::t('BbiiModule.bbii', '<span class="required"></span>'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label"><?php echo $form->labelEx($model,'name'); ?></label>
		<div class="col-sm-9">
			<div class="form-control-material">
				<?php echo $form->textField($model,'name',array('size'=>25, 'id'=>'name','class'=>'form-control','placeholder'=>'Name')); ?>
				<label for="exampleInputEmail1">Name</label>
				<?php echo $form->error($model,'name'); ?>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label"><?php echo $form->labelEx($model,'user_agent'); ?></label>
		<div class="col-sm-9">
			<div class="form-control-material">
				<?php echo $form->textField($model,'user_agent',array('size'=>70, 'id'=>'user_agent','class'=>'form-control','placeholder'=>'User Agent')); ?>
				<label for="exampleInputEmail1">User Agent</label>
				<?php echo $form->error($model,'user_agent'); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<?php echo $form->hiddenField($model,'id'); ?>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->