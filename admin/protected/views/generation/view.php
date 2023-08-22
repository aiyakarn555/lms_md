<?php
/* @var $this GenerationController */
/* @var $model Generation */

$this->breadcrumbs=array(
	'Generations'=>array('index'),
	$model->name,
);

/*$this->menu=array(
	array('label'=>'List Generation', 'url'=>array('index')),
	array('label'=>'Create Generation', 'url'=>array('create')),
	array('label'=>'Update Generation', 'url'=>array('update', 'id'=>$model->id_gen)),
	array('label'=>'Delete Generation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_gen),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Generation', 'url'=>array('admin')),
);*/
?>

<?php $this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_gen',
		'name',
		'start_date',
		'end_date',
		'active',
	),
)); ?>
