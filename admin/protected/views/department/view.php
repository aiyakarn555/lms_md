
<?php
$this->breadcrumbs=array(
	'จัดการแผนก'=>array('admin'),
	$model->dep_title,
);

$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'dep_title',
		array(
			'name'=>'create_date',
			'value'=> ClassFunction::datethaiTime($model->create_date)
		),
		'active',
		),
)); 
?>
