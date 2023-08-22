<?php
$this->breadcrumbs=array(
	'จัดการบทเรียน'=>array('lesson/index'),
	// 'จัดอันดับวิดีโอ'=>array('File/index','id'=>$model->lesson_id),
	'แก้ไขข้อมูล',
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>