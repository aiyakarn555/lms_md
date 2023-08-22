<?php
$this->breadcrumbs=array(
	'ระบบหมวดสินค้า'=>array('index'),
	$model->shoptype_name,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'shoptype_name',
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
