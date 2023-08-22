<?php
/* @var $this CoursePeriodController */
/* @var $model CoursePeriod */

$this->breadcrumbs=array(
	'Course Periods'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CoursePeriod', 'url'=>array('index')),
	array('label'=>'Create CoursePeriod', 'url'=>array('create')),
	array('label'=>'View CoursePeriod', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CoursePeriod', 'url'=>array('admin')),
);
?>

<h1>Update CoursePeriod <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>