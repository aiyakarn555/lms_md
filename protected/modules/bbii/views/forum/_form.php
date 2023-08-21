<?php
/* @var $this ForumController */
/* @var $post BbiiPost */
/* @var $form CActiveForm */
?>
<noscript>
<div class="flash-notice">
<?php echo Yii::t('BbiiModule.bbii','Your web browser does not support JavaScript, or you have temporarily disabled scripting. This site needs JavaScript to function correct.'); ?>
</div>
</noscript>
<div class="form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'create-topic-form',
		'enableAjaxValidation'=>false,
	)); ?>
		<?php echo $form->errorSummary($post); ?>

	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label"><?php echo $form->labelEx($post,'subject'); ?></label>
		<div class="col-sm-9">
			<div class="form-control-material">
				<?php echo $form->textField($post,'subject',array('size'=>100,'maxlength'=>255,'style'=>'width:99%;','class'=>'form-control','placeholder'=>'Subject','readonly'=>'true')); ?>
				<?php echo $form->error($post,'subject'); ?>
			</div>
		</div>
	</div>
<br><br><br>
	<div class="form-group">
		<label class="col-sm-3"></label>
		<div class="col-sm-9">
				<?php $this->widget($this->module->id.'.extensions.editMe.widgets.ExtEditMe', array(
					'model'=>$post,
					'attribute'=>'content',
					'autoLanguage'=>false,
					'height'=>400,
					'toolbar'=>$this->module->editorToolbar,
					'skin'=>$this->module->editorSkin,
					'uiColor'=>$this->module->editorUIColor,
					'contentsCss'=>$this->module->editorContentsCss,
				)); ?>
				<?php echo $form->error($post,'content'); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label"></label>
		<div class="col-sm-9 text-right">
			<br>
			<div>
				<?php echo $form->hiddenField($post, 'forum_id'); ?>
				<?php echo $form->hiddenField($post, 'topic_id'); ?>
				<?php echo CHtml::submitButton(($post->isNewRecord)?Yii::t('BbiiModule.bbii','Create'):Yii::t('BbiiModule.bbii','Save'), array('class'=>'btn btn-primary')); ?>
			</div>
		</div>
	</div>

	<?php $this->endWidget(); ?>
</div><!-- form -->
<script>
	$( 'textarea' ).ckeditor( function( textarea ) {
		// Callback function code.
	} );
</script>
