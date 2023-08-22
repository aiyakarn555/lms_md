
<?php
$this->breadcrumbs=array(
	'ระบบหลักสูตรผู้ประกอบวิชาชีพ'=>array('index'),
	'เพิ่มหลักสูตรผู้ประกอบวิชาชีพ',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มหลักสูตรผู้ประกอบวิชาชีพ'
)); ?>
