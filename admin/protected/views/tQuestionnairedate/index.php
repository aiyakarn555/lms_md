<?php
/* @var $this TQuestionnairedateController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tquestionnairedates',
);

$this->menu=array(
	array('label'=>'Create TQuestionnairedate', 'url'=>array('create')),
	array('label'=>'Manage TQuestionnairedate', 'url'=>array('admin')),
);
?>

<h1>Tquestionnairedates</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
