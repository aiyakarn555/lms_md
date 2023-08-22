<?php
/* @var $this OrgCountryController */
/* @var $model OrgCountry */

$this->breadcrumbs=array(
	'จัดการ OrgCountry'=>array('index'),
	'แก้ไขOrgCountry',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'Validation'=>$Validation,
	'formtext'=>'แก้ไขOrgCountry',
)); ?>