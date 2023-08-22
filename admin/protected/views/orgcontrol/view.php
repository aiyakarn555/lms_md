<?php
/* @var $this OrgcontrolController */
/* @var $model OrgDepart */

$this->breadcrumbs=array(
	'Org Departs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OrgDepart', 'url'=>array('index')),
	array('label'=>'Create OrgDepart', 'url'=>array('create')),
	array('label'=>'Update OrgDepart', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OrgDepart', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OrgDepart', 'url'=>array('admin')),
);
?>

<h1>View OrgDepart #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'orgchart_id',
		'depart_id',
		'parent_id',
		'order',
		'active',
	),
)); ?>
