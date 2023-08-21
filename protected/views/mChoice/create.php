<?php
/* @var $this MChoiceController */
/* @var $model MChoice */

$this->breadcrumbs=array(
	'Mchoices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MChoice', 'url'=>array('index')),
	array('label'=>'Manage MChoice', 'url'=>array('admin')),
);
?>

<h1>Create MChoice</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>