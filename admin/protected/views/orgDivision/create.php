<?php
/* @var $this OrgDivisionController */
/* @var $model OrgDivision */

$this->breadcrumbs=array(
	'จัดการ OrgDivision'=>array('index'),
	'เพิ่มOrgDivision',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มOrgDivision',
	'Validation'=>$Validation,
)); ?>