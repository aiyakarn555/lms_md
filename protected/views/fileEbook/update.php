<?php
/* @var $this FileEbookController */
/* @var $model FileEbook */

$this->breadcrumbs=array(
	'File Ebooks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FileEbook', 'url'=>array('index')),
	array('label'=>'Create FileEbook', 'url'=>array('create')),
	array('label'=>'View FileEbook', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage FileEbook', 'url'=>array('admin')),
);
?>

<h1>Update FileEbook <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>