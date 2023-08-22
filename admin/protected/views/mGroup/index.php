<?php
/* @var $this MGroupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mgroups',
);

$this->menu=array(
	array('label'=>'Create MGroup', 'url'=>array('create')),
	array('label'=>'Manage MGroup', 'url'=>array('admin')),
);
?>

<h1>Mgroups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
