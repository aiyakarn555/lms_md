<?php
/* @var $this ChatroomController */
/* @var $model Chatroom */

$this->breadcrumbs=array(
	'Chatrooms'=>array('index'),
	$model->room_id,
);

$this->menu=array(
	array('label'=>'List Chatroom', 'url'=>array('index')),
	array('label'=>'Create Chatroom', 'url'=>array('create')),
	array('label'=>'Update Chatroom', 'url'=>array('update', 'id'=>$model->room_id)),
	array('label'=>'Delete Chatroom', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->room_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Chatroom', 'url'=>array('admin')),
);
?>

<h1>View Chatroom #<?php echo $model->room_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'room_id',
		'room_code',
		'room_user',
	),
)); ?>
