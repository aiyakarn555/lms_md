<?php
$this->breadcrumbs=array(
	'ระบบบทเรียน'=>array('index'),
	$model->title,
);

if($model->parent_id == 0){
	$rootId = $model->id;
}else{
	$rootId = $model->parent_id;
}

$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'image',
			'type'=>'raw',
			'value'=> ($model->image)?CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->image), $model->image,array(
						"class"=>"thumbnail"
					)):'-',
		),
		array(
			'label'=>'หมวดหมู่',
			'value'=>$model->courseonlines->course_title,
		),
		'title',
		// 'description',
		'cate_amount',
		'time_test',
		// array(
		// 	'label'=>'เนื้อหา',
		// 	'type'=>'raw',
		// 	'value'=>$model->content,
		// ),
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

$criteriaimg = new CDbCriteria;
$criteriaimg->compare('active','y');
$criteriaimg->compare('parent_id',$rootId);
$lessonCh = Lesson::model()->findAll($criteriaimg);

foreach ($lessonCh as $key => $value) {
	$value->labelState = true;
	$this->widget('ADetailView', array(
		'data'=>$value,
		'attributes'=>array(
			array(
				'name'=>'image',
				'type'=>'raw',
				'value'=> ($value->image)?CHtml::image(Yush::getUrl($value, Yush::SIZE_THUMB, $value->image), $value->image,array(
					"class"=>"thumbnail"
				)):'-',
			),
			array(
				'label'=>'หมวดหมู่',
				'value'=>$value->courseonlines->course_title,
			),
			'title',
			// 'description',
			'cate_amount',
			'time_test',
			// array(
			// 	'label'=>'เนื้อหา',
			// 	'type'=>'raw',
			// 	'value'=>$value->content,
			// ),
			array(
				'name'=>'create_date',
				'value'=> ClassFunction::datethaiTime($value->create_date)
			),
			array(
				'name'=>'create_by',
				'value'=>$value->usercreate->username
			),
			array(
				'name'=>'update_date',
				'value'=> ClassFunction::datethaiTime($value->update_date)
			),
			array(
				'name'=>'update_by',
				'value'=>$value->userupdate->username
			),
		),
	));
}

?>
