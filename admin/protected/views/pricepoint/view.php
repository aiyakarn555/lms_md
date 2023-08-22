<?php
$this->breadcrumbs=array(
	'จัดการจำนวน Point'=>array('index'),
	$model->pricepoint_money,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'pricepoint_money',
			'value'=>number_format($model->pricepoint_money)
		),
		array(
			'name'=>'pricepoint_point',
			'value'=>number_format($model->pricepoint_point)
		),
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
