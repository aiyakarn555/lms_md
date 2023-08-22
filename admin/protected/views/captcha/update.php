<?php
/* @var $this ConfigCaptchaController */
/* @var $model ConfigCaptcha */

$this->breadcrumbs=array(
	'Config Captchas'=>array('index'),
	$model->capid=>array('view','id'=>$model->capid),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List ConfigCaptcha', 'url'=>array('index')),
	array('label'=>'Create ConfigCaptcha', 'url'=>array('create')),
	array('label'=>'View ConfigCaptcha', 'url'=>array('view', 'id'=>$model->capid)),
	array('label'=>'Manage ConfigCaptcha', 'url'=>array('admin')),
);*/
?>

<!-- <h1>Update ConfigCaptcha <?php echo $model->capid; ?></h1> -->

<?php $this->renderPartial('_form', array('model'=>$model,'cap'=>$cap,'FormText'=>"แก้ไขแคปช่า")); ?>