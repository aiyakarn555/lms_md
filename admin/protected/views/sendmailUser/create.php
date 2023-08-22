<?php
/* @var $this SendmailUserController */
/* @var $model LogSendmailUser */

$this->breadcrumbs=array(
	'Log Sendmail Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LogSendmailUser', 'url'=>array('index')),
	array('label'=>'Manage LogSendmailUser', 'url'=>array('admin')),
);
?>

<h1>Create LogSendmailUser</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>