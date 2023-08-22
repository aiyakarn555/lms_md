
<?php
$this->breadcrumbs=array(
	'ระบบห้องเรียนออนไลน์'=>array('index'),
	'แก้ไขห้องเรียนออนไลน์',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขห้องเรียนออนไลน์',
	'imageShow'=>$imageShow
)); ?>
