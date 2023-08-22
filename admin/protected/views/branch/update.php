<?php
$this->breadcrumbs=array(
	'จัดการเลเวล'=>array('index'),
	'แก้ไขเลเวล',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขเลเวล'
)); ?>
