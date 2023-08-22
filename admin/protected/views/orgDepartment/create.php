<?php
/* @var $this OrgDepartmentController */
/* @var $model OrgDepartment */

$this->breadcrumbs=array(
	'จัดการ OrgDepartment'=>array('index'),
	'เพิ่มOrgDepartment',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มOrgDepartment',
	'Validation'=>$Validation,
)); ?>