<?php
/* @var $this ReportProblemController */
/* @var $model ReportProblem */

$this->breadcrumbs=array(
	'Report Problems'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ReportProblem', 'url'=>array('index')),
	array('label'=>'Create ReportProblem', 'url'=>array('create')),
	array('label'=>'Update ReportProblem', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ReportProblem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ReportProblem', 'url'=>array('admin')),
);
?>

<h1>View ReportProblem #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'firstname',
		'lastname',
		'email',
		'tel',
		'report_type',
		'report_title',
		'report_detail',
		'report_pic',
	),
)); ?>
