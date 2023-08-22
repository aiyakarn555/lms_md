
<?php
// $model = CourseOnline::model()->findByPk($rootId);
$this->breadcrumbs=array(
	'ระบบหลักสูตรอบรมออนไลน์'=>array('index'),
	$model->course_title,
);

if($model->parent_id == 0){
	$rootId = $model->course_id;
}else{
	$rootId = $model->parent_id;
}

$this->widget('ADetailView', array(
		'data'=>$model,
		'attributes'=>array(
			array(
				'name'=>'course_picture',
				'type'=>'raw',
				'value'=> ($model->course_picture)?CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->course_picture), $model->course_picture,array(
					"class"=>"thumbnail"
				)):'-',
			),
			'course_number',
		// array(
		// 	'name'=>'course_rector_date',
		// 	'value'=> ClassFunction::datethai($model->course_rector_date)
		// ),
		// array(
		// 	'name'=>'course_type',
		// 	'value'=>$model->CourseType
		// ),
		// 'course_refer',
		// 'course_book_number',
		// array(
		// 	'name'=>'course_book_date',
		// 	'value'=> ClassFunction::datethai($model->course_book_date)
		// ),
		// array(
		// 	'name'=>'course_hour',
		// 	'value'=>($model->course_hour)?$model->course_hour:'-',
		// ),
		// array(
		// 	'name'=>'course_other',
		// 	'value'=>($model->course_other)?$model->course_other:'-',
		// ),
			'course_title',
		// array(
		// 	'name'=>'course_lecturer',
		// 	'value'=>$model->teachers->teacher_name,
		// ),
			'course_short_title',
			array('name'=>'course_detail', 'type'=>'raw', 'value'=>htmlspecialchars_decode($model->course_detail)),
		// array(
		// 	'name'=>'course_tax',
		// 	'value'=>($model->course_tax == 0)?"ไม่เสียภาษี":"เสียภาษี",
		// ),
		// array(
		// 	'name'=>'course_price',
		// 	'value'=>number_format($model->course_price).' บาท',
		// ),
			'course_note',
		/*array(
			'name'=>'course_point',
			'value'=>number_format($model->course_point).' คะแนน',
		),*/
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
$courseCh = CourseOnline::model()->findAll($criteriaimg);
foreach ($courseCh as $key => $value) {
	// $value->lang_id = $value->lang_id;
	$value->labelState = true;
	$this->widget('ADetailView', array(
		'data'=>$value,
		'attributes'=>array(
			array(
				'name'=>'course_picture',
				'type'=>'raw',
				'value'=> ($value->course_picture)?CHtml::image(Yush::getUrl($value, Yush::SIZE_THUMB, $value->course_picture), $value->course_picture,array(
					"class"=>"thumbnail"
				)):'-',
			),
			'course_number',
		// array(
		// 	'name'=>'course_rector_date',
		// 	'value'=> ClassFunction::datethai($model->course_rector_date)
		// ),
		// array(
		// 	'name'=>'course_type',
		// 	'value'=>$model->CourseType
		// ),
		// 'course_refer',
		// 'course_book_number',
		// array(
		// 	'name'=>'course_book_date',
		// 	'value'=> ClassFunction::datethai($model->course_book_date)
		// ),
		// array(
		// 	'name'=>'course_hour',
		// 	'value'=>($model->course_hour)?$model->course_hour:'-',
		// ),
		// array(
		// 	'name'=>'course_other',
		// 	'value'=>($model->course_other)?$model->course_other:'-',
		// ),
			'course_title',
		// array(
		// 	'name'=>'course_lecturer',
		// 	'value'=>$model->teachers->teacher_name,
		// ),
			'course_short_title',
			array('name'=>'course_detail', 'type'=>'raw', 'value'=>htmlspecialchars_decode($value->course_detail)),
		// array(
		// 	'name'=>'course_tax',
		// 	'value'=>($model->course_tax == 0)?"ไม่เสียภาษี":"เสียภาษี",
		// ),
		// array(
		// 	'name'=>'course_price',
		// 	'value'=>number_format($model->course_price).' บาท',
		// ),
			'course_note',
		/*array(
			'name'=>'course_point',
			'value'=>number_format($model->course_point).' คะแนน',
		),*/
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
