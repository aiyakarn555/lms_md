
<?php
$this->breadcrumbs=array(
	'ห้องสมุด'=>array('index'),
	'แก้ไขห้องสมุด',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขห้องสมุด'
)); ?>
