<?php
/* @var $this MTypeanswerController */
/* @var $model MTypeanswer */

$this->breadcrumbs=array(
	'Mtypeanswers'=>array('index'),
	$model->Tan_nID=>array('view','id'=>$model->Tan_nID),
	'Update',
);

$this->menu=array(
	array('label'=>'List MTypeanswer', 'url'=>array('index')),
	array('label'=>'Create MTypeanswer', 'url'=>array('create')),
	array('label'=>'View MTypeanswer', 'url'=>array('view', 'id'=>$model->Tan_nID)),
	array('label'=>'Manage MTypeanswer', 'url'=>array('admin')),
);
?>

<h1>Update MTypeanswer <?php echo $model->Tan_nID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>