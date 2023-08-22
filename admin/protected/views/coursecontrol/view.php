<?php
/* @var $this CoursecontrolController */
/* @var $model OrgCourse */

$this->breadcrumbs=array(
	'Org Courses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List OrgCourse', 'url'=>array('index')),
	array('label'=>'Create OrgCourse', 'url'=>array('create')),
	array('label'=>'Update OrgCourse', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete OrgCourse', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage OrgCourse', 'url'=>array('admin')),
);
?>

<h1>View OrgCourse #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'orgchart_id',
		'course_id',
		'active',
	),
)); ?>
