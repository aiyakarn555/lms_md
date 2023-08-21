<?php
/* @var $this FaqTypeController */
/* @var $model FaqType */

$this->breadcrumbs=array(
	'Faq Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FaqType', 'url'=>array('index')),
	array('label'=>'Manage FaqType', 'url'=>array('admin')),
);
?>

<h1>Create FaqType</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>