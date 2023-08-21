<?php
/* @var $this CpdLearningController */
/* @var $model CpdLearning */

$this->breadcrumbs=array(
	'Cpd Learnings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CpdLearning', 'url'=>array('index')),
	array('label'=>'Manage CpdLearning', 'url'=>array('admin')),
);
?>

<h1>Create CpdLearning</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>