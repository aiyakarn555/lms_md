
<?php
$this->breadcrumbs=array(
	'ห้องเรียนออนไลน์(สถาบัน)'=>array('index'),
	'แก้ไขห้องเรียนออนไลน์(สถาบัน)',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขห้องเรียนออนไลน์(สถาบัน)',
	'imageShow'=>$imageShow
)); ?>
