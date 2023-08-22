<?php
/* @var $this MGroupController */
/* @var $model MGroup */

$this->breadcrumbs=array(
	'Mgroups'=>array('index'),
	$model->Gro_nID=>array('view','id'=>$model->Gro_nID),
	'Update',
);

$this->menu=array(
	array('label'=>'List MGroup', 'url'=>array('index')),
	array('label'=>'Create MGroup', 'url'=>array('create')),
	array('label'=>'View MGroup', 'url'=>array('view', 'id'=>$model->Gro_nID)),
	array('label'=>'Manage MGroup', 'url'=>array('admin')),
);
?>

<h1>Update MGroup <?php echo $model->Gro_nID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>