<?php
/* @var $this OrgChartController */
/* @var $model OrgChart */

$this->breadcrumbs=array(
	'Org Charts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OrgChart', 'url'=>array('index')),
	array('label'=>'Manage OrgChart', 'url'=>array('admin')),
);
?>

<h1>Create OrgChart</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>