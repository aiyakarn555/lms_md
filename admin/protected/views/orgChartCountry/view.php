<?php
/* @var $this OrgChartController */
/* @var $model OrgChart */

$this->breadcrumbs=array(
	'Org Charts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OrgChart', 'url'=>array('index')),
	array('label'=>'Create OrgChart', 'url'=>array('create')),
	array('label'=>'Update OrgChart', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OrgChart', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OrgChart', 'url'=>array('admin')),
);
?>

<h1>View OrgChart #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'root',
		'lft',
		'rgt',
		'level',
	),
)); ?>
