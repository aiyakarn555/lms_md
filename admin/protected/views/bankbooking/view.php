
<?php
$this->breadcrumbs=array(
	'ระบบจัดการธนาคารสำหรับการจองหลักสูตร'=>array('index'),
	$model->bank_name,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'bank_images',
			'type'=>'raw',
			'value'=> ($model->bank_images)? Controller::ImageShowIndexLinux("bank",$model->id,$model->bank_images) :'-',
		),
		'bank_name',
		'account_name',
		'account_number',
	),
)); ?>
