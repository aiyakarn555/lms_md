
<?php
$this->breadcrumbs=array(
	'ระบบชุดข้อสอบบทเรียนออนไลน์'=>array('index'),
	$model->group_title,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'lesson.title',
		'group_title',
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
