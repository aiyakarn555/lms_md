<?php
/* @var $this ManageController */
/* @var $model Manage */

$this->breadcrumbs=array(
	'Manages'=>array('index'),
	$model->manage_id=>array('view','id'=>$model->manage_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Manage', 'url'=>array('index')),
	array('label'=>'Create Manage', 'url'=>array('create')),
	array('label'=>'View Manage', 'url'=>array('view', 'id'=>$model->manage_id)),
	array('label'=>'Manage Manage', 'url'=>array('admin')),
);
?>

<h1>Update Manage <?php echo $model->manage_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>