<?php
$this->breadcrumbs=array(
	$model->title,
);
$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'-','value'=>'รายละเอียด'),
		array(
			'name'=>'image',
			'type'=>'raw',
			'value'=> ($model->image)?CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->image), $model->image,array(
						"class"=>"thumbnail"
					)):'-',
		),
		array(
			'label'=>'หมวดหมู่',
			'value'=>$model->CourseOnlines->course_title,
		),
		'title',
		'description',
		array(
			'label'=>'เนื้อหา',
			'type'=>'raw',
			'value'=>$model->content,
		),
	),
)); ?>
