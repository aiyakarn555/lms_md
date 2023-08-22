
<?php
$this->breadcrumbs=array(
	'Scorm'=>array('index'),
	'เพิ่ม',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่ม'
)); ?>
