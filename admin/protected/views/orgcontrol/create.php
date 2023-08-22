<?php
/* @var $this OrgcontrolController */
/* @var $model OrgDepart */

$this->breadcrumbs=array(
	'Org Departs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OrgDepart', 'url'=>array('index')),
	array('label'=>'Manage OrgDepart', 'url'=>array('admin')),
);
?>

<h1>Create OrgDepart</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>