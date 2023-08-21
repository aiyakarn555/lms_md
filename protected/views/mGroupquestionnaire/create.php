<?php
/* @var $this MGroupquestionnaireController */
/* @var $model MGroupquestionnaire */

$this->breadcrumbs=array(
	'Mgroupquestionnaires'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MGroupquestionnaire', 'url'=>array('index')),
	array('label'=>'Manage MGroupquestionnaire', 'url'=>array('admin')),
);
?>

<h1>Create MGroupquestionnaire</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>