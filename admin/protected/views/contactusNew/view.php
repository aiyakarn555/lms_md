<?php

$this->breadcrumbs=array(
	'manage contactnew'=>array('admin'),
	//$model->name,
);
?>


<?php 

$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'con_image',
			'type'=>'raw',
			'value'=> ($model->con_image)? Controller::ImageShowIndexLinux("contactusnew",$model->id,$model->con_image) :'-',

		),
		'con_firstname',
		'con_lastname',
		'con_firstname_en',
		'con_lastname_en',
		'con_position',
		'con_position_en',
		'con_tel',
		'con_email',
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
