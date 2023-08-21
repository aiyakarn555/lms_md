<?php
/* @var $this MQuestionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mquestions',
);

$this->menu=array(
	array('label'=>'Create MQuestion', 'url'=>array('create')),
	array('label'=>'Manage MQuestion', 'url'=>array('admin')),
);
?>

<h1>Mquestions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
