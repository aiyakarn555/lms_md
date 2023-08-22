<?php
/* @var $this ManageController */
/* @var $model Manage */

$this->breadcrumbs=array(
	'Manages'=>array('index'),
	$model->manage_id,
);

$this->menu=array(
	array('label'=>'List Manage', 'url'=>array('index')),
	array('label'=>'Create Manage', 'url'=>array('create')),
	array('label'=>'Update Manage', 'url'=>array('update', 'id'=>$model->manage_id)),
	array('label'=>'Delete Manage', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->manage_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Manage', 'url'=>array('admin')),
);
?>

<h1>View Manage #<?php echo $model->manage_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'manage_id',
		'id',
		'group_id',
		'manage_row',
		'create_date',
		'create_by',
		'update_date',
		'update_by',
		'active',
	),
)); ?>
