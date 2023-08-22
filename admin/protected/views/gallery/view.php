
<?php
$this->breadcrumbs=array(
	'ระบบแกลลอรี่'=>array('index'),
	$model->id,
);
$assetsDir = yii::app()->baseUrl.'../../uploads/gallery/'.$model->gallery_type_id.'/'.$model->image;
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'image',
			'type'=>'raw',
			'value'=> ($model->image)?CHtml::image(yii::app()->baseUrl.'../../uploads/gallery/images/'.$model->image):'No image',
		),

		array(
			'name'=>'gallery_type_id',
			'value'=> $model->gType->name_gallery_type,
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
