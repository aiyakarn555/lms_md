<?php
/* @var $this TAnswerquestionnaireController */
/* @var $model TAnswerquestionnaire */

$this->breadcrumbs=array(
	'Tanswerquestionnaires'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TAnswerquestionnaire', 'url'=>array('index')),
	array('label'=>'Manage TAnswerquestionnaire', 'url'=>array('admin')),
);
?>

<h1>Create TAnswerquestionnaire</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>