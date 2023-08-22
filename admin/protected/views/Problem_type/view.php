
<?php
$this->breadcrumbs=array(
	'จัดการประเภทปัญหา'=>array('index'),
	$model->Problem_title,
);

$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'ID',
			'value'=> $model->id
		),
		array(
			'name'=>'Problem_title',
			'value'=> $model->Problem_title
		),
		array(
			'name'=>'create_date',
			'value'=> ClassFunction::datethaiTime($model->create_date)
		),		
		),
)); 
?>
