<?php
/* @var $this CGroupquestionnaireController */
/* @var $model CGroupquestionnaire */

$this->breadcrumbs=array(
	'Cgroupquestionnaires'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CGroupquestionnaire', 'url'=>array('index')),
	array('label'=>'Manage CGroupquestionnaire', 'url'=>array('admin')),
);
?>

<h1>Create CGroupquestionnaire</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>