<?php
/* @var $this OrgCountryCompanyController */
/* @var $model OrgCountryCompany */

$this->breadcrumbs=array(
	'จัดการ OrgCountryCompany'=>array('index'),
	'เพิ่มOrgCountryCompany',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มOrgCountryCompany',
	'Validation'=>$Validation,
)); ?>