<?php
/* @var $this SettingController */
/* @var $model BbiiForum */
/* @var $category[] BbiiForum  */

$this->bbii_breadcrumbs=array(
	Yii::t('BbiiModule.bbii', 'Forum')=>array('forum/index'),
	Yii::t('BbiiModule.bbii', 'Settings')=>array('setting/index'),
	Yii::t('BbiiModule.bbii', 'Forum layout'),
);

$item = array(
	array('label'=>Yii::t('BbiiModule.bbii', 'การตั้งค่า'), 'url'=>array('setting/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'รูปแบบเว็บบอร์ด'), 'url'=>array('setting/layout'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'จัดกลุ่มสมาชิก'), 'url'=>array('setting/group'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'ผู้ดูแลระบบ'), 'url'=>array('setting/moderator'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'Webspiders'), 'url'=>array('setting/spider'), 'linkOptions'=>array('class'=>'btn btn-primary')),
);

Yii::app()->clientScript->registerScript('confirmation', "
var confirmation = new Array();
confirmation[0] = '" . Yii::t('BbiiModule.bbii', 'Are you sure that you want to delete this category?') . "';
confirmation[1] = '" . Yii::t('BbiiModule.bbii', 'Are you sure that you want to delete this forum?') . "';
", CClientScript::POS_BEGIN);
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
				<form>
	
	<h3><?php echo Yii::t('BbiiModule.bbii', 'Add category or forum'); ?></h3>
	
	<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'bbii-forum-form',
		'enableAjaxValidation'=>false,
	)); ?>

		<p class="note"><?php echo Yii::t('BbiiModule.bbii', '<span class="required"></span>'); ?></p>
		
		<?php echo $form->errorSummary($model); ?>

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label"><?php echo $form->labelEx($model,'name'); ?></label>
			<div class="col-sm-9">
				<div class="form-control-material">
					<?php echo $form->textField($model,'name',array('size'=>100,'maxlength'=>255, 'id'=>'name','class'=>'form-control','placeholder'=>'Name')); ?>
					<label for="exampleInputEmail1">Name</label>
					<?php echo $form->error($model,'name'); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail3" class="col-sm-3 control-label"><?php echo $form->labelEx($model,'subtitle'); ?></label>
			<div class="col-sm-9">
				<div class="form-control-material">
					<?php echo $form->textField($model,'subtitle',array('size'=>100,'maxlength'=>255, 'id'=>'subtitle','class'=>'form-control','placeholder'=>'Subtitle')); ?>
					<label for="exampleInputEmail1">Subtitle</label>
					<?php echo $form->error($model,'subtitle'); ?>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'type'); ?></label>
			<div class="col-sm-9">
				<?php echo $form->dropDownList($model,'type',array('0'=>Yii::t('BbiiModule.bbii', 'Category'),'1'=>Yii::t('BbiiModule.bbii', 'Forum')), array('id'=>'type','class'=>'selectpicker'));  ?>
				<?php echo $form->error($model,'type'); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"><?php echo $form->labelEx($model,'cat_id'); ?></label>
			<div class="col-sm-9">
				<?php echo $form->dropDownList($model,'cat_id',CHtml::listData(BbiiForum::model()->categories()->findAll(), 'id', 'name'), array('empty'=>'', 'id'=>'cat_id','class'=>'selectpicker'));  ?>
				<?php echo $form->error($model,'cat_id'); ?>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9 text-right">
				<br>
				<div>
					<?php echo CHtml::submitButton(Yii::t('BbiiModule.bbii', 'Add'), array('class'=>'btn btn-primary')); ?>
				</div>
			</div>
		</div>
		
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
					<br/>
				</form>
			</div>
		</div>
					<div class="panel panel-default">
						<div class="panel-body">
							<form>

	
	<h2><?php echo Yii::t('BbiiModule.bbii', 'Forum layout'); ?></h2>
	<div class="sortable">
	<?php
		$items = array();
		foreach($category as $data) {
			$forum = BbiiForum::model()->sorted()->forum()->findAll("cat_id = $data->id");
			$items['cat_'.$data->id] = $this->renderPartial('_category', array('data'=>$data, 'forum'=>$forum), true);
		}
		$this->widget('zii.widgets.jui.CJuiSortable', array(
			'id' => 'sortcategory',
			'items' => $items,
			'htmlOptions'=>array('style'=>'list-style:none;;margin-top:1px','class'=>'panel panel-default'),
			'theme'=>$this->module->juiTheme,
			'options'=>array(
				'delay'=>'100',
				'update'=>'js:function(){Sort(this,"' . $this->createAbsoluteUrl('setting/ajaxSort') . '");}',
			),
		));
	?>
	</div>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dlgEditForum',
	'theme'=>$this->module->juiTheme,
    'options'=>array(
        'title'=>'Edit',
        'autoOpen'=>false,
		'modal'=>true,
		'width'=>800,
		'show'=>'fade',
		'buttons'=>array(
			Yii::t('BbiiModule.bbii', 'Delete')=>'js:function(){ deleteForum("' . $this->createAbsoluteUrl('setting/deleteForum') .'"); }',
			Yii::t('BbiiModule.bbii', 'Save')=>'js:function(){ saveForum("' . $this->createAbsoluteUrl('setting/saveForum') .'"); }',
			Yii::t('BbiiModule.bbii', 'Cancel')=>'js:function(){ $(this).dialog("close"); }',
		),
    ),
));

    echo $this->renderPartial('_editForum', array('model'=>$model));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
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
