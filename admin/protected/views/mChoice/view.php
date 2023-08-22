<?php
/* @var $this MChoiceController */
/* @var $model MChoice */

$this->breadcrumbs=array(
	'Mchoices'=>array('index'),
	$model->Cho_nID,
);

$this->menu=array(
	array('label'=>'List MChoice', 'url'=>array('index')),
	array('label'=>'Create MChoice', 'url'=>array('create')),
	array('label'=>'Update MChoice', 'url'=>array('update', 'id'=>$model->Cho_nID)),
	array('label'=>'Delete MChoice', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Cho_nID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MChoice', 'url'=>array('admin')),
);
?>

<h1>View MChoice #<?php echo $model->Cho_nID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Cho_nID',
		'Cho_cNameTH',
		'Cho_cNameEN',
		'Cho_nScore',
		'stat_txt',
		'cCreateBy',
		'dCreateDate',
		'cUpdateBy',
		'dUpdateDate',
		'cActive',
		'Tan_nID',
	),
)); ?>
