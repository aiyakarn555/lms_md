<?php
$this->breadcrumbs=array(
	'pController'=>array('index'),
	$model_c->controller=>array('view','id'=>$model_c->id),
	'Update',
);
	?>

<?php echo $this->renderPartial('_form', array('model_c'=>$model_c,'model_a'=>$model_a,'model_t'=>$model_t,'formtext'=>'แก้ไข Controller')); ?>