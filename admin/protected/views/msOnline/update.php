
<?php
$this->breadcrumbs=array(
	'ระบบห้องสอบออนไลน์'=>array('index'),
	'แก้ไขห้องสอบออนไลน์',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขห้องสอบออนไลน์',
	'imageShow'=>$imageShow
)); ?>
