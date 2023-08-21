<?php
/* @var $this TQuestionnairequestionController */
/* @var $model TQuestionnairequestion */

$this->breadcrumbs=array(
	'Tquestionnairequestions'=>array('index'),
	$model->Qna_nID,
);

$this->menu=array(
	array('label'=>'List TQuestionnairequestion', 'url'=>array('index')),
	array('label'=>'Create TQuestionnairequestion', 'url'=>array('create')),
	array('label'=>'Update TQuestionnairequestion', 'url'=>array('update', 'id'=>$model->Qna_nID)),
	array('label'=>'Delete TQuestionnairequestion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Qna_nID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TQuestionnairequestion', 'url'=>array('admin')),
);
?>

<h1>View TQuestionnairequestion #<?php echo $model->Qna_nID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Qna_nID',
		'Que_cNameTH',
		'Que_cNameEN',
		'cCreateBy',
		'dCreateDate',
		'cUpdateBy',
		'dUpdateDate',
		'cActive',
		'Que_nID',
		'Yna_nID',
	),
)); ?>
