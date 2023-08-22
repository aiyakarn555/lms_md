
<?php
$this->breadcrumbs=array(
	'ระบบประเภทเอกสาร'=>array('index'),
	$model->dty_name,
);

$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		array(
			'name'=>'dty_id',
			'value'=>$model->dty_id,
			'type'=>'html'
		),
		array(
			'name'=>'dty_name',
			'value'=>$model->dty_name,
			'type'=>'raw'
		),
		array(
			'name'=>'active',
			'value'=>$model->active,
			'type'=>'raw'
		),
		// array(
		// 	'name'=>'createby',
		// 	'value'=>$model->createby,
		// 	'type'=>'raw'
		// ),
		array(
			'name'=>'createdate',
			'value'=>ClassFunction::datethaiTime($model->createdate),
			'type'=>'raw'
		),
		// array(
		// 	'name'=>'updateby',
		// 	'value'=>$model->updateby,
		// 	'type'=>'raw'
		// ),
		array(
			'name'=>'updatedate',
			'value'=>ClassFunction::datethaiTime($model->updatedate) ,
			'type'=>'raw'
		),
		// array(
		// 	'name'=>'lang_id',
		// 	'value'=>$model->lang_id,
		// 	'type'=>'raw'
		// ),
		// array(
		// 	'name'=>'reference',
		// 	'value'=>$model->reference,
		// 	'type'=>'raw'
		// )
		
		
	),
)); 

$criteria = new CDbCriteria();
$criteria->compare('parent_id',$model->dty_id);
$modelParent = DocumentType::model()->find($criteria);
$modelParent->labelState = true;
$this->widget('ADetailView', array(
	'data'=>$modelParent,
	'attributes'=>array(
		
		array(
			'name'=>'dty_id',
			'value'=>$modelParent->dty_id,
			'type'=>'html'
		),
		array(
			'name'=>'dty_name',
			'value'=>$modelParent->dty_name,
			'type'=>'raw'
		),
		array(
			'name'=>'active',
			'value'=>$modelParent->active,
			'type'=>'raw'
		),
		// array(
		// 	'name'=>'createby',
		// 	'value'=>$modelParent->createby,
		// 	'type'=>'raw'
		// ),
		array(
			'name'=>'createdate',
			'value'=>ClassFunction::datethaiTime($modelParent->createdate),
			'type'=>'raw'
		),
		// array(
		// 	'name'=>'updateby',
		// 	'value'=>$modelParent->updateby,
		// 	'type'=>'raw'
		// ),
		array(
			'name'=>'updatedate',
			'value'=>ClassFunction::datethaiTime($modelParent->updatedate) ,
			'type'=>'raw'
		),
		// array(
		// 	'name'=>'lang_id',
		// 	'value'=>$modelParent->lang_id,
		// 	'type'=>'raw'
		// ),
		// array(
		// 	'name'=>'reference',
		// 	'value'=>$modelParent->reference,
		// 	'type'=>'raw'
		// )
		
		
	),
)); 

?>
