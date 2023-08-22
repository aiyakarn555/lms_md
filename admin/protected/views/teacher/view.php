
<?php
$this->breadcrumbs=array(
	'ระบบรายชื่อวิทยากร'=>array('index'),
	$model->teacher_name,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'teacher_picture',
			'type'=>'raw',
			'value'=> ($model->teacher_picture)?CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->teacher_picture), $model->teacher_picture,array(
						"class"=>"thumbnail"
					)):'-',
		),
		'teacher_name',
		'teacher_detail:html',
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
