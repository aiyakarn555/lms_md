<?php
/* @var $this CourseSampleController */
/* @var $model CourseSample */

$this->breadcrumbs=array(
	'Course Samples'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CourseSample', 'url'=>array('index')),
	array('label'=>'Create CourseSample', 'url'=>array('create')),
	array('label'=>'View CourseSample', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CourseSample', 'url'=>array('admin')),
);
?>

<h1>Update CourseSample <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>