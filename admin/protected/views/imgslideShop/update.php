
<?php
$this->breadcrumbs=array(
	'ระบบสไลด์สินค้าแนะนำ'=>array('index'),
	'แก้ไขสไลด์สินค้าแนะนำ',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขสไลด์สินค้าแนะนำ',
	'imageShow'=>$imageShow)); 
?>
