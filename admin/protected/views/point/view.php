<?php
$this->breadcrumbs=array(
	'จัดการบทเรียน'=>array('index'),
	$model->point_money,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'showUser',
			'value'=> $model->user->username,
		),
		array(
			'name'=>'point_bank',
			'value'=>$model->BankType,
		),
		'point_money',
		array(
			'name'=>'create_date',
			'value'=> ClassFunction::datethaiTime($model->create_date)
		),
		array(
			'name'=>'con_user',
			'value'=> $model->con_user=='1'?'ยืนยันแล้ว':'ยังไม่ได้ยืนยัน',
		),
		array(
			'name'=>'con_admin',
			'value'=> $model->con_admin=='1'?'อนุมัติแล้ว':'ยังไม่ได้อนุมัติ',
		),
	),
)); ?>
