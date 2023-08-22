<?php
/* @var $this StationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Stations',
);

$this->menu=array(
	array('label'=>'Create Station', 'url'=>array('create')),
	array('label'=>'Manage Station', 'url'=>array('admin')),
);
?>

<h1>Stations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
