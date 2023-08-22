
<?php
$this->breadcrumbs=array(
	'จัดการตำแหน่ง'=>array('index'),
	'เพิ่มตำแหน่ง',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มตำแหน่ง'
)); ?>
