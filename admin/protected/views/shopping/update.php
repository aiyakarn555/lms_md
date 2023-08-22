<?php
$this->breadcrumbs=array(
	'ระบบสินค้า'=>array('index'),
	'แก้ไขสินค้า',
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'formtext'=>'แก้ไขสินค้า','imageShow'=>$imageShow)); ?>