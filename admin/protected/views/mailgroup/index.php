<?php
/* @var $this MailgroupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mailgroups',
);

$this->menu=array(
	array('label'=>'Create Mailgroup', 'url'=>array('create')),
	array('label'=>'Manage Mailgroup', 'url'=>array('admin')),
);
?>

<h1>Mailgroups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
