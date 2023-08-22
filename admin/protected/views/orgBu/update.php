<?php
/* @var $this OrgBuController */
/* @var $model OrgBu */

$this->breadcrumbs=array(
	'จัดการ OrgBu'=>array('index'),
	'แก้ไขOrgBu',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'Validation'=>$Validation,
	'formtext'=>'แก้ไขOrgBu',
)); ?>