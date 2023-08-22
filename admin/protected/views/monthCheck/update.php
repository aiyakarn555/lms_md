<?php
/* @var $this DivisionController */
/* @var $model Division */
$this->breadcrumbs=array(
	'ภาษา'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'แก้ไข',
);


?>
<!-- 
<h1>Update Language <?php echo $model->id; ?></h1> -->

<?php $this->renderPartial('_form', array('model'=>$model)); ?>