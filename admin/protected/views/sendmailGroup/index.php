<?php
/* @var $this SendmailGroupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Log Sendmail Groups',
);

$this->menu=array(
	array('label'=>'Create LogSendmailGroup', 'url'=>array('create')),
	array('label'=>'Manage LogSendmailGroup', 'url'=>array('admin')),
);
?>

<h1>Log Sendmail Groups</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
