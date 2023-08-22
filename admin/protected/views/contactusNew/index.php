<?php
/* @var $this PopupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'contactnew',
);

$this->menu=array(
	array('label'=>'Create Popup', 'url'=>array('create')),
	array('label'=>'Manage Popup', 'url'=>array('admin')),
);
?>

<h1>contactnew</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
