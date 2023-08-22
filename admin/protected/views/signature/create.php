<?php
/* @var $this SignatureController */
/* @var $model Signature */

$this->breadcrumbs=array(
	'Signatures'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List Signature', 'url'=>array('index')),
	array('label'=>'Manage Signature', 'url'=>array('admin')),
);*/
?>

<!-- <h1>Create Signature</h1> -->

<?php $this->renderPartial('_form', array('model'=>$model,'formtext'=>'เพิ่ม ลายเซ็นต์',)); ?>