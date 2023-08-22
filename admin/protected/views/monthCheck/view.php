<?php
/* @var $this DivisionController */
/* @var $model Division */

$this->breadcrumbs=array(
	'MonthCheck'=>array('admin'),
	$model->id,
);

?>

<h1>View MonthCheck #<?php echo $model->id; ?></h1>

<?php $this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'month',
		'month_status'
	),
)); ?>
