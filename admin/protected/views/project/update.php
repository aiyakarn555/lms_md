<?php
$this->breadcrumbs=array(
	'ระบบโครงการ'=>array('index'),
	'แก้ไขโครงการ',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขโครงการ',
)); ?>