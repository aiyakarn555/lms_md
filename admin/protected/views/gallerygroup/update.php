
<?php
$this->breadcrumbs=array(
	'ระบบแกลลอรี่'=>array('index'),
	'แก้ไขแกลลอรี่',
);

?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขแกลลอรี่',
	'gallery'=>$gallery,
		
	'imageShow'=>$imageShow,
	'notsave'=>$notsave,
)); ?>

