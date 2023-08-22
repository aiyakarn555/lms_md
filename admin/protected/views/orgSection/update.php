<?php
/* @var $this OrgSectionController */
/* @var $model OrgSection */

$this->breadcrumbs=array(
	'จัดการ OrgSection'=>array('index'),
	'แก้ไขOrgSection',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'Validation'=>$Validation,
	'formtext'=>'แก้ไขOrgSection',
)); ?>