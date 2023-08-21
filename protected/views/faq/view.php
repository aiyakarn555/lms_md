<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->breadcrumbs=array(
	'Faqs'=>array('index'),
	$model->faq_nid_,
);

$this->menu=array(
	array('label'=>'List Faq', 'url'=>array('index')),
	array('label'=>'Create Faq', 'url'=>array('create')),
	array('label'=>'Update Faq', 'url'=>array('update', 'id'=>$model->faq_nid_)),
	array('label'=>'Delete Faq', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->faq_nid_),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Faq', 'url'=>array('admin')),
);
?>

<h1>View Faq #<?php echo $model->faq_nid_; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'faq_nid_',
		'faq_ENtopic',
		'faq_THtopic',
		'faq_ENanswer',
		'faq_THanswer',
		'faq_type_id',
		'faq_hideStatus',
		'create_date',
		'create_by',
		'update_date',
		'update_by',
		'active',
	),
)); ?>
