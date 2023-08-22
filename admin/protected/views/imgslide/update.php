
<?php
$this->breadcrumbs=array(
	'ระบบสไลด์รูปภาพ'=>array('index'),
	'แก้ไขสไลด์รูปภาพ',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขสไลด์รูปภาพ',
	'imageShow'=>$imageShow,
	'notsave'=>$notsave
)); ?>

