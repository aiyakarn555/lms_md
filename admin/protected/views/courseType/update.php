
<?php
$this->breadcrumbs=array(
	'ประเภทหลักสูตร'=>array('index'),
	'แก้ไขประเภทหลักสูตร',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขประเภทหลักสูตร'
)); ?>
