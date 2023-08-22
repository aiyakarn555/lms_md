<?php
/* @var $this MGradingController */
/* @var $model MGrading */

$this->breadcrumbs=array(
	'Mgradings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List MGrading', 'url'=>array('index')),
	array('label'=>'Create MGrading', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#mgrading-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Mgradings</h1>

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
	'id'=>'mgrading-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'Gra_nID',
		'Gra_nScore',
		'Gra_cDetailTH',
		'Gra_cDetailEN',
		'cCreateBy',
		'dCreateDate',
		/*
		'cUpdateBy',
		'dUpdateDate',
		'cActive',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
