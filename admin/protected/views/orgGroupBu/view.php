<?php
/* @var $this OrgGroupBuController */
/* @var $model OrgGroupBu */

$this->breadcrumbs=array(
	'จัดการ OrgGroupBu'=>array('index'),
	$model->id,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'code',
		'name',
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
