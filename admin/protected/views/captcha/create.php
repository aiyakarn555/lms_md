<?php
/* @var $this ConfigCaptchaController */
/* @var $model ConfigCaptcha */

$this->breadcrumbs=array(
	'Config Captchas'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List ConfigCaptcha', 'url'=>array('index')),
	array('label'=>'Manage ConfigCaptcha', 'url'=>array('admin')),
);*/
?>

<!-- <h1>Create ConfigCaptcha</h1> -->
<?php $this->renderPartial('_form', array('model'=>$model, 'cap'=>$cap, 'formtext'=>"เพิ่มแคปช่า")); ?>