<?php
/* @var $this MsTeamsController */
/* @var $model MsTeams */

$this->breadcrumbs=array(
	'ห้องเรียนรู้ทางไกล'=>array('index'),
	$model->id,
);

// $this->menu=array(
// 	array('label'=>'List MsTeams', 'url'=>array('index')),
// 	array('label'=>'Create MsTeams', 'url'=>array('create')),
// 	array('label'=>'Update MsTeams', 'url'=>array('update', 'id'=>$model->id)),
// 	array('label'=>'Delete MsTeams', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage MsTeams', 'url'=>array('admin')),
// );
?>
<?php 

$create_by = User::model()->findByPk($model->create_by);
$model->create_by = $create_by->username ; 
$update_by = User::model()->findByPk($model->update_by);
$model->update_by = $update_by->username ; 
$model->detail_ms_teams = strip_tags($model->detail_ms_teams);
?>
<h1>View MsTeams #<?php echo $model->id; ?></h1>

<?php 
// $this->widget('zii.widgets.CDetailView', array(
// 	'data'=>$model,
// 	'attributes'=>array(
// 		'id',
// 		'name_ms_teams',
// 		'detail_ms_teams',
// 		'start_date',
// 		'end_date',
// 		'active',
// 		'create_by',
// 		'create_date',
// 		'update_date',
// 		'update_by',
// 	),
// )
// ); 


$this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
	array(
		'name'=>'id',
		'type'=>'raw',
		'value'=> $model->id
	),
	
	array(
		'name'=>'name_ms_teams',
		'value'=> $model->name_ms_teams
	),
	array(
		'name'=>'detail_ms_teams',
		'value'=> $model->detail_ms_teams
	),
	array(
		'name'=>'start_date',
		'value'=> ClassFunction::datethaiTime($model->start_date) 
	),
	array(
		'name'=>'end_date',
		'value'=> ClassFunction::datethaiTime($model->end_date)
	),
	array(
		'name'=>'active',
		'value'=> $model->active
	),
	array(
		'name'=>'create_by',
		'value'=> $model->create_by
	),
	array(
		'name'=>'create_date',
		'value'=> ClassFunction::datethaiTime($model->create_date)
	),
	array(
		'name'=>'update_by',
		'value'=> $model->update_by
	),
	array(
		'name'=>'update_date',
		'value'=> ClassFunction::datethaiTime($model->update_date)
	),
	
),
));


?>
