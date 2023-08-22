
<?php
$this->breadcrumbs=array(
	'ระบบหลักสูตรนิสืต/นักศึกษา'=>array('index'),
	'เพิ่มหลักสูตรนิสืต/นักศึกษา',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มหลักสูตรสนิสืต/นักศึกษา'
)); ?>
