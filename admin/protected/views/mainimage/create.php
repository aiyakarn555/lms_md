
<?php
$this->breadcrumbs=array(
	'รูปภาพโฆษณา'=>array('index'),
	'เพิ่มรูปภาพโฆษณา',
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'formtext'=>'เพิ่มรูปภาพโฆษณา','notsave'=>$notsave)); ?>