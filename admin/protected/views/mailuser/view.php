<?php
/* @var $this MailuserController */
/* @var $model Mailuser */

$this->breadcrumbs=array(
	'Mailusers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Mailuser', 'url'=>array('index')),
	array('label'=>'Create Mailuser', 'url'=>array('create')),
	array('label'=>'Update Mailuser', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Mailuser', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Mailuser', 'url'=>array('admin')),
);
?>

<h1>View Mailuser #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'group_id',
		'user_id',
	),
)); ?>
