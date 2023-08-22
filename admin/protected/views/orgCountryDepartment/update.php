<?php
/* @var $this OrgCountryDepartmentController */
/* @var $model OrgCountryDepartment */

$this->breadcrumbs=array(
	'จัดการ OrgCountryDepartment'=>array('index'),
	'แก้ไขOrgCountryDepartment',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'Validation'=>$Validation,
	'formtext'=>'แก้ไขOrgCountryDepartment',
)); ?>