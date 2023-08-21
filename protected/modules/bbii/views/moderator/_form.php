<?php
/* @var $this ModeratorController */
/* @var $model MailForm */
/* @var $form CActiveForm */
?>
<div class="panel panel-default">
	<div class="panel-body">
		<form>
<h2><?php echo Yii::t('BbiiModule.bbii','Send mail to multiple forum members'); ?></h2>
<?php if(Yii::app()->user->hasFlash('success')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('success'); ?>
</div>

<?php endif; ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bbii-mail-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><?php echo Yii::t('BbiiModule.bbii', '<span class="required"></span>'); ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<label class="col-sm-3 control-label"><?php echo CHtml::label(Yii::t('BbiiModule.bbii','Member groups'), 'member_id'); ?></label>
		<div class="col-sm-9">
			<?php echo $form->dropDownList($model, 'member_id', CHtml::listData(BbiiMembergroup::model()->findAll(), 'id', 'name'), array('empty'=>Yii::t('BbiiModule.bbii','All members'),'class'=>'selectpicker'));  ?>
			<?php echo $form->error($model,'member_id'); ?>
		</div>
	</div>
<br><br><br>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label"><?php echo $form->labelEx($model,'subject'); ?></label>
		<div class="col-sm-9">
			<div class="form-control-material">
				<?php echo $form->textField($model,'subject',array('size'=>80,'maxlength'=>255,'class'=>'form-control','placeholder'=>'Subject')); ?>
				<label for="exampleInputEmail1">Subject</label>
				<?php echo $form->error($model,'subject'); ?>
			</div>
		</div>
	</div>
	<br><br><br>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label"></label>
		<div class="col-sm-9">
				<?php $this->widget($this->module->id.'.extensions.editMe.widgets.ExtEditMe', array(
					'model'=>$model,
					'attribute'=>'body',
					'autoLanguage'=>false,
					'height'=>'300px',
					'toolbar'=>array(
						array(
							'Bold', 'Italic', 'Underline', 'RemoveFormat'
						),
						array(
							'TextColor', 'BGColor',
						),
						'-',
						array('Link', 'Unlink', 'Image'),
						'-',
						array('Blockquote'),
					),
					'skin'=>$this->module->editorSkin,
					'uiColor'=>$this->module->editorUIColor,
					'contentsCss'=>$this->module->editorContentsCss,
				)); ?>
				<?php echo $form->error($model,'body'); ?>
		</div>
	</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<br>
				<div>
					<?php if($this->module->userMailColumn) { echo CHtml::submitButton(Yii::t('BbiiModule.bbii', 'Send e-mail'), array('name'=>'email')); } ?>
					<?php echo CHtml::submitButton(Yii::t('BbiiModule.bbii', 'Send private message'), array('name'=>'pm','class'=>'btn btn-primary')); ?>
				</div>
			</div>
		</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
		</form>
	</div>
</div>
<script>
	$( 'textarea' ).ckeditor( function( textarea ) {
		// Callback function code.
	} );
</script>