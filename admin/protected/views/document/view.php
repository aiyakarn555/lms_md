
<?php
$this->breadcrumbs=array(
	'ระบบเอกสารเผยแพร่'=>array('index'),
	$model->dow_name,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		array(
			'name'=>'dow_id',
			'value'=>$model->dow_id,
			'type'=>'html'
		),
			array(
			'name'=>'dow_address',
			'type'=>'raw',
			'value'=> ($model->dow_address)?CHtml::link($model->dow_address,Yii::app()->baseUrl.'/uploads/'.$model->dow_address):'-',
			// 'value'=> ($model->dow_address)?CHtml::image(Yii::app()->baseUrl.'/uploads/'.$model->dow_address, $model->dow_address,array(
			// 			"class"=>"thumbnail"
			// 		)):'-',
		),
		array(
			'name'=>'dow_name',
			'value'=>$model->dow_name,
			 'type'=>'raw'
			),
		array(
			'name'=>'dow_detail',
			'value'=>$model->dow_detail,
			 'type'=>'raw'
			),

		// array(
		// 	'name'=>'dow_timestart',
		// 	'value'=> ClassFunction::datethaiTime($model->dow_timestart)
		// ),
		// array(
		// 	'name'=>'dow_timeend',
		// 	'value'=> ClassFunction::datethaiTime($model->dow_timeend)
		// ),
		
	),
)); ?>
