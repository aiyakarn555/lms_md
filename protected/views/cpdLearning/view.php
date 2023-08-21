<?php
/* @var $this CpdLearningController */
/* @var $model CpdLearning */

$this->breadcrumbs=array(
	'Cpd Learnings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CpdLearning', 'url'=>array('index')),
	array('label'=>'Create CpdLearning', 'url'=>array('create')),
	array('label'=>'Update CpdLearning', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CpdLearning', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CpdLearning', 'url'=>array('admin')),
);
?>

<h1>View CpdLearning #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'course_id',
		'pic_id_card',
		'create_date',
	),
)); ?>
