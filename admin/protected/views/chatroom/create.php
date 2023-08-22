<?php
/* @var $this ChatroomController */
/* @var $model Chatroom */

$this->breadcrumbs=array(
	'Chatrooms'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Chatroom', 'url'=>array('index')),
	array('label'=>'Manage Chatroom', 'url'=>array('admin')),
);
?>

<h1>Create Chatroom</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>