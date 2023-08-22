<?php
/* @var $this MSubchoiceController */
/* @var $model MSubchoice */

$this->breadcrumbs=array(
	'Msubchoices'=>array('index'),
	$model->Sch_nID=>array('view','id'=>$model->Sch_nID),
	'Update',
);

$this->menu=array(
	array('label'=>'List MSubchoice', 'url'=>array('index')),
	array('label'=>'Create MSubchoice', 'url'=>array('create')),
	array('label'=>'View MSubchoice', 'url'=>array('view', 'id'=>$model->Sch_nID)),
	array('label'=>'Manage MSubchoice', 'url'=>array('admin')),
);
?>

<h1>Update MSubchoice <?php echo $model->Sch_nID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>