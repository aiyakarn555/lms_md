<?php
$this->breadcrumbs=array(
	$model->teacher_name,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'-','value'=>'รายละเอียด'),
		array(
			'name'=>'teacher_picture',
			'type'=>'raw',
			'value'=> ($model->teacher_picture)?CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->teacher_picture), $model->teacher_picture,array(
						"class"=>"thumbnail"
					)):'-',
		),
		'teacher_name',
		'teacher_detail:html',
	),
)); ?>
