<?php
$this->breadcrumbs=array(
	'Pgroups'=>array('index'),
	$model->title,
);
$attributes = array();
array_push($attributes,
		'group_name',
		'create_date',
		'update_date'
	);
	
	$this->widget('ADetailView', array(
		'data'=>$model,
		'attributes'=>$attributes,
	));
?>
