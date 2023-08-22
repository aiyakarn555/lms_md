
<?php
$this->breadcrumbs=array(
	'ประเภทห้องสมุด'=>array('index'),
	'แก้ไขประเภทห้องสมุด',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขประเภทห้องสมุด'
)); ?>
