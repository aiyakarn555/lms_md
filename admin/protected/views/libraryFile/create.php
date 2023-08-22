
<?php
$this->breadcrumbs=array(
	'ห้องสมุด'=>array('index'),
	'เพิ่มห้องสมุด',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มห้องสมุด'
)); ?>
