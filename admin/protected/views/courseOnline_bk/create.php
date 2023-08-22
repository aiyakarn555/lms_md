
<?php
$this->breadcrumbs=array(
	'ระบบจัดการหลักสูตร'=>array('index'),
	'เพิ่มจัดการหลักสูตร',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มจัดการหลักสูตร'
)); ?>
