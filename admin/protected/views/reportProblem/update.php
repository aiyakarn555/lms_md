<?php
/* @var $this ReportProblemController */
/* @var $model ReportProblem */

$this->breadcrumbs=array(
	'Report Problems'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ReportProblem', 'url'=>array('index')),
	array('label'=>'Create ReportProblem', 'url'=>array('create')),
	array('label'=>'View ReportProblem', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ReportProblem', 'url'=>array('admin')),
);
?>

<h1>Update ReportProblem <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>