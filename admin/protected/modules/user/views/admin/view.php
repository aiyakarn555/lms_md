<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('general'),$model->username,
);

$criteria= new CDbCriteria;
$criteria->compare('active','y');
$criteria->compare('code',$model->profile->code);
$OrgChart = OrgChart::model()->find($criteria);


$OrgGroupBu = OrgGroupBu::model()->findbyPk($OrgChart->group_bu_id);
$OrgBu = OrgBu::model()->findbyPk($OrgChart->bu_id);
$OrgDepartment = OrgDepartment::model()->findbyPk($OrgChart->department_id);
$OrgDivision = OrgDivision::model()->findbyPk($OrgChart->division_id);
$OrgSection = OrgSection::model()->findbyPk($OrgChart->section_id);
$OrgSubSection = OrgSubSection::model()->findbyPk($OrgChart->sub_section_id);


// print_r($OrgGroupBu);die;
	

/*
$this->menu=array(
    array('label'=>UserModule::t('Create User'), 'url'=>array('create')),
    array('label'=>UserModule::t('Update User'), 'url'=>array('update','id'=>$model->id)),
    array('label'=>UserModule::t('Delete User'), 'url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>UserModule::t('Are you sure to delete this item?'))),
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
);*/
?>
<h1><?php echo UserModule::t('View User').' "'.$model->username.'"'; ?></h1>

<?php
 	// echo Yii::app()->homeUrl .'/uploads/users/'.$model->id.'/Thumb/'.$model->pic_user;
 	// 	exit();
	$attributes = array(
		// 'id',
		/*array(
			'name'=>'pic_user',
			'type'=>'raw',
			'value'=> ($model->pic_user)?CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $model->pic_user), $model->pic_user,array(
						"class"=>"thumbnail"
					)):'-',
		),*/
		'username',
	);
	
	// $profileFields=ProfileField::model()->forOwner()->sort()->findAll();
	// if ($profileFields) {
	// 	foreach($profileFields as $field) {
	// 		array_push($attributes,array(
	// 				'label' => UserModule::t($field->title),
	// 				'name' => $field->varname,
	// 				'type'=>'raw',
	// 				'value' => (($field->widgetView($model->profile))?$field->widgetView($model->profile):(($field->range)?Profile::range($field->range,$model->profile->getAttribute($field->varname)):$model->profile->getAttribute($field->varname))),
	// 			));
	// 	}
	// }
	
	array_push($attributes,
		'email',
		'profile.prefix_th',
		'profile.firstname',
		'profile.lastname',
		array(
			'name' => 'group_bu',
			'value' => (isset($OrgGroupBu)  ? $OrgGroupBu->name :'-'),
		),
		array(
			'name' => 'bu',
			'value' => (isset($OrgBu)  ? $OrgBu->name :'-'),
		),
		array(
			'name' => 'department',
			'value' => (isset($OrgDepartment)  ? $OrgDepartment->name :'-'),
		),
		array(
			'name' => 'division',
			'value' => (isset($OrgDivision)  ? $OrgDivision->name :'-'),
		),
		array(
			'name' => 'section',
			'value' => (isset($OrgSection)  ? $OrgSection->name :'-'),
		),
		array(
			'name' => 'sub_section',
			'value' => (isset($OrgSubSection)  ? $OrgSubSection->name :'-'),
		),
		'create_at',
		'lastvisit_at',
		array(
			'name' => 'superuser',
			'value' => User::itemAlias("AdminStatus",$model->superuser),
		),
		array(
			'name' => 'status',
			'value' => User::itemAlias("UserStatus",$model->status),
		)
	);
	
	$this->widget('ADetailView', array(
		'data'=>$model,
		'attributes'=>$attributes,
	));
	

?>
