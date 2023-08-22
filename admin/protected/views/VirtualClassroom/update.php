
<?php
$this->breadcrumbs=array(
	'Virtual Classroom'=>array('index'),
	'แก้ไข',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไข'
)); ?>
