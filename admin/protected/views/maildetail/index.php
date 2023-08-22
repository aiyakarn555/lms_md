<?php
/* @var $this MaildetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Maildetails',
);

$this->menu=array(
	array('label'=>'Create Maildetail', 'url'=>array('create')),
	array('label'=>'Manage Maildetail', 'url'=>array('admin')),
);
?>

<h1>Maildetails</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
