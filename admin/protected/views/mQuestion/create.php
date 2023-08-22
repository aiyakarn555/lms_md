<?php
/* @var $this MQuestionController */
/* @var $model MQuestion */

$this->breadcrumbs=array(
	'Mquestions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MQuestion', 'url'=>array('index')),
	array('label'=>'Manage MQuestion', 'url'=>array('admin')),
);
?>

<h1>Create MQuestion</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>