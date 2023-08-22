<?php
/* @var $this DivisionController */
/* @var $model Division */

$this->breadcrumbs=array(
	'manage language'=>array('admin'),
	'create',
);


?>

<?php $this->renderPartial('_form', array('model'=>$model,'formtext'=>'add')); ?>