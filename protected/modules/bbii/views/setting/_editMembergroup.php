<?php
/* @var $this SettingController */
/* @var $model BbiiMembergroup */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'edit-membergroup-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note"><?php echo Yii::t('BbiiModule.bbii', '<span class="required"></span>'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label"><?php echo $form->labelEx($model,'name'); ?></label>
		<div class="col-sm-9">
			<div class="form-control-material">
				<?php echo $form->textField($model,'name',array('size'=>40, 'id'=>'name','class'=>'form-control','placeholder'=>'Name')); ?>
				<label for="exampleInputEmail1">Name</label>
				<?php echo $form->error($model,'name'); ?>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label"><?php echo $form->labelEx($model,'description'); ?></label>
		<div class="col-sm-9">
			<div class="form-control-material">
				<?php echo $form->textField($model,'description',array('size'=>40, 'id'=>'description','class'=>'form-control','placeholder'=>'Description')); ?>
				<label for="exampleInputEmail1">Description</label>
				<?php echo $form->error($model,'description'); ?>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label"><?php echo $form->labelEx($model,'min_posts'); ?></label>
		<div class="col-sm-9">
			<div class="form-control-material">
				<?php echo $form->textField($model,'min_posts',array('size'=>10, 'id'=>'min_posts','class'=>'form-control','placeholder'=>'Min posts')); ?>
				<label for="exampleInputEmail1">Min posts</label>
				<?php echo $form->error($model,'min_posts'); ?>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label"><?php echo $form->labelEx($model,'color'); ?></label>
		<div class="col-sm-8">
			<div class="form-control-material">
				<?php echo $form->textField($model, 'color', array('id'=>'colorpickerField', 'style'=>'width:70px;', 'onchange'=>'BBiiSetting.ChangeColor(this)','class'=>'form-control','placeholder'=>'Color')); ?>
				<label for="exampleInputEmail1">Color</label>
			</div>
			</div>
				<div class="col-sm-1">
					<div class="form-control-material">
				<?php echo CHtml::textField('colorpickerColor', '', array('style'=>'width:40px;', 'readonly'=>true,'class'=>'form-control')); ?>
						</div>
					</div>
				<?php echo $form->error($model,'color'); ?>
	</div>

	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label"><?php echo $form->labelEx($model,'image'); ?></label>
		<div class="col-sm-9">
			<div class="form-control-material">
				<?php echo $form->textField($model,'image',array('size'=>40, 'id'=>'min_posts','class'=>'form-control','placeholder'=>'Image')); ?>
				<label for="exampleInputEmail1">Image</label>
				<?php echo $form->error($model,'image'); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'id'); ?>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->