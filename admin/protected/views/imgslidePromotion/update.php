
<?php
$this->breadcrumbs=array(
	'ระบบสไลด์โปรโมชั่น'=>array('index'),
	'แก้ไขสไลด์โปรโมชั่น',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขสไลด์โปรโมชั่น',
	'imageShow'=>$imageShow
)); ?>
