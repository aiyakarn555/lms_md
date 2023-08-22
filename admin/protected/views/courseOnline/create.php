
<?php
$this->breadcrumbs=array(
	'ระบบหลักสูตร'=>array('index'),
	'เพิ่มหลักสูตร',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มหลักสูตร'
)); ?>
