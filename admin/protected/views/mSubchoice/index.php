<?php
/* @var $this MSubchoiceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Msubchoices',
);

$this->menu=array(
	array('label'=>'Create MSubchoice', 'url'=>array('create')),
	array('label'=>'Manage MSubchoice', 'url'=>array('admin')),
);
?>

<h1>Msubchoices</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
