<?php
/* @var $this CompanyController */
/* @var $model Company */

$this->breadcrumbs=array(
	'ฝ่าย'=>array('admin'),
	'สร้างฝ่าย',
);

// $this->menu=array(
// 	array('label'=>'List Company', 'url'=>array('index')),
// 	array('label'=>'Manage Company', 'url'=>array('admin')),
// );
?>

<?php $this->renderPartial('_form', array('model'=>$model,'formtext'=>'เพิ่มฝ่าย')); ?>