<?php
/* @var $this MailuserController */
/* @var $model Mailuser */

$this->breadcrumbs=array(
	'Mailusers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Mailuser', 'url'=>array('index')),
	array('label'=>'Create Mailuser', 'url'=>array('create')),
	array('label'=>'View Mailuser', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Mailuser', 'url'=>array('admin')),
);
?>

<h1>Update Mailuser <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>