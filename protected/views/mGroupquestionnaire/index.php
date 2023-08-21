<?php
/* @var $this MGroupquestionnaireController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mgroupquestionnaires',
);

$this->menu=array(
	array('label'=>'Create MGroupquestionnaire', 'url'=>array('create')),
	array('label'=>'Manage MGroupquestionnaire', 'url'=>array('admin')),
);
?>

<h1>Mgroupquestionnaires</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
