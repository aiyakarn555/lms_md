<?php
/* @var $this MTitlequestionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Mtitlequestions',
);

$this->menu=array(
	array('label'=>'Create MTitlequestion', 'url'=>array('create')),
	array('label'=>'Manage MTitlequestion', 'url'=>array('admin')),
);
?>

<h1>Mtitlequestions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
