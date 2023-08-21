<?php
/* @var $this MGradingController */
/* @var $model MGrading */

$this->breadcrumbs=array(
	'Mgradings'=>array('index'),
	$model->Gra_nID,
);

$this->menu=array(
	array('label'=>'List MGrading', 'url'=>array('index')),
	array('label'=>'Create MGrading', 'url'=>array('create')),
	array('label'=>'Update MGrading', 'url'=>array('update', 'id'=>$model->Gra_nID)),
	array('label'=>'Delete MGrading', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Gra_nID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MGrading', 'url'=>array('admin')),
);
?>

<h1>View MGrading #<?php echo $model->Gra_nID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Gra_nID',
		'Gra_nScore',
		'Gra_cDetailTH',
		'Gra_cDetailEN',
		'cCreateBy',
		'dCreateDate',
		'cUpdateBy',
		'dUpdateDate',
		'cActive',
	),
)); ?>
