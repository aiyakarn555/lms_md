<?php
/* @var $this MGroupquestionnaireController */
/* @var $model MGroupquestionnaire */

$this->breadcrumbs=array(
	'Mgroupquestionnaires'=>array('index'),
	$model->Gna_nID,
);

$this->menu=array(
	array('label'=>'List MGroupquestionnaire', 'url'=>array('index')),
	array('label'=>'Create MGroupquestionnaire', 'url'=>array('create')),
	array('label'=>'Update MGroupquestionnaire', 'url'=>array('update', 'id'=>$model->Gna_nID)),
	array('label'=>'Delete MGroupquestionnaire', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Gna_nID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MGroupquestionnaire', 'url'=>array('admin')),
);
?>

<h1>View MGroupquestionnaire #<?php echo $model->Gna_nID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Gna_nID',
		'Gna_cNameTH',
		'Gna_cNameEN',
		'Gna_dStart',
		'Gna_dEnd',
		'cCreateBy',
		'dCreateDate',
		'cUpdateBy',
		'dUpdateDate',
		'cActive',
	),
)); ?>
