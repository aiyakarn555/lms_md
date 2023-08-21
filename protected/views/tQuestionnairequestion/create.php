<?php
/* @var $this TQuestionnairequestionController */
/* @var $model TQuestionnairequestion */

$this->breadcrumbs=array(
	'Tquestionnairequestions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TQuestionnairequestion', 'url'=>array('index')),
	array('label'=>'Manage TQuestionnairequestion', 'url'=>array('admin')),
);
?>

<h1>Create TQuestionnairequestion</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>