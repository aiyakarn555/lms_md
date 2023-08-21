<?php
/* @var $this ForumController */
/* @var $model BbiiMember */

$this->bbii_breadcrumbs=array(
	Yii::t('BbiiModule.bbii', 'Forum')=>array('forum/index'),
	Yii::t('BbiiModule.bbii', 'Members')=>array('member/index'),
	$model->member_name . Yii::t('BbiiModule.bbii', '\'s profile')=>array('member/view','id'=>$model->id),
	Yii::t('BbiiModule.bbii', 'Update')
);

$item = array(
	array('label'=>Yii::t('BbiiModule.bbii', 'เว็บบอร์ด'), 'url'=>array('forum/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'สมาชิก'), 'url'=>array('member/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'การอนุมัติ'), 'url'=>array('moderator/approval'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'โพส'), 'url'=>array('moderator/admin'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
);

Yii::app()->clientScript->registerScript('presence', "
$('.presence-button').click(function(){
	$('.presence').toggle();
	return false;
});
$('.presence').hide();
", CClientScript::POS_READY);

?>
<style>
	.grid-view{
		padding: 0 !important;
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

	<h2><center><?php echo $model->member_name . Yii::t('BbiiModule.bbii', '\'s profile'); ?></center></h2>

	<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'bbii-member-form',
		'enableAjaxValidation'=>false,
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	)); ?>

		<p class="note"><?php echo Yii::t('BbiiModule.bbii', '<span class="required"></span>'); ?></p>

		<?php echo $form->errorSummary($model); ?>

		<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $form->labelEx($model,'member_name'); ?></label>
			<div class="col-sm-8">
				<div class="form-control-material">
					<?php echo $form->textField($model,'member_name',array('size'=>45,'maxlength'=>45,'class'=>'form-control','placeholder'=>'Name to display')); ?>
					<?php echo $form->error($model,'member_name'); ?>
				</div>
			</div>
		</div>

		<?php if($this->isModerator()): ?>
		<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $form->labelEx($model,'group_id'); ?></label>
			<div class="col-sm-8">
				<?php echo $form->dropDownList($model, 'group_id', CHtml::listData(BbiiMembergroup::model()->findAll(), 'id', 'name'), array('class'=>'selectpicker'));  ?>
				<?php echo $form->error($model,'group_id'); ?>
			</div>
		</div>
		<?php endif; ?>

		<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $form->labelEx($model,'gender'); ?></label>
			<div class="col-sm-8">
				<?php echo $form->dropDownList($model,'gender',array(''=>'','0'=>Yii::t('BbiiModule.bbii', 'Male'),'1'=>Yii::t('BbiiModule.bbii', 'Female')), array('class'=>'selectpicker')); ?>
				<?php echo $form->error($model,'gender'); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $form->labelEx($model,'birthdate'); ?></label>
			<div class="col-sm-8">
				<div class="form-control-material">
					<input id="datepicker" type="text" class="form-control datepicker">
					<!-- <?php //echo $form->hiddenField($model,'birthdate'); ?>
					<?php //$this->widget('zii.widgets.jui.CJuiDatePicker',array(
						// 'name'=>'birthdate',
						// 'value'=>Yii::app()->dateFormatter->formatDateTime($model->birthdate, 'short', null),
						// 'language'=>substr(Yii::app()->language, 0, 2),
						// 'theme'=>$this->module->juiTheme,
						// 'options'=>array(
						// 	'altField'=>'#BbiiMember_birthdate',
						// 	'altFormat'=>'yyyy-mm-dd',
						// 	'showAnim'=>'fold',
						// ),
						// 'htmlOptions'=>array(
						// 	'style'=>'height:20px;',
						// 	'class'=>'form-control datepicker'
						// ),
					//)); ?>
					<?php //echo $form->error($model,'birthdate'); ?> -->
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $form->labelEx($model,'location'); ?></label>
			<div class="col-sm-8">
				<div class="form-control-material">
					<?php echo $form->textField($model,'location',array('size'=>100,'maxlength'=>255,'class'=>'form-control','placeholder'=>'Location')); ?>
					<?php echo $form->error($model,'location'); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $form->labelEx($model,'personal_text'); ?></label>
			<div class="col-sm-8">
				<div class="form-control-material">
					<?php echo $form->textField($model,'personal_text',array('size'=>100,'maxlength'=>255,'class'=>'form-control','placeholder'=>'Profile text')); ?>
					<?php echo $form->error($model,'personal_text'); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $form->labelEx($model,'show_online'); ?></label>
			<div class="col-sm-8">
				<?php echo $form->dropDownList($model,'show_online',array('0'=>Yii::t('BbiiModule.bbii', 'No'),'1'=>Yii::t('BbiiModule.bbii', 'Yes')),array('class'=>'selectpicker')); ?>
				<?php echo $form->error($model,'show_online'); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $form->labelEx($model,'contact_email'); ?></label>
			<div class="col-sm-8">
				<?php echo $form->dropDownList($model,'contact_email',array('0'=>Yii::t('BbiiModule.bbii', 'No'),'1'=>Yii::t('BbiiModule.bbii', 'Yes')),array('class'=>'selectpicker')); ?>
				<?php echo $form->error($model,'contact_email'); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-6 control-label"><?php echo $form->labelEx($model,'contact_pm'); ?></label>
			<div class="col-sm-6">
				<?php echo $form->dropDownList($model,'contact_pm',array('0'=>Yii::t('BbiiModule.bbii', 'No'),'1'=>Yii::t('BbiiModule.bbii', 'Yes')),array('class'=>'selectpicker')); ?>
				<?php echo $form->error($model,'contact_pm'); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label"><?php echo $form->labelEx($model,'timezone'); ?></label>
			<div class="col-sm-8">
				<?php echo $form->dropDownList($model, 'timezone', array_combine(DateTimeZone::listIdentifiers(), DateTimeZone::listIdentifiers()),array('class'=>'selectpicker')); ?>
				<?php echo $form->error($model,'timezone'); ?>
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label"><?php echo $form->labelEx($model,'avatar'); ?></label>
			<div class="col-md-8">
				<div class="media v-middle">
					<div class="media-left">
						<?php echo CHtml::image((isset($model->avatar))?(Yii::app()->request->baseUrl . $this->module->avatarStorage . '/'. $model->avatar):$this->module->getRegisteredImage('empty.jpeg'), 'avatar', array('align'=>'left','style'=>'margin:0 10px 10px 0;')); ?>
					</div>
					<div class="media-body">
						<?php echo $form->labelEx($model,'remove_avatar'); ?>
						<?php echo $form->checkBox($model, 'remove_avatar'); ?><br>
						<?php echo $form->labelEx($model, 'image'); ?>
						<?php echo $form->fileField($model, 'image', array('size'=>90,'class'=>'btn btn-white btn-sm paper-shadow relative')); ?><br>
						<?php echo Yii::t('BbiiModule.bbii', 'Large images will be resized to fit a size of 90 pixels by 90 pixels.'); ?>
						<?php echo $form->error($model, 'image'); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label"><?php echo $form->labelEx($model,'signature'); ?></label>
			<div class="col-sm-8">
			<?php $this->widget($this->module->id.'.extensions.editMe.widgets.ExtEditMe', array(
				'model'=>$model,
				'attribute'=>'signature',
				'autoLanguage'=>false,
				'height'=>'120px',
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
			<?php echo $form->error($model,'signature'); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-12 control-label"><?php echo CHtml::link(Yii::t('BbiiModule.bbii', 'My presence on the internet'),'#',array('class'=>'presence-button')); ?></label>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'website'); ?></label>
			<div class="col-sm-1">
				<?php echo CHtml::image($this->module->getRegisteredImage('Globe.png'), 'Website', array('style'=>'vertical-align:middle')); ?>
			</div>
			<div class="col-sm-8">
				<div class="form-control-material">
					<?php echo $form->textField($model,'website',array('size'=>100,'maxlength'=>255,'class'=>'form-control','placeholder'=>'My website')); ?>
					<?php echo $form->error($model,'website'); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'blogger'); ?></label>
			<div class="col-sm-1">
				<?php echo CHtml::image($this->module->getRegisteredImage('Blogger.png'), 'Blogger', array('style'=>'vertical-align:middle')); ?>
			</div>
			<div class="col-sm-8">
				<div class="form-control-material">
					<?php echo $form->textField($model,'blogger',array('size'=>100,'maxlength'=>255,'class'=>'form-control','placeholder'=>'My Blogger blog')); ?>
					<?php echo $form->error($model,'blogger'); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'facebook'); ?></label>
			<div class="col-sm-1">
				<?php echo CHtml::image($this->module->getRegisteredImage('Facebook.png'), 'Facebook', array('style'=>'vertical-align:middle')); ?>
			</div>
			<div class="col-sm-8">
				<div class="form-control-material">
					<?php echo $form->textField($model,'facebook',array('size'=>100,'maxlength'=>255,'class'=>'form-control','placeholder'=>'My Facebook page')); ?>
					<?php echo $form->error($model,'facebook'); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'flickr'); ?></label>
			<div class="col-sm-1">
				<?php echo CHtml::image($this->module->getRegisteredImage('Flickr.png'), 'Flickr', array('style'=>'vertical-align:middle')); ?>
			</div>
			<div class="col-sm-8">
				<div class="form-control-material">
					<?php echo $form->textField($model,'flickr',array('size'=>100,'maxlength'=>255,'class'=>'form-control','placeholder'=>'My Flickr account')); ?>
					<?php echo $form->error($model,'flickr'); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'google'); ?></label>
			<div class="col-sm-1">
				<?php echo CHtml::image($this->module->getRegisteredImage('Google.png'), 'Google', array('style'=>'vertical-align:middle')); ?>
			</div>
			<div class="col-sm-8">
				<div class="form-control-material">
					<?php echo $form->textField($model,'google',array('size'=>100,'maxlength'=>255,'class'=>'form-control','placeholder'=>'My Google+ page')); ?>
					<?php echo $form->error($model,'google'); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'linkedin'); ?></label>
			<div class="col-sm-1">
				<?php echo CHtml::image($this->module->getRegisteredImage('Linkedin.png'), 'Linkedin', array('style'=>'vertical-align:middle')); ?>
			</div>
			<div class="col-sm-8">
				<div class="form-control-material">
					<?php echo $form->textField($model,'linkedin',array('size'=>100,'maxlength'=>255,'class'=>'form-control','placeholder'=>'My Linkedin page')); ?>
					<?php echo $form->error($model,'linkedin'); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'metacafe'); ?></label>
			<div class="col-sm-1">
				<?php echo CHtml::image($this->module->getRegisteredImage('Metacafe.png'), 'Metacafe', array('style'=>'vertical-align:middle')); ?>
			</div>
			<div class="col-sm-8">
				<div class="form-control-material">
					<?php echo $form->textField($model,'metacafe',array('size'=>100,'maxlength'=>255,'class'=>'form-control','placeholder'=>'My Metacafe channel')); ?>
					<?php echo $form->error($model,'metacafe'); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'myspace'); ?></label>
			<div class="col-sm-1">
				<?php echo CHtml::image($this->module->getRegisteredImage('Myspace.png'), 'Myspace', array('style'=>'vertical-align:middle')); ?>
			</div>
			<div class="col-sm-8">
				<div class="form-control-material">
					<?php echo $form->textField($model,'myspace',array('size'=>100,'maxlength'=>255,'class'=>'form-control','placeholder'=>'My Myspace page')); ?>
					<?php echo $form->error($model,'myspace'); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'orkut'); ?></label>
			<div class="col-sm-1">
				<?php echo CHtml::image($this->module->getRegisteredImage('Orkut.png'), 'Orkut', array('style'=>'vertical-align:middle')); ?>
			</div>
			<div class="col-sm-8">
				<div class="form-control-material">
					<?php echo $form->textField($model,'orkut',array('size'=>100,'maxlength'=>255,'class'=>'form-control','placeholder'=>'My Orkut page')); ?>
					<?php echo $form->error($model,'orkut'); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'tumblr'); ?></label>
			<div class="col-sm-1">
				<?php echo CHtml::image($this->module->getRegisteredImage('Tumblr.png'), 'Tumblr', array('style'=>'vertical-align:middle')); ?>
			</div>
			<div class="col-sm-8">
				<div class="form-control-material">
					<?php echo $form->textField($model,'tumblr',array('size'=>100,'maxlength'=>255,'class'=>'form-control','placeholder'=>'My Tumblr blog')); ?>
					<?php echo $form->error($model,'tumblr'); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'twitter'); ?></label>
			<div class="col-sm-1">
				<?php echo CHtml::image($this->module->getRegisteredImage('Twitter.png'), 'Twitter', array('style'=>'vertical-align:middle')); ?>
			</div>
			<div class="col-sm-8">
				<div class="form-control-material">
					<?php echo $form->textField($model,'twitter',array('size'=>100,'maxlength'=>255,'class'=>'form-control','placeholder'=>'My Twitter page')); ?>
					<?php echo $form->error($model,'twitter'); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'wordpress'); ?></label>
			<div class="col-sm-1">
				<?php echo CHtml::image($this->module->getRegisteredImage('Wordpress.png'), 'Wordpress', array('style'=>'vertical-align:middle')); ?>
			</div>
			<div class="col-sm-8">
				<div class="form-control-material">
					<?php echo $form->textField($model,'wordpress',array('size'=>100,'maxlength'=>255,'class'=>'form-control','placeholder'=>'My Wordpress blog')); ?>
					<?php echo $form->error($model,'wordpress'); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'youtube'); ?></label>
			<div class="col-sm-1">
				<?php echo CHtml::image($this->module->getRegisteredImage('Youtube.png'), 'Youtube',
					array('style'=>'vertical-align:middle')); ?>
			</div>
			<div class="col-sm-8">
				<div class="form-control-material">
					<?php echo $form->textField($model,'youtube',array('size'=>100,'maxlength'=>255,'class'=>'form-control','placeholder'=>'My Youtube channel')); ?>
					<?php echo $form->error($model,'youtube'); ?>
				</div>
			</div>
		</div>


			<div class="text-right">
				<?php echo CHtml::submitButton(Yii::t('BbiiModule.bbii', 'Save'),array('class'=>'btn btn-primary')); ?>
			</div>

	<?php $this->endWidget(); ?>

	</div><!-- form -->
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
<script>
	$( 'textarea' ).ckeditor( function( textarea ) {
		// Callback function code.
	} );
</script>
