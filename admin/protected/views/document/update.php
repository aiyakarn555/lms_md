
<?php
$this->breadcrumbs=array(
	'ระบบหมวดเอกสาร'=>array('index'),
	'แก้ไขเอกสาร',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'file'=>$file,
	'formtext'=>'แก้ไขเอกสาร',
	'imageShow'=>$imageShow
)); ?>
