<?php
$this->breadcrumbs=array(
	'ระบบสินค้า'=>array('index'),
	'เพิ่มสินค้า',
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'formtext'=>'เพิ่มสินค้า')); ?>