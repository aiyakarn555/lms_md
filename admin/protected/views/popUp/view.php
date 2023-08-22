<?php

$this->breadcrumbs=array(
	'manage popup'=>array('admin'),
	$model->name,
);
?>


<?php 

$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'pic_file',
			'type'=>'raw',
			'value'=> ($model->pic_file)? Controller::ImageShowIndexLinux("popup",$model->id,$model->pic_file) :'-',
		),
		'name',
		'detail',
		array(
			'name'=>'start_date',
			'value'=> ClassFunction::datethaiTime($model->start_date)
		),
		array(
			'name'=>'end_date',
			'value'=> ClassFunction::datethaiTime($model->end_date)
		),
		'link',
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
)); 
?>
