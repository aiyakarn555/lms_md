<?php
$this->breadcrumbs=array(
	'เรือ' => array('index'),
	'แก้ไขเรือ',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model' 	=> $model,
	'formtext' 	=> 'แก้ไขเรือ'
)); ?>