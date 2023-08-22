<?php
/* @var $this FaqTypeController */
/* @var $model FaqType */

$this->breadcrumbs=array(
	'ระบบหมวดคำถาม'=>array('index'),
	'เพิ่มหมวดคำถาม',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มหมวดคำถาม'
)); ?>