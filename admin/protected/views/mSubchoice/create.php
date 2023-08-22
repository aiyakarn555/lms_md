<?php
/* @var $this MSubchoiceController */
/* @var $model MSubchoice */

$this->breadcrumbs=array(
	'Msubchoices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MSubchoice', 'url'=>array('index')),
	array('label'=>'Manage MSubchoice', 'url'=>array('admin')),
);
?>

<h1>Create MSubchoice</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>