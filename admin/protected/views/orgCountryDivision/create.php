<?php
/* @var $this OrgCountryDivisionController */
/* @var $model OrgCountryDivision */

$this->breadcrumbs=array(
	'จัดการ OrgCountryDivision'=>array('index'),
	'เพิ่มOrgCountryDivision',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มOrgCountryDivision',
	'Validation'=>$Validation,
)); ?>