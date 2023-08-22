<?php
/* @var $this OrgCountryCompanyController */
/* @var $model OrgCountryCompany */

$this->breadcrumbs=array(
	'จัดการ OrgCountryCompany'=>array('index'),
	'แก้ไขOrgCountryCompany',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'Validation'=>$Validation,
	'formtext'=>'แก้ไขOrgCountryCompany',
)); ?>