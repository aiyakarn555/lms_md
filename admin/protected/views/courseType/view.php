<?php
/* @var $this CourseTypeController */
/* @var $model CourseType */

$this->breadcrumbs=array(
	'Course Types'=>array('index'),
	$model->type_id,
);

$this->menu=array(
	array('label'=>'List CourseType', 'url'=>array('index')),
	array('label'=>'Create CourseType', 'url'=>array('create')),
	array('label'=>'Update CourseType', 'url'=>array('update', 'id'=>$model->type_id)),
	array('label'=>'Delete CourseType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->type_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CourseType', 'url'=>array('admin')),
);
?>

<h1>View CourseType #<?php echo $model->type_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'type_id',
		'sortOrder',
		'type_name',
		'status',
		'lang_id',
		'parent_id',
		'active',
		'created_by',
		'created_date',
		'updated_by',
		'updated_date',
	),
)); ?>
