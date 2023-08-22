<?php
/* @var $this TAnswerquestionnaireController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tanswerquestionnaires',
);

$this->menu=array(
	array('label'=>'Create TAnswerquestionnaire', 'url'=>array('create')),
	array('label'=>'Manage TAnswerquestionnaire', 'url'=>array('admin')),
);
?>

<h1>Tanswerquestionnaires</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
