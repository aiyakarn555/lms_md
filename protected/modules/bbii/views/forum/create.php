<?php
/* @var $this ForumController */
/* @var $forum BbiiForum */
/* @var $post BbiiPost */
/* @var $poll BbiiPoll */
/* @var $choices array */

$this->bbii_breadcrumbs=array(
	Yii::t('BbiiModule.bbii', 'Forum')=>array('forum/index'),
	$forum->name => array('forum/forum', 'id'=>$forum->id),
	Yii::t('BbiiModule.bbii', 'New topic'),
);

$item = array(
	array('label'=>Yii::t('BbiiModule.bbii', 'เว็บบอร์ด'), 'url'=>array('forum/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'สมาชิก'), 'url'=>array('member/index'), 'linkOptions'=>array('class'=>'btn btn-primary'))
);

if(empty($poll->question) && !$poll->hasErrors()) {
	$show = false;
} else {
	$show = true;
}
?>
<style>
	.list-view .summary{
		margin: 0!important;
	}
</style>
<div class="parallax bg-white page-section">
	<div class="container parallax-layer" data-opacity="true">
		<div class="media v-middle">
			<div class="media-body">
				<h1 class="text-display-2 margin-none">เว็บบอร์ด</h1>
				<p class="text-light lead">เว็บบอร์ดของหลักสูตร</p>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="page-section">
		<div class="row">
			<div class="col-md-12" style="padding-bottom: 15px;">

				<?php echo $this->renderPartial('_header', array('item'=>$item)); ?>

			</div>
			<div class="col-md-8 col-lg-9">
				<div class="panel panel-default">
					<div class="panel-body">

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

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label"><?php echo $form->labelEx($post,'subject'); ?></label>
			<div class="col-sm-9">
				<div class="form-control-material">
					<?php echo $form->textField($post,'subject',array('size'=>100,'maxlength'=>255,'style'=>'width:99%;','class'=>'form-control','placeholder'=>'Subject')); ?>
					<label for="exampleInputEmail1">Subject</label>
					<?php echo $form->error($post,'subject'); ?>
				</div>
			</div>
		</div>

		<?php echo $form->errorSummary($post); ?>

		<?php if($forum->poll == 2 || ($forum->poll == 1 && $this->isModerator())): ?>
			<div class="row button" id="poll-button" style="<?php echo ($show?'display:none;':''); ?>">
				<?php echo CHtml::button(Yii::t('BbiiModule.bbii','Add poll'), array('class'=>'bbii-poll-button','onclick'=>'showPoll()')); ?>
			</div>
			<div id="poll-form" style="<?php echo ($show?'':'display:none;'); ?>" class="bbii-poll-form">
				<div class="row">
					<?php echo CHtml::activeLabel($poll,'question'); ?>
					<?php echo CHtml::activeTextField($poll,'question',array('size'=>100,'maxlength'=>255,'style'=>'width:99%;')); ?>
					<?php echo CHtml::error($poll,'question'); ?>
				</div>

				<?php echo CHtml::errorSummary($poll); ?>

				<div class="row" id="poll-choices">
					<?php echo CHtml::label(Yii::t('BbiiModule.bbii','Choices'),false); ?>
					<?php foreach($choices as $key => $value): ?>
					<?php echo CHtml::textField('choice['.$key.']',$value,array('maxlength'=>80,'style'=>'width:99%;','onchange'=>'pollChange(this)')); ?>
					<?php endforeach; ?>
				</div>
				<div class="row">
					<strong><?php echo Yii::t('BbiiModule.bbii','Allow revote'); ?>:</strong>
					<?php echo CHtml::activeCheckbox($poll,'allow_revote'); ?> &nbsp;
					<strong><?php echo Yii::t('BbiiModule.bbii','Allow multiple choices'); ?>:</strong>
					<?php echo CHtml::activeCheckbox($poll,'allow_multiple'); ?> &nbsp;
					<strong><?php echo Yii::t('BbiiModule.bbii','Poll expires'); ?>:</strong>
					<?php echo $form->hiddenField($poll,'expire_date'); ?>
					<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
						'name'=>'expiredate',
						'value'=>Yii::app()->dateFormatter->formatDateTime($poll->expire_date, 'short', null),
						'language'=>substr(Yii::app()->language, 0, 2),
						'theme'=>$this->module->juiTheme,
						'options'=>array(
							'altField'=>'#BbiiPoll_expire_date',
							'altFormat'=>'yy-mm-dd',
							'showAnim'=>'fold',
							'defaultDate'=>7,
							'minDate'=>1,
						),
						'htmlOptions'=>array(
							'style'=>'height:18px;width:75px;',
						),
					)); ?>
				</div>
				<div class="row button">
					<?php echo CHtml::hiddenField('addPoll','no'); ?>
					<?php echo CHtml::button(Yii::t('BbiiModule.bbii','Remove poll'), array('class'=>'bbii-poll-button','onclick'=>'hidePoll()')); ?>
				</div>
			</div>
		<?php endif; ?>

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

		<?php if($this->isModerator()): ?>
			<div class="form-group">
				<label class="col-sm-3"></label>
				<div class="col-sm-9">
					<strong><?php echo Yii::t('BbiiModule.bbii','Sticky'); ?>:</strong>
					<?php echo CHtml::checkbox('sticky'); ?> &nbsp;
					<strong><?php echo Yii::t('BbiiModule.bbii','Global'); ?>:</strong>
					<?php echo CHtml::checkbox('global'); ?> &nbsp;
					<strong><?php echo Yii::t('BbiiModule.bbii','Locked'); ?>:</strong>
					<?php echo CHtml::checkbox('locked'); ?> &nbsp;
				</div>
			</div>
		<?php endif; ?>

		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9 text-right">
				<br>
				<div>
					<?php echo $form->hiddenField($post, 'forum_id',array('value'=>$forum->id)); ?>
					<?php echo CHtml::submitButton(Yii::t('BbiiModule.bbii','Save'), array('class'=>'btn btn-primary')); ?>
				</div>
			</div>
		</div>

		<?php $this->endWidget(); ?>
	</div><!-- form -->

							<br/>
					</div>
				</div>
				<br/>
			</div>
			<?php
			//right Menu
			echo $this->renderPartial('_right'); ?>


		</div>
	</div>
</div>

</div>
<script>
	$( 'textarea' ).ckeditor( function( textarea ) {
		// Callback function code.
	} );
</script>
