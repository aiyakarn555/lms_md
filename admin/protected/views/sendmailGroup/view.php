<?php
/* @var $this SendmailGroupController */
/* @var $model LogSendmailGroup */

$this->breadcrumbs=array(
	'Log Sendmail Groups'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List LogSendmailGroup', 'url'=>array('index')),
	array('label'=>'Create LogSendmailGroup', 'url'=>array('create')),
	array('label'=>'Update LogSendmailGroup', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete LogSendmailGroup', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LogSendmailGroup', 'url'=>array('admin')),
);
?>

<h1>View LogSendmailGroup #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'group_id',
		'detail_id',
		'status',
	),
)); ?>
