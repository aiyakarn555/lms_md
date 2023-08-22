<?php
/* @var $this MGroupController */
/* @var $model MGroup */

$this->breadcrumbs=array(
	'Mgroups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MGroup', 'url'=>array('index')),
	array('label'=>'Manage MGroup', 'url'=>array('admin')),
);
?>

<h1>Create MGroup</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>