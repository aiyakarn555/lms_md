<?php
$this->breadcrumbs=array(
	'จัดการบทเรียน'=>array('lesson/index'),
	'จัดอันดับไฟล์เสียง'=>array('FileAudio/index','id'=>$model->lesson_id),
	'แก้ไขชื่อไฟล์เสียง',
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'formtext'=>'แก้ไขชื่อไฟล์เสียง')); ?>