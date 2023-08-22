<?php
/* @var $this SendmailUserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Log Sendmail Users',
);

$this->menu=array(
	array('label'=>'Create LogSendmailUser', 'url'=>array('create')),
	array('label'=>'Manage LogSendmailUser', 'url'=>array('admin')),
);
?>

<h1>Log Sendmail Users</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
