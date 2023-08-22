
<?php
$this->breadcrumbs=array(
	'ระบบแกลลอรี่'=>array('index'),
	'เพิ่มแกลลอรี่',
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'gallery'=>$gallery,'formtext'=>'เพิ่มแกลลอรี่','notsave'=>$notsave)); ?>

