<?php
/* @var $this ReportProblemController */
/* @var $model ReportProblem */

$this->breadcrumbs=array(
	'จัดการปัญหาการใช้งาน'=>array('index'),
	// $model->id=>array('view','id'=>$model->id),
	'ตอบกลับ',
);

// $this->menu=array(
// 	array('label'=>'List ReportProblem', 'url'=>array('index')),
// 	array('label'=>'Create ReportProblem', 'url'=>array('create')),
// 	array('label'=>'View ReportProblem', 'url'=>array('view', 'id'=>$model->id)),
// 	array('label'=>'Manage ReportProblem', 'url'=>array('admin')),
// );
?>

<h1>ตอบกลับปัญหา </h1>

<?php $this->renderPartial('_form-accept', array('model'=>$model)); ?>