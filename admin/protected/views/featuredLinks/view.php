<?php

$this->breadcrumbs=array(
	'ระบบจัดการลิงค์แนะนำ'=>array('admin'),
	$model->link_name,
);
?>

<?php 

// $this->widget('zii.widgets.CDetailView', array(
// 	'data'=>$model,
// 	'attributes'=>array(
// 		'link_image',
// 		'link_name',
// 		'link_url',
// 		'active',
// 		'createby',
// 		'createdate',
// 		'updateby',
// 		'updatedate',
// 	),
// )); 
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'link_image',
			'type'=>'raw',
			'value'=> ($model->link_image)?CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->link_image), $model->link_image,array(
						"class"=>"thumbnail"
					)):'-',
		),
		'link_name',
		'link_url',
		array(
			'name'=>'createdate',
			'value'=> ClassFunction::datethaiTime($model->createdate)
		),
		array(
			'name'=>'createby',
			'value'=>$model->usercreate->username
		),
		array(
			'name'=>'updatedate',
			'value'=> ClassFunction::datethaiTime($model->updatedate)
		),
		array(
			'name'=>'updateby',
			'value'=>$model->userupdate->username
		),
	),
)); 

?>
