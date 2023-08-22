<?php
/* @var $this ConfigCaptchaController */
/* @var $model ConfigCaptcha */

$this->breadcrumbs=array(
	'Config Captchas'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ConfigCaptcha', 'url'=>array('index')),
	array('label'=>'Create ConfigCaptcha', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#config-captcha-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Config Captchas</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'config-captcha-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'capid',
		'cid',
		'lid',
		'capt_name',
		'capt_time_random',
		'capt_time_back',
		/*
		'capt_times',
		'capt_hide',
		'capt_active',
		'created_by',
		'created_date',
		'updated_by',
		'updated_date',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
