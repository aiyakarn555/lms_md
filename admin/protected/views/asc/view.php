
<?php
$this->breadcrumbs=array(
	'ระบบหน่วยงาน'=>array('index'),
	$model->title,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'title',
	),
)); ?>
