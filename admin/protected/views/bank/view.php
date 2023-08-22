
<?php
$this->breadcrumbs=array(
	'ระบบรายชื่อธนาคารโอนเงิน'=>array('index'),
	$model->bank_name,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'bank_picture',
			'type'=>'raw',
			'value'=> ($model->bank_picture)?CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->bank_picture), $model->bank_picture,array(
						"class"=>"thumbnail"
					)):'-',
		),
		'bank_name',
		'bank_branch',
		'bank_number',
		'bank_user',
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
