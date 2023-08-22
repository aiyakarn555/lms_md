<?php
/* @var $this FormSurveyController */
/* @var $model FormSurvey */

$this->breadcrumbs=array(
	'Form Surveys'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FormSurvey', 'url'=>array('index')),
	array('label'=>'Manage FormSurvey', 'url'=>array('admin')),
);
?>

<h1>Create FormSurvey</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'formtext'=>'สร้างแบบสอบถาม')); ?>