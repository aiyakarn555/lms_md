<?php
/* @var $this TQuestionnairequestionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tquestionnairequestions',
);

$this->menu=array(
	array('label'=>'Create TQuestionnairequestion', 'url'=>array('create')),
	array('label'=>'Manage TQuestionnairequestion', 'url'=>array('admin')),
);
?>

<h1>Tquestionnairequestions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
