<?php
$this->breadcrumbs=array(
	'จัดการบทเรียน'=>array('lesson/index'),
	'จัดการ PDF'=>array('FilePdf/index','id'=>$model->lesson_id),
	'เพิ่ม PDF',
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>