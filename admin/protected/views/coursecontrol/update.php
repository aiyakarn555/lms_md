<?php
/* @var $this CoursecontrolController */
/* @var $model OrgCourse */

$this->breadcrumbs=array(
	'Org Courses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OrgCourse', 'url'=>array('index')),
	array('label'=>'Create OrgCourse', 'url'=>array('create')),
	array('label'=>'View OrgCourse', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OrgCourse', 'url'=>array('admin')),
);
?>

<h1>Update OrgCourse <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>