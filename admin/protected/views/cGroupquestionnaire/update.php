<?php
/* @var $this CGroupquestionnaireController */
/* @var $model CGroupquestionnaire */

$this->breadcrumbs=array(
	'Cgroupquestionnaires'=>array('index'),
	$model->Gna_nID=>array('view','id'=>$model->Gna_nID),
	'Update',
);

$this->menu=array(
	array('label'=>'List CGroupquestionnaire', 'url'=>array('index')),
	array('label'=>'Create CGroupquestionnaire', 'url'=>array('create')),
	array('label'=>'View CGroupquestionnaire', 'url'=>array('view', 'id'=>$model->Gna_nID)),
	array('label'=>'Manage CGroupquestionnaire', 'url'=>array('admin')),
);
?>

<h1>Update CGroupquestionnaire <?php echo $model->Gna_nID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>