
<?php
$this->breadcrumbs=array(
	'ระบบหลักสูตรผู้ประกอบวิชาชีพ'=>array('index'),
	'แก้ไขหลักสูตรผู้ประกอบวิชาชีพ',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขหลักสูตรผู้ประกอบวิชาชีพ',
	'imageShow'=>$imageShow
)); ?>
