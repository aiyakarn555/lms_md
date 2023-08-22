<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->breadcrumbs=array(
	'ระบบคำถามที่พบบ่อย'=>array('index'),
	'แก้ไขคำถามที่พบบ่อย',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขคำถามที่พบบ่อย',
)); ?>