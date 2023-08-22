<?php
/* @var $this MailuserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mailusers',
);

$this->menu=array(
	array('label'=>'Create Mailuser', 'url'=>array('create')),
	array('label'=>'Manage Mailuser', 'url'=>array('admin')),
);
?>

<h1>Mailusers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
