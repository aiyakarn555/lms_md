<?php
/* @var $this FaqTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Faq Types',
);

$this->menu=array(
	array('label'=>'Create FaqType', 'url'=>array('create')),
	array('label'=>'Manage FaqType', 'url'=>array('admin')),
);
?>

<h1>Faq Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
