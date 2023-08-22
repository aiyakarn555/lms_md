
<?php
$this->breadcrumbs=array(
	'ประเภทหลักสูตร'=>array('index'),
	'เพิ่มประเภทหลักสูตร',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มประเภทหลักสูตร'
)); ?>
