<?php
/* @var $this MessageController */
/* @var $model BbiiMessage */
/* @var $form CActiveForm */
?>
<noscript>
<div class="flash-notice">
<?php echo Yii::t('BbiiModule.bbii','Your web browser does not support JavaScript, or you have temporarily disabled scripting. This site needs JavaScript to function correct.'); ?>
</div>
</noscript>

<div class="panel panel-default">
	<div class="panel-body">
			<h1><?php echo ($this->action->id == 'create')?Yii::t('BbiiModule.bbii', 'New message'):Yii::t('BbiiModule.bbii', 'Reply'); ?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'message-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label"><?php echo $form->labelEx($model,'To'); ?></label>
		<div class="col-sm-9">
			<div class="form-control-material">
				<?php if($this->action->id == 'create'): ?>
					<?php echo $form->labelEx($model,'sendto'); ?>
					<?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
						'attribute'=>'search',
						'model'=>$model,
						'sourceUrl'=>array('member/members'),
						'theme'=>$this->module->juiTheme,
						'options'=>array(
							'minLength'=>2,
							'delay'=>200,
							'select'=>'js:function(event, ui) {
						$("#BbiiMessage_search").val(ui.item.label);
						$("#BbiiMessage_sendto").val(ui.item.value);
						return false;
					}',
						),
						'htmlOptions'=>array(
							'style'=>'height:20px;',
							'class'=>'form-control',
						),
					));
					?>
				<?php else: ?>
					<?php echo $form->label($model,'sendto'); ?>
					<strong><?php echo CHtml::encode($model->search); ?></strong>
				<?php endif; ?>
				<?php echo $form->hiddenField($model,'sendto'); ?>
				<?php echo $form->error($model,'sendto'); ?>
				<label for="exampleInputEmail1">To</label>
			</div>
		</div>
	</div>

	<br><br><br>
	<div class="form-group">
		<label for="inputEmail3" class="col-sm-3 control-label"><?php echo $form->labelEx($model,'subject'); ?></label>
		<div class="col-sm-9">
			<div class="form-control-material">
				<?php echo $form->textField($model,'subject',array('size'=>100,'maxlength'=>255,'class'=>'form-control','placeholder'=>'Subject')); ?>
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
				'attribute'=>'content',
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
			<?php echo $form->error($model,'content'); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-3 control-label"></label>
		<div class="col-sm-9">
			<br>
			<div>
				<?php echo $form->hiddenField($model,'type'); ?>
				<?php echo CHtml::submitButton(Yii::t('BbiiModule.bbii', 'Send'), array('class'=>'btn btn-primary')); ?>
			</div>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
	</div>
</div>
<script>
	$( 'textarea' ).ckeditor( function( textarea ) {
		// Callback function code.
	} );
</script>
