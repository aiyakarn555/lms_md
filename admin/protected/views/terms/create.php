<?php
$this->breadcrumbs=array(
	'ระบบเงื่อนไขการใช้งาน' => array('index'),
	'เพิ่มเงื่อนไขการใช้งาน',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model' 	=> $model,
	'formtext' 	=> 'เพิ่มเงื่อนไขการใช้งาน'
)); ?>
