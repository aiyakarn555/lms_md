<?php
/* @var $this OrgCountrySectionController */
/* @var $model OrgCountrySection */

$this->breadcrumbs=array(
	'จัดการ OrgCountrySection'=>array('index'),
	'แก้ไขOrgCountrySection',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'Validation'=>$Validation,
	'formtext'=>'แก้ไขOrgCountrySection',
)); ?>