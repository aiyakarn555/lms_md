<?php
/* @var $this CategoryCourseController */
/* @var $model CategoryCourse */

$this->breadcrumbs=array(
	'Category Courses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CategoryCourse', 'url'=>array('index')),
	array('label'=>'Manage CategoryCourse', 'url'=>array('admin')),
);
?>

<h1>Create CategoryCourse</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>