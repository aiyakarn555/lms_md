
<?php
$this->breadcrumbs=array(
	'จัดการประเภทปัญหา'=>array('index'),
	'แก้ไขประเภทปัญหา',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขประเภทปัญหา'
)); ?>
