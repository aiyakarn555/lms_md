<?php
/* @var $this GalleryTypeController */
/* @var $model GalleryType */

$this->breadcrumbs=array(
	'ระบบประเภทแกลลอรี่'=>array('index'),
	'เพิ่มประเภทแกลลอรี่',
);

// $this->menu=array(
// 	array('label'=>'List GalleryType', 'url'=>array('index')),
// 	array('label'=>'Manage GalleryType', 'url'=>array('admin')),
//);
?>

<!-- <h1>Create GalleryType</h1> -->

<?php $this->renderPartial('_form', array('model'=>$model)); ?>