
<?php
$this->breadcrumbs=array(
	'ระบบมุมคนบัญชี'=>array('index'),
	$model->cms_title,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'cms_picture',
			'type'=>'raw',
			'value'=> ($model->cms_picture)?CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->cms_picture), $model->cms_picture,array(
						"class"=>"thumbnail"
					)):'-',
		),
		'cms_title',
		'cms_short_title',
		array('name'=>'cms_detail', 'type'=>'raw'),
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
