<?php
/* @var $this CategoryCourseController */
/* @var $model CategoryCourse */

$this->breadcrumbs=array(
	'Category Courses'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CategoryCourse', 'url'=>array('index')),
	array('label'=>'Create CategoryCourse', 'url'=>array('create')),
	array('label'=>'View CategoryCourse', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CategoryCourse', 'url'=>array('admin')),
);
?>

<h1>Update CategoryCourse <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>