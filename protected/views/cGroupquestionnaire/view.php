<?php
/* @var $this CGroupquestionnaireController */
/* @var $model CGroupquestionnaire */

$this->breadcrumbs=array(
	'Cgroupquestionnaires'=>array('index'),
	$model->Gna_nID,
);

$this->menu=array(
	array('label'=>'List CGroupquestionnaire', 'url'=>array('index')),
	array('label'=>'Create CGroupquestionnaire', 'url'=>array('create')),
	array('label'=>'Update CGroupquestionnaire', 'url'=>array('update', 'id'=>$model->Gna_nID)),
	array('label'=>'Delete CGroupquestionnaire', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Gna_nID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CGroupquestionnaire', 'url'=>array('admin')),
);
?>

<h1>View CGroupquestionnaire #<?php echo $model->Gna_nID; ?></h1>

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
