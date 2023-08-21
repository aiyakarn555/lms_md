<?php
/* @var $this TQuestionnairequestionController */
/* @var $model TQuestionnairequestion */

$this->breadcrumbs=array(
	'Tquestionnairequestions'=>array('index'),
	$model->Qna_nID=>array('view','id'=>$model->Qna_nID),
	'Update',
);

$this->menu=array(
	array('label'=>'List TQuestionnairequestion', 'url'=>array('index')),
	array('label'=>'Create TQuestionnairequestion', 'url'=>array('create')),
	array('label'=>'View TQuestionnairequestion', 'url'=>array('view', 'id'=>$model->Qna_nID)),
	array('label'=>'Manage TQuestionnairequestion', 'url'=>array('admin')),
);
?>

<h1>Update TQuestionnairequestion <?php echo $model->Qna_nID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>