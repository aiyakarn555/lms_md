
<?php
$this->breadcrumbs=array(
	'ระบบประเภทเอกสาร'=>array('index'),
	'แก้ไขประเภทเอกสาร',
);
?>
<?php echo $this->renderPartial('form_type', array(
	'model'=>$model,
	'file'=>$file,
	'formtext'=>'แก้ไขเประเภทเอกสาร'
)); ?>
