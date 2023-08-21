<?php
/* @var $this ForumController */
/* @var $model BbiiSetting */

$this->bbii_breadcrumbs=array(
	Yii::t('BbiiModule.bbii', 'Forum')=>array('forum/index'),
	Yii::t('BbiiModule.bbii', 'Settings'),
);

$item = array(
	array('label'=>Yii::t('BbiiModule.bbii', 'การตั้งค่า'), 'url'=>array('setting/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'รูปแบบเว็บบอร์ด'), 'url'=>array('setting/layout'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'จัดกลุ่มสมาชิก'), 'url'=>array('setting/group'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'ผู้ดูแลระบบ'), 'url'=>array('setting/moderator'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'Webspiders'), 'url'=>array('setting/spider'), 'linkOptions'=>array('class'=>'btn btn-primary')),
);
?>
<style>
	.list-view .summary{
		margin: 0!important;
	}
</style>
<div class="parallax overflow-hidden page-section bg-blue-300">
    <div class="container parallax-layer" data-opacity="true">
        <div class="media media-grid v-middle">
            <div class="media-left">
                <span class="icon-block half bg-blue-500 text-white" style="height: 45px;"><i class="fa fa-fw fa-comments-o"></i></span>
            </div>
            <div class="media-body">
                <h3 class="text-display-2 text-white margin-none">เว็บบอร์ด</h3>
                <p class="text-white text-subhead" style="font-size: 1.6rem;">เว็บบอร์ดของหลักสูตร</p>
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
						<form>
	<div class="form">



	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'bbii-setting-form',
		'enableAjaxValidation'=>false,
	)); ?>

		<p class="note"><?php echo Yii::t('BbiiModule.bbii', '<span class="required"></span>'); ?></p>

		<?php echo $form->errorSummary($model); ?>

		<div class="form-group">
			<br>
			<label class="col-md-4"><?php echo CHtml::label(Yii::t('BbiiModule.bbii', 'Forum name'), false); ?></label>
			<div class="input-group">
				<?php echo CHtml::image($this->module->getRegisteredImage('info.png'), 'Information', array('style'=>'vertical-align:middle;margin-left:10px','title'=>Yii::t('BbiiModule.bbii', 'The forum name is set by the module parameter "forumTitle".'))); ?>
				<?php echo $this->module->forumTitle; ?>
			</div>
		</div>

		<div class="form-group">
			<br>
			<label class="col-md-4"><?php echo CHtml::label(Yii::t('BbiiModule.bbii', 'Forum language'), false); ?></label>
			<div class="input-group">
				<?php echo CHtml::image($this->module->getRegisteredImage('info.png'), 'Information', array('style'=>'vertical-align:middle;margin-left:10px','title'=>Yii::t('BbiiModule.bbii', 'The forum language is set by the application parameter "language".'))); ?>
				<?php echo Yii::app()->language; ?>
			</div>
		</div>

		<div class="form-group">
			<br>
			<label class="col-md-4"><?php echo CHtml::label(Yii::t('BbiiModule.bbii', 'Forum timezone'), false); ?></label>
			<div class="input-group">
				<?php echo CHtml::image($this->module->getRegisteredImage('info.png'), 'Information', array('style'=>'vertical-align:middle;margin-left:10px','title'=>Yii::t('BbiiModule.bbii', 'The forum timezone is set by the PHP.ini parameter "date.timezone".'))); ?>
				<?php echo date_default_timezone_get(); ?>
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-4 control-label"><?php echo $form->labelEx($model,'contact_email'); ?></label>
			<div class="col-sm-8">
				<div class="form-control-material">
					<?php echo $form->textField($model,'contact_email',array('size'=>60,'maxlength'=>255,'class'=>'form-control','placeholder'=>'Forum contact e-mail address')); ?>
					<label for="exampleInputEmail1">Forum contact e-mail address</label>
					<?php echo $form->error($model,'contact_email'); ?>
				</div>
			</div>
		</div>

		<div class="text-right">
			<br><br><br>
			<?php echo CHtml::submitButton(Yii::t('BbiiModule.bbii', 'Save'),array('class'=>'btn btn-primary')); ?>
		</div>

	<?php $this->endWidget(); ?>

	</div><!-- form -->
			</form>
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