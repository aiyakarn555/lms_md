
<?php
$this->breadcrumbs=array(
	'จัดการแผนก'=>array('index'),
	'แก้ไขแผนก',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'แก้ไขแผนก'
)); ?>
