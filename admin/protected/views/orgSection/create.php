<?php
/* @var $this OrgSectionController */
/* @var $model OrgSection */

$this->breadcrumbs=array(
	'จัดการ OrgSection'=>array('index'),
	'เพิ่มOrgSection',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มOrgSection',
	'Validation'=>$Validation,
)); ?>