
<?php
$this->breadcrumbs=array(
	'ระบบหลักสูตรนิสิต/นักศึกษา'=>array('index'),
	'แก้ไขหลักสูตรนิสิต/นักศึกษา',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขหลักสูตรนิสิต/นักศึกษา',
	'imageShow'=>$imageShow
)); ?>
