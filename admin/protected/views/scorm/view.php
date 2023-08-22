
<?php
$this->breadcrumbs=array(
	'ระบบหลักสูตรอบรมออนไลน์'=>array('index'),
	$model->course_title,
);
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
		array(
			'name'=>'course_lecturer',
			'value'=>$model->teachers->teacher_name,
		),
		'course_short_title',
		array('name'=>'course_detail', 'type'=>'raw'),
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
)); ?>
