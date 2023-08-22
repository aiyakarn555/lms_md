<?php
/* @var $this ManageController */
/* @var $model Manage */

$this->breadcrumbs=array(
	'จัดการเลือกข้อสอบ'=>array('index'),
	'เพิ่มการเลือกข้อสอบ',
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'formtext'=>'เพิ่มการเลือกข้อสอบ')); ?>