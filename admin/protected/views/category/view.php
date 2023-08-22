
<?php
$this->breadcrumbs=array(
	'ระบบหมวดหลักสูตร'=>array('index'),
	$model->cate_title,
);

if($model->parent_id == 0){
	$rootId = $model->cate_id;
}else{
	$rootId = $model->parent_id;
}

$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'cate_image',
			'type'=>'raw',
			'value'=> ($model->cate_image)?CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->cate_image), $model->cate_image,array(
						"class"=>"thumbnail"
					)):'-',
		),
	
		'cate_title',
		// 'cate_short_detail',
		// array('name'=>'cate_detail', 'type'=>'raw'),
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
$cateCh = Category::model()->findAll($criteriaimg);

foreach ($cateCh as $key => $value) {
	$value->labelState = true;
	$this->widget('ADetailView', array(
		'data'=>$value,
		'attributes'=>array(
			array(
				'name'=>'cate_image',
				'type'=>'raw',
				'value'=> ($value->cate_image)?CHtml::image(Yush::getUrl($value, Yush::SIZE_THUMB, $value->cate_image), $value->cate_image,array(
					"class"=>"thumbnail"
				)):'-',
			),
		// array(
		// 	'name'=>'cate_type',
		// 	'value'=>$model->CateName,
		// 	'type'=>'html'
		// ),
			'cate_title',
			// 'cate_short_detail',
			// array('name'=>'cate_detail', 'type'=>'raw'),
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
