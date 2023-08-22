<?php
$this->breadcrumbs=array(
	'เงื่อนไขการใช้งาน'=>array('index'),
	$model->conditions_title,
);

$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'conditions_detail', 'type'=>'raw'),
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
