<?php
/* @var $this OrgDepartmentController */
/* @var $model OrgDepartment */

$this->breadcrumbs=array(
	'จัดการ OrgDepartment'=>array('index'),
	'แก้ไขOrgDepartment',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'Validation'=>$Validation,
	'formtext'=>'แก้ไขOrgDepartment',
)); ?>