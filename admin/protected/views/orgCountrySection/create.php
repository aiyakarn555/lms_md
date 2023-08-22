<?php
/* @var $this OrgCountrySectionController */
/* @var $model OrgCountrySection */

$this->breadcrumbs=array(
	'จัดการ OrgCountrySection'=>array('index'),
	'เพิ่มOrgCountrySection',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มOrgCountrySection',
	'Validation'=>$Validation,
)); ?>