<?php
/* @var $this OrgcontrolController */
/* @var $model OrgDepart */

$this->breadcrumbs=array(
	'Org Departs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OrgDepart', 'url'=>array('index')),
	array('label'=>'Create OrgDepart', 'url'=>array('create')),
	array('label'=>'View OrgDepart', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OrgDepart', 'url'=>array('admin')),
);
?>

<h1>Update OrgDepart <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>