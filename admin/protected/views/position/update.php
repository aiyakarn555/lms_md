
<?php
$this->breadcrumbs=array(
	'จัดการตำแหน่ง'=>array('index'),
	'แก้ไขตำแหน่ง',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขตำแหน่ง'
)); ?>
