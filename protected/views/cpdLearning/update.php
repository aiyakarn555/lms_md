<?php
/* @var $this CpdLearningController */
/* @var $model CpdLearning */

$this->breadcrumbs=array(
	'Cpd Learnings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CpdLearning', 'url'=>array('index')),
	array('label'=>'Create CpdLearning', 'url'=>array('create')),
	array('label'=>'View CpdLearning', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CpdLearning', 'url'=>array('admin')),
);
?>

<h1>Update CpdLearning <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>