
<?php
$this->breadcrumbs=array(
	'ระบบรายชื่อธนาคารโอนเงิน'=>array('index'),
	'แก้ไขธนาคาร',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขธนาคาร',
	'imageShow'=>$imageShow
)); ?>
