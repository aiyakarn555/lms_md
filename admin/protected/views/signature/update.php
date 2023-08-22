<?php
$this->breadcrumbs=array(
	'ระบบลายเซนต์'=>array('index'),
	'แก้ไขลายเซนต์',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไข ลายเซนต์',
)); ?>

