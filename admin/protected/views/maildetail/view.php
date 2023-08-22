<?php
/* @var $this MaildetailController */
/* @var $model Maildetail */

$this->breadcrumbs=array(
	'Maildetails'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Maildetail', 'url'=>array('index')),
	array('label'=>'Create Maildetail', 'url'=>array('create')),
	array('label'=>'Update Maildetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Maildetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Maildetail', 'url'=>array('admin')),
);
?>

<h1>View Maildetail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'mail_title',
		'mail_detail',
		'create_date',
		'active',
	),
)); ?>
