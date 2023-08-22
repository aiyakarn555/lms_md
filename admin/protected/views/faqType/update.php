<?php
/* @var $this FaqTypeController */
/* @var $model FaqType */

$this->breadcrumbs=array(
	'ระบบหมวดคำถาม'=>array('index'),
	'แก้ไขหมวดคำถาม',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขหมวดคำถาม',
)); ?>