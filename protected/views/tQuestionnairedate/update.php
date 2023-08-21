<?php
/* @var $this TQuestionnairedateController */
/* @var $model TQuestionnairedate */

$this->breadcrumbs=array(
	'Tquestionnairedates'=>array('index'),
	$model->Yna_nID=>array('view','id'=>$model->Yna_nID),
	'Update',
);

$this->menu=array(
	array('label'=>'List TQuestionnairedate', 'url'=>array('index')),
	array('label'=>'Create TQuestionnairedate', 'url'=>array('create')),
	array('label'=>'View TQuestionnairedate', 'url'=>array('view', 'id'=>$model->Yna_nID)),
	array('label'=>'Manage TQuestionnairedate', 'url'=>array('admin')),
);
?>

<h1>Update TQuestionnairedate <?php echo $model->Yna_nID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>