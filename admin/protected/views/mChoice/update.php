<?php
/* @var $this MChoiceController */
/* @var $model MChoice */

$this->breadcrumbs=array(
	'Mchoices'=>array('index'),
	$model->Cho_nID=>array('view','id'=>$model->Cho_nID),
	'Update',
);

$this->menu=array(
	array('label'=>'List MChoice', 'url'=>array('index')),
	array('label'=>'Create MChoice', 'url'=>array('create')),
	array('label'=>'View MChoice', 'url'=>array('view', 'id'=>$model->Cho_nID)),
	array('label'=>'Manage MChoice', 'url'=>array('admin')),
);
?>

<h1>Update MChoice <?php echo $model->Cho_nID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>