<?php
$this->breadcrumbs=array(
	'เรือ'=>array('index'),
	$model->ship_name,
);

$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'ship_name', 'type'=>'raw'),
		array('name'=>'ship_name_en', 'type'=>'raw'),
		array(
			'name'=>'create_date',
			'value'=> ClassFunction::datethaiTime($model->create_date)
		),
		array(
			'name'=>'create_by',
			'value'=>$model->usercreate->username
		),
		array(
			'name'=>'update_date',
			'value'=> ClassFunction::datethaiTime($model->update_date)
		),
		array(
			'name'=>'update_by',
			'value'=>$model->userupdate->username
		),
	),
)); ?>
