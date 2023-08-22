<?php
/* @var $this CGroupquestionnaireController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cgroupquestionnaires',
);

$this->menu=array(
	array('label'=>'Create CGroupquestionnaire', 'url'=>array('create')),
	array('label'=>'Manage CGroupquestionnaire', 'url'=>array('admin')),
);
?>

<h1>Cgroupquestionnaires</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
