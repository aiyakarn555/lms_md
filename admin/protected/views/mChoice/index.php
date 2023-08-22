<?php
/* @var $this MChoiceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mchoices',
);

$this->menu=array(
	array('label'=>'Create MChoice', 'url'=>array('create')),
	array('label'=>'Manage MChoice', 'url'=>array('admin')),
);
?>

<h1>Mchoices</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
