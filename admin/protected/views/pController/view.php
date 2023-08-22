<?php
$this->breadcrumbs=array(
	'Pcontrollers'=>array('index'),
	$model->title,
);

$attributes = array();
array_push($attributes,
		'controller',
		'create_date',
		'update_date'
	);
	
	$this->widget('ADetailView', array(
		'data'=>$model,
		'attributes'=>$attributes,
	));
?>
