<?php
/* @var $this OrgDivisionController */
/* @var $model OrgDivision */

$this->breadcrumbs=array(
	'จัดการ OrgDivision'=>array('index'),
	'แก้ไขOrgDivision',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'Validation'=>$Validation,
	'formtext'=>'แก้ไขOrgDivision',
)); ?>