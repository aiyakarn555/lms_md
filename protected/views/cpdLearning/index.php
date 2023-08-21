<?php
/* @var $this CpdLearningController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cpd Learnings',
);

$this->menu=array(
	array('label'=>'Create CpdLearning', 'url'=>array('create')),
	array('label'=>'Manage CpdLearning', 'url'=>array('admin')),
);
?>

<h1>Cpd Learnings</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
