<?php
$this->breadcrumbs=array(
	'จัดการบทเรียน'=>array('lesson/index'),
	'จัดอันดับ Youtube'=>array('FileYoutube/index','id'=>$model->lesson_id),
	'แก้ไข Youtube',
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'formtext'=>'แก้ไข Youtube')); ?>