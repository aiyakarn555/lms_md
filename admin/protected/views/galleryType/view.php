<?php
$this->breadcrumbs=array(
	'ระบบแกลลลอรี่'=>array('index'),
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'name_gallery_type',
		array(
			'name'=>'create_date',
			'value'=> Helpers::lib()->changeFormatDate($model->create_date,'datetime')
		),
		array(
			'name'=>'create_by',
			'value'=>$model->usercreate->username
		),
		array(
			'name'=>'update_date',
			'value'=> Helpers::lib()->changeFormatDate($model->update_date,'datetime')
		),
		array(
			'name'=>'update_by',
			'value'=>$model->userupdate->username
		),
	),
	)); ?>