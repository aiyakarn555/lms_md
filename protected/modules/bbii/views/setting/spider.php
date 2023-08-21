<?php
/* @var $this SettingController */
/* @var $model BbiiSpider */

$this->bbii_breadcrumbs=array(
	Yii::t('BbiiModule.bbii', 'Forum')=>array('forum/index'),
	Yii::t('BbiiModule.bbii', 'Settings')=>array('setting/index'),
	Yii::t('BbiiModule.bbii', 'Webspiders')
);

$item = array(
	array('label'=>Yii::t('BbiiModule.bbii', 'การตั้งค่า'), 'url'=>array('setting/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'รูปแบบเว็บบอร์ด'), 'url'=>array('setting/layout'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'จัดกลุ่มสมาชิก'), 'url'=>array('setting/group'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'ผู้ดูแลระบบ'), 'url'=>array('setting/moderator'), 'linkOptions'=>array('class'=>'btn btn-primary'))
);

Yii::app()->clientScript->registerScript('confirmation', "
var confirmation = '" . Yii::t('BbiiModule.bbii', 'Are you sure that you want to delete this webspider?') . "'
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
	
	<?php echo CHtml::button(Yii::t('BbiiModule.bbii', 'New webspider'), array('onclick'=>'BBiiSetting.EditSpider()', 'class'=>'btn btn-primary')); ?>
	<br><br>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'spider-grid',
		'dataProvider'=>$model->search(),
		//'filter'=>$model,
		'template' => '{items}{pager}',
		'htmlOptions'=>array(
			'class'=>'panel panel-default',
		),
		'itemsCssClass'=>'table v-middle',
		'columns'=>array(
			array(
				'name'=>'name',
				'type'=>'raw',
				'value'=>'CHtml::link($data->name, $data->url, array("target"=>"_new")) . "<span style=\"display:none;\">{$data->id}</span>"',
			),
			'user_agent',
			array(
				'header' => Yii::t('BbiiModule.bbii', 'Hits'),
				'value' => '$data->hits',
				'htmlOptions' => array('style'=>'text-align:center;'),
			),
			array(
				'header' => Yii::t('BbiiModule.bbii', 'Last visit'),
				'value' => 'DateTimeCalculation::full($data->last_visit)',
			),
			array(
				'class'=>'CButtonColumn',
				'template'=>'{update}',
				'buttons' => array(
					'update' => array(
						'click'=>'js:function($data) { BBiiSetting.EditSpider($(this).closest("tr").children("td:first").children("span").text(), "' . $this->createAbsoluteUrl('setting/getSpider') .'");return false; }',
					),
				)
			),
		),
	)); ?>
			<br/>
		</form>
	</div>
	</div>
		<div class="panel panel-default">
			<div class="panel-body">
				<form>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dlgEditSpider',
	'theme'=>$this->module->juiTheme,
    'options'=>array(
        'title'=>'Edit',
        'autoOpen'=>false,
		'modal'=>true,
		'width'=>700,
		'show'=>'fade',
		'buttons'=>array(
			Yii::t('BbiiModule.bbii', 'Delete')=>'js:function(){ BBiiSetting.DeleteSpider("' . $this->createAbsoluteUrl('setting/deleteSpider') .'"); }',
			Yii::t('BbiiModule.bbii', 'Save')=>'js:function(){ BBiiSetting.SaveSpider("' . $this->createAbsoluteUrl('setting/saveSpider') .'"); }',
			Yii::t('BbiiModule.bbii', 'Cancel')=>'js:function(){ $(this).dialog("close"); }',
		),
    ),
));

    echo $this->renderPartial('_editSpider', array('model'=>$model));

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

