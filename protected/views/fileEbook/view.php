<?php
/* @var $this FileEbookController */
/* @var $model FileEbook */

$this->breadcrumbs=array(
	'File Ebooks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List FileEbook', 'url'=>array('index')),
	array('label'=>'Create FileEbook', 'url'=>array('create')),
	array('label'=>'Update FileEbook', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete FileEbook', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FileEbook', 'url'=>array('admin')),
);
?>

<h1>View FileEbook #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'lesson_id',
		'file_name',
		'filename',
		'length',
		'file_position',
		'create_date',
		'create_by',
		'update_date',
		'update_by',
		'active',
	),
)); ?>
