<?php
/* @var $this FaqTypeController */
/* @var $model FaqType */

$this->breadcrumbs=array(
	'Faq Types'=>array('index'),
	$model->faq_type_id,
);

$this->menu=array(
	array('label'=>'List FaqType', 'url'=>array('index')),
	array('label'=>'Create FaqType', 'url'=>array('create')),
	array('label'=>'Update FaqType', 'url'=>array('update', 'id'=>$model->faq_type_id)),
	array('label'=>'Delete FaqType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->faq_type_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FaqType', 'url'=>array('admin')),
);
?>

<h1>View FaqType #<?php echo $model->faq_type_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'faq_type_id',
		'faq_type_title_TH',
		'faq_type_title_EN',
		'create_date',
		'create_by',
		'update_date',
		'update_by',
		'active',
	),
)); ?>
