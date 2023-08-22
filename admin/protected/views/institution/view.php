<?php
/* @var $this InstitutionController */
/* @var $model Institution */

$this->breadcrumbs=array(
	'Institutions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Institution', 'url'=>array('index')),
	array('label'=>'Create Institution', 'url'=>array('create')),
	array('label'=>'Update Institution', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Institution', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Institution', 'url'=>array('admin')),
);
?>

<h1>View Institution #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'institution_name',
		'code',
		'active',
		'create_date',
		'create_by',
		'update_date',
		'update_by',
	),
)); ?>
