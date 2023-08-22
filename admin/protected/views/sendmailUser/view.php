<?php
/* @var $this SendmailUserController */
/* @var $model LogSendmailUser */

$this->breadcrumbs=array(
	'Log Sendmail Users'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LogSendmailUser', 'url'=>array('index')),
	array('label'=>'Create LogSendmailUser', 'url'=>array('create')),
	array('label'=>'Update LogSendmailUser', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LogSendmailUser', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LogSendmailUser', 'url'=>array('admin')),
);
?>

<h1>View LogSendmailUser #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'detail_id',
		'status',
	),
)); ?>
