
<?php
$this->breadcrumbs=array(
	'รูปภาพโฆษณา'=>array('index'),
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'image_picture',
			'type'=>'raw',
			'value'=> ($model->image_picture)?CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->image_picture), $model->image_picture,array(
						"class"=>"thumbnail"
					)):'-',
		),
		'image_title',
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
