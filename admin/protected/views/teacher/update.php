
<?php
$this->breadcrumbs=array(
	'ระบบรายชื่อวิทยากร'=>array('index'),
	'แก้ไขวิทยากร',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขวิทยากร',
	'imageShow'=>$imageShow
)); ?>
