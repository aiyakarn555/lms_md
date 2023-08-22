<?php
/* @var $this OrgSubSectionController */
/* @var $model OrgSubSection */

$this->breadcrumbs=array(
	'จัดการ OrgSubSection'=>array('index'),
	'เพิ่มOrgSubSection',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มOrgSubSection',
	'Validation'=>$Validation,
)); ?>