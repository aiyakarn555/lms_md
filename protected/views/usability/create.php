<?php
/* @var $this UsabilityController */
/* @var $model Usability */

$this->breadcrumbs=array(
	'Usabilities'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Usability', 'url'=>array('index')),
	array('label'=>'Manage Usability', 'url'=>array('admin')),
);
?>

<h1>Create Usability</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>