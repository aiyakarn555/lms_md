<?php
$this->breadcrumbs=array(
	'ระบบติดต่อเรา' => array('index'),
	'แก้ไขติดต่อเรา',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model' 	=> $model,
	'formtext' 	=> 'แก้ไขติดต่อเรา'
)); ?>