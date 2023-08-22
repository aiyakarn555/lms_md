<?php
$this->breadcrumbs=array(
	'ระบบแบบสอบถามความพึงพอใจ'=>array('index'),
	'ตรวจสอบคำถามความพึงพอใจ'=>array('admin','id'=>$model->course_id),
	$model->eva_title,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'eva_title',
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

