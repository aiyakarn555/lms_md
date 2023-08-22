<?php
/* @var $this FeaturedLinksController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Featured Links',
);

$this->menu=array(
	array('label'=>'Create FeaturedLinks', 'url'=>array('create')),
	array('label'=>'Manage FeaturedLinks', 'url'=>array('admin')),
);
?>

<h1>Featured Links</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
