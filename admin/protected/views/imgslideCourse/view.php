<?php
$this->breadcrumbs=array(
	'ระบบสไลด์หลักสูตรยอดนิยม'=>array('index'),
	$model->imgslide_link,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'imgslide_picture',
			'type'=>'raw',
			'value'=> ($model->imgslide_picture)?CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->imgslide_picture), $model->imgslide_picture,array(
						"class"=>"thumbnail"
					)):'-',
		),
		'imgslide_link',
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
