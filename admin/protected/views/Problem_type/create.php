
<?php
$this->breadcrumbs=array(
	'จัดการประเภทปัญหา'=>array('index'),
	'เพิ่มประเภทปัญหา',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มประเภทปัญหา'
)); ?>
