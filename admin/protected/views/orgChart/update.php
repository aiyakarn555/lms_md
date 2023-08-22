<?php
/* @var $this OrgChartController */
/* @var $model OrgChart */

$this->breadcrumbs=array(
	'Org Charts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OrgChart', 'url'=>array('index')),
	array('label'=>'Create OrgChart', 'url'=>array('create')),
	array('label'=>'View OrgChart', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OrgChart', 'url'=>array('admin')),
);
?>

<h1>Update OrgChart <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>