<?php
/* @var $this MSumquestionnaireController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Msumquestionnaires',
);

$this->menu=array(
	array('label'=>'Create MSumquestionnaire', 'url'=>array('create')),
	array('label'=>'Manage MSumquestionnaire', 'url'=>array('admin')),
);
?>

<h1>Msumquestionnaires</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
