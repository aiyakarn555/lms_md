<?php
/* @var $this MGroupquestionnaireController */
/* @var $model MGroupquestionnaire */

$this->breadcrumbs=array(
	'Mgroupquestionnaires'=>array('index'),
	$model->Gna_nID=>array('view','id'=>$model->Gna_nID),
	'Update',
);

$this->menu=array(
	array('label'=>'List MGroupquestionnaire', 'url'=>array('index')),
	array('label'=>'Create MGroupquestionnaire', 'url'=>array('create')),
	array('label'=>'View MGroupquestionnaire', 'url'=>array('view', 'id'=>$model->Gna_nID)),
	array('label'=>'Manage MGroupquestionnaire', 'url'=>array('admin')),
);
?>

<h1>Update MGroupquestionnaire <?php echo $model->Gna_nID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>