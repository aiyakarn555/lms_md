<?php
/* @var $this TAnswerquestionnaireController */
/* @var $model TAnswerquestionnaire */

$this->breadcrumbs=array(
	'Tanswerquestionnaires'=>array('index'),
	$model->Ans_nID=>array('view','id'=>$model->Ans_nID),
	'Update',
);

$this->menu=array(
	array('label'=>'List TAnswerquestionnaire', 'url'=>array('index')),
	array('label'=>'Create TAnswerquestionnaire', 'url'=>array('create')),
	array('label'=>'View TAnswerquestionnaire', 'url'=>array('view', 'id'=>$model->Ans_nID)),
	array('label'=>'Manage TAnswerquestionnaire', 'url'=>array('admin')),
);
?>

<h1>Update TAnswerquestionnaire <?php echo $model->Ans_nID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>