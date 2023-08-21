<?php
/* @var $this TQuestionnairedateController */
/* @var $model TQuestionnairedate */

$this->breadcrumbs=array(
	'Tquestionnairedates'=>array('index'),
	$model->Yna_nID,
);

$this->menu=array(
	array('label'=>'List TQuestionnairedate', 'url'=>array('index')),
	array('label'=>'Create TQuestionnairedate', 'url'=>array('create')),
	array('label'=>'Update TQuestionnairedate', 'url'=>array('update', 'id'=>$model->Yna_nID)),
	array('label'=>'Delete TQuestionnairedate', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Yna_nID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TQuestionnairedate', 'url'=>array('admin')),
);
?>

<h1>View TQuestionnairedate #<?php echo $model->Yna_nID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Yna_nID',
		'Yna_dDate',
		'cCreateBy',
		'dCreateDate',
		'cUpdateBy',
		'dUpdateDate',
		'cActive',
		'Gna_nID',
		'Mem_nID',
	),
)); ?>
