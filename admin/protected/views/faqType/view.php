<?php
/* @var $this FaqTypeController */
/* @var $model FaqType */

$this->breadcrumbs=array(
	'ระบบหมวดคำถาม'=>array('index'),
	$model->faq_type_id,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'faq_type_title_TH',
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
));
?>
