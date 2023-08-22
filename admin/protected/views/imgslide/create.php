
<?php
$this->breadcrumbs=array(
	'ระบบป้ายประชาสัมพันธ์'=>array('index'),
	'เพิ่มป้ายประชาสัมพันธ์',
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'formtext'=>'เพิ่มป้ายประชาสัมพันธ์','notsave'=>$notsave)); ?>

