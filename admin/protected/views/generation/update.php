<?php
/* @var $this GenerationController */
/* @var $model Generation */
$formtext = 'จัดการรุ่น';
$this->breadcrumbs=array(
	'จัดการรุ่น'=>array('index'),
	$model->name=>array('view','id'=>$model->id_gen),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List Generation', 'url'=>array('index')),
	array('label'=>'Create Generation', 'url'=>array('create')),
	array('label'=>'View Generation', 'url'=>array('view', 'id'=>$model->id_gen)),
	array('label'=>'Manage Generation', 'url'=>array('admin')),
);*/
?>

<?php $this->renderPartial('_form', array('model'=>$model,'formtext' => $formtext)); ?>