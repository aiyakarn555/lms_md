<?php
/* @var $this GenerationController */
/* @var $model Generation */

$this->breadcrumbs=array(
	'ระบบจัดการรุ่น'=>array('index'),
	'เพิ่มรุ่น',
);

?>
<?php $this->renderPartial('_form', array('model'=>$model,'formtext'=>'เพิ่มรุ่น')); ?>