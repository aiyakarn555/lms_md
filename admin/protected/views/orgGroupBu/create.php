<?php
/* @var $this OrgGroupBuController */
/* @var $model OrgGroupBu */

$this->breadcrumbs=array(
	'จัดการ OrgGroupBu'=>array('index'),
	'เพิ่มOrgGroupBu',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มOrgGroupBu',
	'Validation'=>$Validation,
)); ?>