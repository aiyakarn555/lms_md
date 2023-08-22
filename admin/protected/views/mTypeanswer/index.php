<?php
/* @var $this MTypeanswerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mtypeanswers',
);

$this->menu=array(
	array('label'=>'Create MTypeanswer', 'url'=>array('create')),
	array('label'=>'Manage MTypeanswer', 'url'=>array('admin')),
);
?>

<h1>Mtypeanswers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
