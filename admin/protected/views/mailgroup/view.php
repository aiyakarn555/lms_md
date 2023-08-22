<?php
/* @var $this MailgroupController */
/* @var $model Mailgroup */

$this->breadcrumbs=array(
	'Mailgroups'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Mailgroup', 'url'=>array('index')),
	array('label'=>'Create Mailgroup', 'url'=>array('create')),
	array('label'=>'Update Mailgroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Mailgroup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Mailgroup', 'url'=>array('admin')),
);
?>

<h1>View Mailgroup #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'group_name',
		'create_date',
		'active',
	),
)); ?>
