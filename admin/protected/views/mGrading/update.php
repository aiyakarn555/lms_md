<?php
/* @var $this MGradingController */
/* @var $model MGrading */

$this->breadcrumbs=array(
	'Mgradings'=>array('index'),
	$model->Gra_nID=>array('view','id'=>$model->Gra_nID),
	'Update',
);

$this->menu=array(
	array('label'=>'List MGrading', 'url'=>array('index')),
	array('label'=>'Create MGrading', 'url'=>array('create')),
	array('label'=>'View MGrading', 'url'=>array('view', 'id'=>$model->Gra_nID)),
	array('label'=>'Manage MGrading', 'url'=>array('admin')),
);
?>

<h1>Update MGrading <?php echo $model->Gra_nID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>