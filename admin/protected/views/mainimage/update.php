
<?php
$this->breadcrumbs=array(
	'รูปภาพโฆษณา'=>array('index'),
	'แก้ไขรูปภาพโฆษณา',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขรูปภาพโฆษณา',
	'imageShow'=>$imageShow,
	'notsave'=>$notsave
)); ?>

