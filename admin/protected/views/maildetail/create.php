<?php
$this->breadcrumbs=array(
	'จัดการจดหมายข่าว'=>array('admin'),
	'เพิ่มจดหมายข่าว',
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'formtext'=>'เพิ่มจดหมายข่าว')); ?>