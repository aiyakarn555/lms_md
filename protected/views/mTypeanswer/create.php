<?php
/* @var $this MTypeanswerController */
/* @var $model MTypeanswer */

$this->breadcrumbs=array(
	'Mtypeanswers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MTypeanswer', 'url'=>array('index')),
	array('label'=>'Manage MTypeanswer', 'url'=>array('admin')),
);
?>

<h1>Create MTypeanswer</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>