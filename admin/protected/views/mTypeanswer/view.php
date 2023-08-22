<?php
/* @var $this MTypeanswerController */
/* @var $model MTypeanswer */

$this->breadcrumbs=array(
	'Mtypeanswers'=>array('index'),
	$model->Tan_nID,
);

$this->menu=array(
	array('label'=>'List MTypeanswer', 'url'=>array('index')),
	array('label'=>'Create MTypeanswer', 'url'=>array('create')),
	array('label'=>'Update MTypeanswer', 'url'=>array('update', 'id'=>$model->Tan_nID)),
	array('label'=>'Delete MTypeanswer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Tan_nID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MTypeanswer', 'url'=>array('admin')),
);
?>

<h1>View MTypeanswer #<?php echo $model->Tan_nID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Tan_nID',
		'Tan_cNameTH',
		'Tan_cNameEN',
		'Tan_cDescriptionTH',
		'Tan_cDescriptionEN',
		'Tan_cRulesTH',
		'Tan_cRulesEN',
		'cCreateBy',
		'dCreateDate',
		'cUpdateBy',
		'dUpdateDate',
		'cActive',
	),
)); ?>
