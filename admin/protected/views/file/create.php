<?php
$this->breadcrumbs=array(
	'จัดการบทเรียน'=>array('lesson/index'),
	'จัดอันดับวิดีโอ'=>array('File/index','id'=>$model->lesson_id),
	'เพิ่มชื่อวิดีโอ',
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'error'=>$error)); ?>