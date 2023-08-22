<?php
/* @var $this ReportProblemController */
/* @var $model ReportProblem */

$this->breadcrumbs=array(
	'Report Problems'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ReportProblem', 'url'=>array('index')),
	array('label'=>'Manage ReportProblem', 'url'=>array('admin')),
);
?>

<h1>Create ReportProblem</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>