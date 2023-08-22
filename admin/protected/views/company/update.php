<?php
/* @var $this CompanyController */
/* @var $model Company */
$formtext = 'จัดการฝ่าย';
$this->breadcrumbs=array(
	'จัดการฝ่าย'=>array('admin'),
	'Update',
);


?>

<?php $this->renderPartial('_form', array('model'=>$model,'formtext'=>$formtext)); ?>