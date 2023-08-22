<?php
/* @var $this CourseSampleController */
/* @var $model CourseSample */

$this->breadcrumbs=array(
	'Course Samples'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CourseSample', 'url'=>array('index')),
	array('label'=>'Create CourseSample', 'url'=>array('create')),
	array('label'=>'Update CourseSample', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CourseSample', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CourseSample', 'url'=>array('admin')),
);
?>

<h1>View CourseSample #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sample_name',
		'sample_detail',
		'file',
		'active',
		'create_date',
		'update_date',
	),
)); ?>
