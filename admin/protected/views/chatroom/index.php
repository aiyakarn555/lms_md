<?php
/* @var $this ChatroomController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Chatrooms',
);

$this->menu=array(
	array('label'=>'Create Chatroom', 'url'=>array('create')),
	array('label'=>'Manage Chatroom', 'url'=>array('admin')),
);
?>

<h1>Chatrooms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
