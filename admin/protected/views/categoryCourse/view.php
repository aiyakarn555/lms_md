<?php
/* @var $this CategoryCourseController */
/* @var $model CategoryCourse */

$this->breadcrumbs=array(
	'Category Courses'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CategoryCourse', 'url'=>array('index')),
	array('label'=>'Create CategoryCourse', 'url'=>array('create')),
	array('label'=>'Update CategoryCourse', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CategoryCourse', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CategoryCourse', 'url'=>array('admin')),
);
?>

<h1>View CategoryCourse #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cate_id',
		'name',
		'pic',
		'create_at',
		'create_by',
		'update_at',
		'update_by',
		'active',
	),
)); ?>
