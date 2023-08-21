<?php
/* @var $this MTitlequestionController */
/* @var $model MTitlequestion */

$this->breadcrumbs=array(
	'Mtitlequestions'=>array('index'),
	$model->Tit_nID,
);

$this->menu=array(
	array('label'=>'List MTitlequestion', 'url'=>array('index')),
	array('label'=>'Create MTitlequestion', 'url'=>array('create')),
	array('label'=>'Update MTitlequestion', 'url'=>array('update', 'id'=>$model->Tit_nID)),
	array('label'=>'Delete MTitlequestion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Tit_nID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MTitlequestion', 'url'=>array('admin')),
);
?>

<h1>View MTitlequestion #<?php echo $model->Tit_nID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Tit_nID',
		'Tit_cNameTH',
		'Tit_cNameEN',
		'Tit_cDetailTH',
		'Tit_cDetailEN',
		'cCreateBy',
		'dCreateDate',
		'cUpdateBy',
		'dUpdateDate',
		'cActive',
	),
)); ?>
