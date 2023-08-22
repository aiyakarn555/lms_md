<?php
/* @var $this MGradingController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mgradings',
);

$this->menu=array(
	array('label'=>'Create MGrading', 'url'=>array('create')),
	array('label'=>'Manage MGrading', 'url'=>array('admin')),
);
?>

<h1>Mgradings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
