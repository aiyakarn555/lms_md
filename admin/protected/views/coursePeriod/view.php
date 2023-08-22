<?php
/* @var $this CoursePeriodController */
/* @var $model CoursePeriod */

$this->breadcrumbs=array(
	'Course Periods'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CoursePeriod', 'url'=>array('index')),
	array('label'=>'Create CoursePeriod', 'url'=>array('create')),
	array('label'=>'Update CoursePeriod', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CoursePeriod', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CoursePeriod', 'url'=>array('admin')),
);
?>

<h1>View CoursePeriod #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_course',
		'startdate',
		'enddate',
		'hour_accounting',
		'hour_etc',
	),
)); ?>
