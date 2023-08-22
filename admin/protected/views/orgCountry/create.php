<?php
/* @var $this OrgCountryController */
/* @var $model OrgCountry */

$this->breadcrumbs=array(
	'จัดการ OrgCountry'=>array('index'),
	'เพิ่มOrgCountry',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มOrgCountry',
	'Validation'=>$Validation,
)); ?>