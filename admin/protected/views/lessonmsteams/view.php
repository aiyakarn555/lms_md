<?php
$this->breadcrumbs=array(
	'ระบบบทเรียนออนไลน์'=>array('index'),
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
			'label'=>'หลักสูตรออนไลน์',
			'value'=>$model->msteams->name_ms_teams,
		),
		'title',
		// 'description',
		'cate_amount',
		'time_test',
		
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
$lessonCh = LessonMsTeams::model()->findAll($criteriaimg);

foreach ($lessonCh as $key => $value) {
	$value->labelState = true;
	$this->widget('ADetailView', array(
		'data'=>$value,
		'attributes'=>array(
			
			array(
				'label'=>'หลักสูตรออนไลน์',
				'value'=>$value->msteams->name_ms_teams,
			),
			'title',
			// 'description',
			'cate_amount',
			'time_test',
			
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
