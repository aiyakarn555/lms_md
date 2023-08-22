<?php
/* @var $this CourseNotificationController */
/* @var $model CourseNotification */

$this->breadcrumbs=array(
	'Course Notifications'=>array('index'),
	$model->id,
);

// $this->menu=array(
// 	array('label'=>'List CourseNotification', 'url'=>array('index')),
// 	array('label'=>'Create CourseNotification', 'url'=>array('create')),
// 	array('label'=>'Update CourseNotification', 'url'=>array('update', 'id'=>$model->id)),
// 	array('label'=>'Delete CourseNotification', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage CourseNotification', 'url'=>array('admin')),
// );
?>

<h1>CourseNotification </h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		// 'id',
		array(
			'name'=>'course_id',
			'value'=> $model->courses->course_title
		),
		// 'course_id',
		// 'generation_id',
		'notification_time',
		'create_date',
		array(
			'name'=>'create_by',
			'value'=>$model->usercreate->username
		),
		'update_date',
		array(
			'name'=>'update_by',
			'value'=>$model->userupdate->username
		),
		// 'active',
	),
)); ?>
