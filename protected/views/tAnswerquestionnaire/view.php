<?php
/* @var $this TAnswerquestionnaireController */
/* @var $model TAnswerquestionnaire */

$this->breadcrumbs=array(
	'Tanswerquestionnaires'=>array('index'),
	$model->Ans_nID,
);

$this->menu=array(
	array('label'=>'List TAnswerquestionnaire', 'url'=>array('index')),
	array('label'=>'Create TAnswerquestionnaire', 'url'=>array('create')),
	array('label'=>'Update TAnswerquestionnaire', 'url'=>array('update', 'id'=>$model->Ans_nID)),
	array('label'=>'Delete TAnswerquestionnaire', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Ans_nID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TAnswerquestionnaire', 'url'=>array('admin')),
);
?>

<h1>View TAnswerquestionnaire #<?php echo $model->Ans_nID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Ans_nID',
		'Cho_cNameTH',
		'Cho_cNameEN',
		'Sch_cNameTH',
		'Sch_cNameEN',
		'Ans_Description',
		'Ans_cOther',
		'Ans_cComment',
		'cCreateBy',
		'dCreateDate',
		'cUpdateBy',
		'dUpdateDate',
		'cActive',
		'Gra_nID',
		'Qna_nID',
		'Cho_nID',
		'Sch_nID',
	),
)); ?>
