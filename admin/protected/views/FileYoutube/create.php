<?php
$this->breadcrumbs=array(
	'จัดการบทเรียน'=>array('lesson/index'),
	'จัดอันดับ Youtube'=>array('FileYoutube/index','id'=>$model->lesson_id),
	'เพิ่ม Youtube',
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'error'=>$error,'formtext'=>'เพิ่ม Youtube')); ?>