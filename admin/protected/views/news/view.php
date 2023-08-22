
<?php
$this->breadcrumbs=array(
	'ระบบข่าวสารและกิจกรรม'=>array('index'),
	$model->cms_title,
);

if($model->parent_id == 0){
	$mainId = $model->cms_id;
	$subMainId = $model->cms_id;
}else{
	$mainId = $model->parent_id;
	$subMainId = $model->cms_id;
}

$criteria = new CDbCriteria;
$criteria->compare('active','y');
$criteria->compare('cms_id',$mainId);
$modelMain = News::model()->find($criteria);

$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'cms_picture',
			'type'=>'raw',
			'value'=> ($modelMain->cms_picture)? Controller::ImageShowIndexLinux("news",$modelMain->cms_id,$modelMain->cms_picture) :'-',
		),
		'cms_title',
		'cms_short_title',
		array(
			'name'=>'cms_tab',
			'value'=> ClassFunction::_CheckNewTab($modelMain)
		),
		array(
			'name'=>'cms_link',
			'value'=> ClassFunction::_getLink($modelMain)
		),

		// array('name'=>'cms_detail', 'type'=>'raw'),
		array(
			'name' => 'cms_detail',
			'type'=>'raw',
			'value' => htmlspecialchars_decode($modelMain->cms_detail),
		),

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
	$criteriaimg->compare('cms_id',$subMainId);
}
$newsCh = News::model()->findAll($criteriaimg);
foreach ($newsCh as $key => $value) {
	// $value->lang_id = $value->lang_id;
	$value->labelState = true;
	$this->widget('ADetailView', array(
		'data'=>$value,
		'attributes'=>array(
			array(
				'name'=>'cms_picture',
				'type'=>'raw',
				'value'=> ($value->cms_picture)? Controller::ImageShowIndexLinux("news",$value->cms_id,$value->cms_picture) :'-',
			),
			'cms_title',
			'cms_short_title',
			array(
				'name'=>'cms_tab',
				'value'=> ClassFunction::_CheckNewTab($value)
			),
			array(
				'name'=>'cms_link',
				'value'=> ClassFunction::_getLink($value)
			),
	
			// array('name'=>'cms_detail', 'type'=>'raw'),
			array(
				'name' => 'cms_detail',
				'type'=>'raw',
				'value' => htmlspecialchars_decode($value->cms_detail),
			),
	
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




