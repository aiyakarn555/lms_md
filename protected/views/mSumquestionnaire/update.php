<?php
/* @var $this MSumquestionnaireController */
/* @var $model MSumquestionnaire */

$this->breadcrumbs=array(
	'Msumquestionnaires'=>array('index'),
	$model->Sna_nID=>array('view','id'=>$model->Sna_nID),
	'Update',
);

$this->menu=array(
	array('label'=>'List MSumquestionnaire', 'url'=>array('index')),
	array('label'=>'Create MSumquestionnaire', 'url'=>array('create')),
	array('label'=>'View MSumquestionnaire', 'url'=>array('view', 'id'=>$model->Sna_nID)),
	array('label'=>'Manage MSumquestionnaire', 'url'=>array('admin')),
);
?>

<h1>Update MSumquestionnaire <?php echo $model->Sna_nID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>