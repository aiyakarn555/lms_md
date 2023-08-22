<?php
/* @var $this StationController */
/* @var $model Station */

$this->breadcrumbs=array(
	'Stations'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Station', 'url'=>array('index')),
	array('label'=>'Manage Station', 'url'=>array('admin')),
);
?>

<h1>Create Station</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>