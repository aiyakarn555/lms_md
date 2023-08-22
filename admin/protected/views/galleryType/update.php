<?php
/* @var $this GalleryTypeController */
/* @var $model GalleryType */

$this->breadcrumbs=array(
	'ประเภทแกลลอรี่'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'แก้ไข',
);

?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>