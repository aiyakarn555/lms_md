<?php
$this->breadcrumbs=array(
	'ระบบแบบสอบถามความพึงพอใจ'=>array('index'),
	'ตรวจสอบคำถามความพึงพอใจ'=>array('admin','id'=>$model->course_id),
	'แก้ไขแบบสอบถามความพึงพอใจ',
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'formtext'=>'แก้ไขแบบสอบถามความพึงพอใจ')); ?>