<?php
/* @var $this MQuestionController */
/* @var $model MQuestion */

$this->breadcrumbs=array(
	'Mquestions'=>array('index'),
	$model->Que_nID,
);

$this->menu=array(
	array('label'=>'List MQuestion', 'url'=>array('index')),
	array('label'=>'Create MQuestion', 'url'=>array('create')),
	array('label'=>'Update MQuestion', 'url'=>array('update', 'id'=>$model->Que_nID)),
	array('label'=>'Delete MQuestion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Que_nID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MQuestion', 'url'=>array('admin')),
);
?>

<h1>View MQuestion #<?php echo $model->Que_nID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Que_nID',
		'Que_cNameTH',
		'Que_cNameEN',
		'Que_cDetailTH',
		'Que_cDetailEN',
		'cCreateBy',
		'dCreateDate',
		'cUpdateBy',
		'dUpdateDate',
		'cActive',
		'Tit_nID',
		'Tan_nID',
	),
)); ?>
