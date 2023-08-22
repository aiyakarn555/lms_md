<?php
$this->breadcrumbs=array(
	'ระบบบทเรียน'=>array('index'),
	$model->title,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'image',
			'type'=>'raw',
			'value'=> ($model->image)?CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->image), $model->image,array(
						"class"=>"thumbnail"
					)):'-',
		),
		array(
			'label'=>'หมวดหมู่',
			'value'=>$model->courseonlines->course_title,
		),
		'title',
		'description',
		'cate_amount',
		'time_test',
		array(
			'label'=>'เนื้อหา',
			'type'=>'raw',
			'value'=>$model->content,
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
