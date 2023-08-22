
<?php
$this->breadcrumbs=array(
	'จัดการเลเวล'=>array('index'),
	$model->branch_name,
);

$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'branch_name',
		array(
			'name'=>'create_date',
			'value'=> ClassFunction::datethaiTime($model->create_date)
		),
		'active',
		),
)); 
?>