<?php
/* @var $this UsabilityController */
/* @var $model Usability */

$this->breadcrumbs=array(
	'Usabilities'=>array('index'),
	$model->usa_id=>array('view','id'=>$model->usa_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Usability', 'url'=>array('index')),
	array('label'=>'Create Usability', 'url'=>array('create')),
	array('label'=>'View Usability', 'url'=>array('view', 'id'=>$model->usa_id)),
	array('label'=>'Manage Usability', 'url'=>array('admin')),
);
?>

<h1>Update Usability <?php echo $model->usa_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>