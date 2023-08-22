<?php
/* @var $this MSumquestionnaireController */
/* @var $model MSumquestionnaire */

$this->breadcrumbs=array(
	'Msumquestionnaires'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MSumquestionnaire', 'url'=>array('index')),
	array('label'=>'Manage MSumquestionnaire', 'url'=>array('admin')),
);
?>

<h1>Create MSumquestionnaire</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>