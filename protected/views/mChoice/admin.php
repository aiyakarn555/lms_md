<?php
/* @var $this MChoiceController */
/* @var $model MChoice */

$this->breadcrumbs=array(
	'Mchoices'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List MChoice', 'url'=>array('index')),
	array('label'=>'Create MChoice', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#mchoice-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Mchoices</h1>

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
	'id'=>'mchoice-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'Cho_nID',
		'Cho_cNameTH',
		'Cho_cNameEN',
		'Cho_nScore',
		'stat_txt',
		'cCreateBy',
		/*
		'dCreateDate',
		'cUpdateBy',
		'dUpdateDate',
		'cActive',
		'Tan_nID',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
