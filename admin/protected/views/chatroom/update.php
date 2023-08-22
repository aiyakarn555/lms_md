<?php
/* @var $this ChatroomController */
/* @var $model Chatroom */

$this->breadcrumbs=array(
	'Chatrooms'=>array('index'),
	$model->room_id=>array('view','id'=>$model->room_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Chatroom', 'url'=>array('index')),
	array('label'=>'Create Chatroom', 'url'=>array('create')),
	array('label'=>'View Chatroom', 'url'=>array('view', 'id'=>$model->room_id)),
	array('label'=>'Manage Chatroom', 'url'=>array('admin')),
);
?>

<h1>Update Chatroom <?php echo $model->room_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>