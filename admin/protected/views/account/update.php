
<?php
$this->breadcrumbs=array(
	'ระบบมุมคนบัญชี'=>array('index'),
	'แก้ไขมุมคนบัญชี',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขมุมคนบัญชี',
	'imageShow'=>$imageShow
)); ?>
