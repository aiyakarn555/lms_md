<?php
/* @var $this DivisionController */
/* @var $model Division */

$this->breadcrumbs=array(
	'แผนก'=>array('admin'),
	'สร้าง',
);


?>

<?php $this->renderPartial('_form', array('model'=>$model,'formtext'=>'เพิ่มแผนก')); ?>