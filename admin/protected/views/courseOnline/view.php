
<?php
// $model = CourseOnline::model()->findByPk($rootId);
$this->breadcrumbs=array(
	'ระบบหลักสูตรอบรมออนไลน์'=>array('index'),
	$model->course_title,
);
if($model->parent_id == 0){
	$mainId = $model->course_id;
	$subMainId = $model->course_id;
}else{
	$mainId = $model->parent_id;
	$subMainId = $model->course_id;
}

$criteriaimg = new CDbCriteria;
$criteriaimg->compare('active','y');
$criteriaimg->compare('course_id',$mainId);
$modelMain = CourseOnline::model()->find($criteriaimg);

$this->widget('ADetailView', array(
		'data'=>$modelMain,
		'attributes'=>array(
			array(
				'name'=>'course_picture',
				'type'=>'raw',
				'value'=> ($modelMain->course_picture)?CHtml::image(Yush::getUrl($modelMain, Yush::SIZE_THUMB, $modelMain->course_picture), $modelMain->course_picture,array(
					"class"=>"thumbnail"
				)):'-',
			),
			'course_number',
			'course_title',
			'course_short_title',
			array('name'=>'course_detail', 'type'=>'raw', 'value'=>htmlspecialchars_decode($modelMain->course_detail)),
		
		array(
			'name'=>'create_date',
			'value'=> ClassFunction::datethaiTime($modelMain->create_date)
		),
		array(
			'name'=>'create_by',
			'value'=>$modelMain->usercreate->username
		),
		array(
			'name'=>'update_date',
			'value'=> ClassFunction::datethaiTime($modelMain->update_date)
		),
		array(
			'name'=>'update_by',
			'value'=>$modelMain->userupdate->username
		),
	),
	));


$criteriaimg = new CDbCriteria;
$criteriaimg->compare('active','y');
if($model->parent_id == 0){
	$criteriaimg->compare('parent_id',$subMainId);
}else{
	$criteriaimg->compare('course_id',$subMainId);
}

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
			'course_title',
			'course_short_title',
			array('name'=>'course_detail', 'type'=>'raw', 'value'=>htmlspecialchars_decode($value->course_detail)),
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
