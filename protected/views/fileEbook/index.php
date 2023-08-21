<?php
/* @var $this FileEbookController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'File Ebooks',
);

$this->menu=array(
	array('label'=>'Create FileEbook', 'url'=>array('create')),
	array('label'=>'Manage FileEbook', 'url'=>array('admin')),
);
?>

<h1>File Ebooks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
