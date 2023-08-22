<?php
/* @var $this CategoryCourseController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Category Courses',
);

$this->menu=array(
	array('label'=>'Create CategoryCourse', 'url'=>array('create')),
	array('label'=>'Manage CategoryCourse', 'url'=>array('admin')),
);
?>

<h1>Category Courses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
