<?php
/* @var $this MGroupController */
/* @var $model MGroup */

$this->breadcrumbs=array(
	'Mgroups'=>array('index'),
	$model->Gro_nID,
);

$this->menu=array(
	array('label'=>'List MGroup', 'url'=>array('index')),
	array('label'=>'Create MGroup', 'url'=>array('create')),
	array('label'=>'Update MGroup', 'url'=>array('update', 'id'=>$model->Gro_nID)),
	array('label'=>'Delete MGroup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Gro_nID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MGroup', 'url'=>array('admin')),
);
?>

<h1>View MGroup #<?php echo $model->Gro_nID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Gro_nID',
		'cCreateBy',
		'dCreateDate',
		'cUpdateBy',
		'cUpdateDate',
		'cActive',
		'Gna_nID',
		'Sna_nID',
	),
)); ?>
