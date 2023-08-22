<?php
$this->breadcrumbs=array(
	'Pcontrollers'=>array('index'),
	'Create',
);

?>

<?php echo $this->renderPartial('_form', array('model_c'=>$model_c,'model_a'=>$model_a,'formtext'=>'เพิ่ม Controller')); ?>