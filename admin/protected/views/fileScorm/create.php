<?php
$this->breadcrumbs=array(
	'จัดการบทเรียน'=>array('lesson/index'),
	'จัดการ Scorm'=>array('FileScorm/index','id'=>$model->lesson_id),
	'เพิ่ม Scorm',
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'error'=>$error)); ?>