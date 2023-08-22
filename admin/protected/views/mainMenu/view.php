<?php
/* @var $this DivisionController */
/* @var $model Division */

$this->breadcrumbs=array(
	'MainMenu'=>array('admin'),
	$model->id,
);

?>

<h1>View MainMenu #<?php echo $model->id; ?></h1>

<?php $this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'url',
		'lang_id',
		'status'
	),
)); ?>
