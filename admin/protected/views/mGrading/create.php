<?php
/* @var $this MGradingController */
/* @var $model MGrading */

$this->breadcrumbs=array(
	'Mgradings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MGrading', 'url'=>array('index')),
	array('label'=>'Manage MGrading', 'url'=>array('admin')),
);
?>

<h1>Create MGrading</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>