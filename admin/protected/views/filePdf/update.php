<?php
$this->breadcrumbs=array(
	'จัดการบทเรียน'=>array('lesson/index'),
	'จัดการ PDF'=>array('FilePdf/index','id'=>$model->lesson_id),
	'แก้ไข PDF',
);
?>

<?php echo $this->renderPartial('_form', array('id'=>$id,'model'=>$model)); ?>