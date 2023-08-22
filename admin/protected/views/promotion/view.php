
<?php
$this->breadcrumbs=array(
	'ระบบโปรโมชั่น'=>array('index'),
	$model->shop_name,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'shop_picture',
			'type'=>'raw',
			'value'=> ($model->shop_picture)?CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->shop_picture), $model->shop_picture,array(
						"class"=>"thumbnail"
					)):'-',
		),
		array(
			'name'=>'shoptype_id',
			'value'=>$model->shoptype->shoptype_name
		),
		'shop_name',
		array(
			'name'=>'price',
			'value'=>number_format($model->price)
		),
		// array(
		// 	'name'=>'shop_point',
		// 	'value'=>number_format($model->shop_point)
		// ),
		'shop_short_detail',
		'shop_unit',
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
