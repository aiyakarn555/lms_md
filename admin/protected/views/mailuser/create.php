<?php
/* @var $this MailuserController */
/* @var $model Mailuser */

$this->breadcrumbs=array(
	'Mailusers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Mailuser', 'url'=>array('index')),
	array('label'=>'Manage Mailuser', 'url'=>array('admin')),
);
?>

<h1>Create Mailuser</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>