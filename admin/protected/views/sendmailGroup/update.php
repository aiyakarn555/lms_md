<?php
/* @var $this SendmailGroupController */
/* @var $model LogSendmailGroup */

$this->breadcrumbs=array(
	'Log Sendmail Groups'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LogSendmailGroup', 'url'=>array('index')),
	array('label'=>'Create LogSendmailGroup', 'url'=>array('create')),
	array('label'=>'View LogSendmailGroup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LogSendmailGroup', 'url'=>array('admin')),
);
?>

<h1>Update LogSendmailGroup <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>