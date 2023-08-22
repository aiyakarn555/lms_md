
<?php
$this->breadcrumbs=array(
	'ระบบหน่วยงาน'=>array('index'),
	'แก้ไขหน่วยงาน',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขหน่วยงาน'
)); ?>
