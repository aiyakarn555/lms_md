<?php
/* @var $this OrgSubSectionController */
/* @var $model OrgSubSection */

$this->breadcrumbs=array(
	'จัดการ OrgSubSection'=>array('index'),
	'แก้ไขOrgSubSection',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'Validation'=>$Validation,
	'formtext'=>'แก้ไขOrgSubSection',
)); ?>