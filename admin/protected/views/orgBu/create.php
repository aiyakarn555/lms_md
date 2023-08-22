<?php
/* @var $this OrgBuController */
/* @var $model OrgBu */

$this->breadcrumbs=array(
	'จัดการ OrgBu'=>array('index'),
	'เพิ่มOrgBu',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มOrgBu',
	'Validation'=>$Validation,
)); ?>