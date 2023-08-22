<?php
$this->breadcrumbs=array(
	'ระบบเงื่อนไขการใช้งาน' => array('index'),
	'แก้ไขเงื่อนไขการใช้งาน',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model' 	=> $model,
	'formtext' 	=> 'แก้ไขเงื่อนไขการใช้งาน'
)); ?>
