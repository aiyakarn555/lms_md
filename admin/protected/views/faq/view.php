<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->breadcrumbs=array(
	'ระบบคำถามที่พบบ่อย'=>array('index'),
	$model->faq_nid_,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'faq_type_id',
			'type'=>'html',
			'value'=>$model->faq_type->faq_type_title_TH
		),
		'faq_THtopic',
		array('name'=>'faq_THanswer', 'type'=>'raw'),
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
