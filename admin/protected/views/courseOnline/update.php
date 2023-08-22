
<?php
$this->breadcrumbs=array(
	'ระบบหลักสูตร'=>array('index'),
	'แก้ไขหลักสูตร',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขหลักสูตร',
	'imageShow'=>$imageShow
)); ?>
