<?php
$this->breadcrumbs=array(
	'Pgroups'=>array('index'),
	'Create',
);
?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'model_p'=>$model_p,'pController' => $pController)); ?>