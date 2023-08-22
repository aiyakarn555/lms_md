
<?php
$this->breadcrumbs=array(
	'ระบบประเภทเอกสาร'=>array('Index_type'),
	'เพิ่มประเภทเอกสาร',
);
?>
<?php echo $this->renderPartial('form_type', array(
	'model'=>$model,
	'file'=>$file,
	'formtext'=>'เพิ่มประเภทเอกสาร'
)); ?>
