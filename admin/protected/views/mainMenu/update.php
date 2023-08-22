<?php
/* @var $this DivisionController */
/* @var $model Division */
$this->breadcrumbs=array(
	'เมนู'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'แก้ไข',
);


?>

<h1>Update Language <?php echo $model->id; ?></h1>

<?php $this->renderPartial($form, array('model'=>$model,'label'=>$label,'formtext'=>'แก้ไขภาษา')); ?>