<?php
/* @var $this MQuestionController */
/* @var $model MQuestion */

$this->breadcrumbs=array(
	'Mquestions'=>array('index'),
	$model->Que_nID=>array('view','id'=>$model->Que_nID),
	'Update',
);

$this->menu=array(
	array('label'=>'List MQuestion', 'url'=>array('index')),
	array('label'=>'Create MQuestion', 'url'=>array('create')),
	array('label'=>'View MQuestion', 'url'=>array('view', 'id'=>$model->Que_nID)),
	array('label'=>'Manage MQuestion', 'url'=>array('admin')),
);
?>

<h1>Update MQuestion <?php echo $model->Que_nID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>