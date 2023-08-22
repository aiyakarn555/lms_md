<?php
/* @var $this MTitlequestionController */
/* @var $model MTitlequestion */

$this->breadcrumbs=array(
	'Mtitlequestions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MTitlequestion', 'url'=>array('index')),
	array('label'=>'Manage MTitlequestion', 'url'=>array('admin')),
);
?>

<h1>Create MTitlequestion</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>