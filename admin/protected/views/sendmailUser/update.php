<?php
/* @var $this SendmailUserController */
/* @var $model LogSendmailUser */

$this->breadcrumbs=array(
	'Log Sendmail Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LogSendmailUser', 'url'=>array('index')),
	array('label'=>'Create LogSendmailUser', 'url'=>array('create')),
	array('label'=>'View LogSendmailUser', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LogSendmailUser', 'url'=>array('admin')),
);
?>

<h1>Update LogSendmailUser <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>