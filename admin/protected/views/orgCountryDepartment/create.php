<?php
/* @var $this OrgCountryDepartmentController */
/* @var $model OrgCountryDepartment */

$this->breadcrumbs=array(
	'จัดการ OrgCountryDepartment'=>array('index'),
	'เพิ่มOrgCountryDepartment',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มOrgCountryDepartment',
	'Validation'=>$Validation,
)); ?>