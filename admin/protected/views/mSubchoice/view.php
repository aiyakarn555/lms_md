<?php
/* @var $this MSubchoiceController */
/* @var $model MSubchoice */

$this->breadcrumbs=array(
	'Msubchoices'=>array('index'),
	$model->Sch_nID,
);

$this->menu=array(
	array('label'=>'List MSubchoice', 'url'=>array('index')),
	array('label'=>'Create MSubchoice', 'url'=>array('create')),
	array('label'=>'Update MSubchoice', 'url'=>array('update', 'id'=>$model->Sch_nID)),
	array('label'=>'Delete MSubchoice', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Sch_nID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MSubchoice', 'url'=>array('admin')),
);
?>

<h1>View MSubchoice #<?php echo $model->Sch_nID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Sch_nID',
		'Sch_cNameTH',
		'Sch_cNameEN',
		'Cho_nScore',
		'stat_txt',
		'cCreateBy',
		'dCreateDate',
		'cUpdateBy',
		'dUpdateDate',
		'cActive',
		'Cho_nID',
		'Tan_nID',
	),
)); ?>
