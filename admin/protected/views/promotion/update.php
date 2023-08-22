
<?php
$this->breadcrumbs=array(
	'ระบบโปรโมชั่น'=>array('index'),
	'แก้ไขโปรโมชั่น',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขโปรโมชั่น',
	'imageShow'=>$imageShow
)); ?>
