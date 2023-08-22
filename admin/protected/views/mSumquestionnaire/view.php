<?php
/* @var $this MSumquestionnaireController */
/* @var $model MSumquestionnaire */

$this->breadcrumbs=array(
	'Msumquestionnaires'=>array('index'),
	$model->Sna_nID,
);

$this->menu=array(
	array('label'=>'List MSumquestionnaire', 'url'=>array('index')),
	array('label'=>'Create MSumquestionnaire', 'url'=>array('create')),
	array('label'=>'Update MSumquestionnaire', 'url'=>array('update', 'id'=>$model->Sna_nID)),
	array('label'=>'Delete MSumquestionnaire', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Sna_nID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MSumquestionnaire', 'url'=>array('admin')),
);
?>

<h1>View MSumquestionnaire #<?php echo $model->Sna_nID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Sna_nID',
		'cCreateBy',
		'dCreateDate',
		'cUpdateBy',
		'dUpdateDate',
		'cActive',
		'Que_nID',
		'Cho_nID',
	),
)); ?>
