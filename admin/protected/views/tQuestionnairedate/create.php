<?php
/* @var $this TQuestionnairedateController */
/* @var $model TQuestionnairedate */

$this->breadcrumbs=array(
	'Tquestionnairedates'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TQuestionnairedate', 'url'=>array('index')),
	array('label'=>'Manage TQuestionnairedate', 'url'=>array('admin')),
);
?>

<h1>Create TQuestionnairedate</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>