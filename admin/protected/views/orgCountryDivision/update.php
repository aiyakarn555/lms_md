<?php
/* @var $this OrgCountryDivisionController */
/* @var $model OrgCountryDivision */

$this->breadcrumbs=array(
	'จัดการ OrgCountryDivision'=>array('index'),
	'แก้ไขOrgCountryDivision',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'Validation'=>$Validation,
	'formtext'=>'แก้ไขOrgCountryDivision',
)); ?>