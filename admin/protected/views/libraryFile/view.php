<?php
$this->breadcrumbs=array(
	'ห้องสมุด'=>array('index'),
	$model->library_name,
);
?>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		// 'library_id',
		// 'sortOrder',
		// 'library_type_id',
		'library_name',
		'library_name_en',
		'library_filename',
		array(
			'name'=>'created_date',
			'value'=> ClassFunction::datethaiTime($model->created_date)
		),
		array(
			'name'=>'created_by',
			'value'=>$model->usercreate->profile->firstname." ".$model->usercreate->profile->lastname
		),
		array(
			'name'=>'updated_date',
			'value'=> ClassFunction::datethaiTime($model->updated_date)
		),
		array(
			'name'=>'updated_by',
			'value'=>$model->usercreate->profile->firstname." ".$model->usercreate->profile->lastname
		),
	),
)); ?>
