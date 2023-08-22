
<?php
$this->breadcrumbs=array(
	'ประเภทห้องสมุด'=>array('index'),
	'เพิ่มประเภทห้องสมุด',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มประเภทห้องสมุด'
)); ?>
