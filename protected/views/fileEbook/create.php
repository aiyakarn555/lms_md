<?php
/* @var $this FileEbookController */
/* @var $model FileEbook */

$this->breadcrumbs=array(
	'File Ebooks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List FileEbook', 'url'=>array('index')),
	array('label'=>'Manage FileEbook', 'url'=>array('admin')),
);
?>

<h1>Create FileEbook</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>