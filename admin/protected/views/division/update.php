<?php
/* @var $this DivisionController */
/* @var $model Division */

$this->breadcrumbs=array(
	'กอง'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'แก้ไข',
);


?>

<h1>Update Division <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>