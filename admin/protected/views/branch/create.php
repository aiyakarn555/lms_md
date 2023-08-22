
<?php
$this->breadcrumbs=array(
	'จัดการเลเวล'=>array('index'),
	'เพิ่มเลเวล',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มเลเวล'
)); ?>
