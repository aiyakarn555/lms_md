<?php
$this->breadcrumbs=array(
	'ระบบติดต่อเรา' => array('index'),
	'เพิ่มติดต่อเรา',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model' 	=> $model,
	'formtext' 	=> 'เพิ่มติดต่อเรา'
)); ?>