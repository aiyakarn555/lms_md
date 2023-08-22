<?php
/* @var $this DivisionController */
/* @var $model Division */

$this->breadcrumbs=array(
	'manage language'=>array('admin'),
	$model->language,
);

?>

<h1>View Language #<?php echo $model->id; ?></h1>

<?php $this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'language',
		'status'
	),
)); ?>
