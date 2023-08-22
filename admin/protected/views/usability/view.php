<?php
$this->breadcrumbs=array(
	'ระบบวิธีการใช้งาน'=>array('index'),
	$model->usa_title,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'usa_address',
			'type'=>'raw',
			'value'=> ($model->usa_address)? Controller::ImageShowIndexLinux("usability",$model->id,$model->usa_address) :'-',

		),
		'usa_title',
		array('name'=>'usa_detail', 'type'=>'raw'),
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
