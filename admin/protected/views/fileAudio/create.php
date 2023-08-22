<?php
$this->breadcrumbs=array(
	'จัดการบทเรียน'=>array('lesson/index'),
	'จัดอันดับไฟล์เสียง'=>array('FileAudio/index','id'=>$model->lesson_id),
	'เพิ่มชื่อไฟล์เสียง',
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'error'=>$error,'formtext'=>'เพิ่มชื่อไฟล์เสียง')); ?>