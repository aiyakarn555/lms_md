<?php
/* @var $this CoursecontrolController */
/* @var $model OrgCourse */

$this->breadcrumbs=array(
	'Org Courses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OrgCourse', 'url'=>array('index')),
	array('label'=>'Manage OrgCourse', 'url'=>array('admin')),
);
?>

<h1>Create OrgCourse</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>