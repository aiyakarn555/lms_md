<?php
/* @var $this OrgGroupBuController */
/* @var $model OrgGroupBu */

$this->breadcrumbs=array(
	'จัดการ OrgGroupBu'=>array('index'),
	'แก้ไขOrgGroupBu',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'Validation'=>$Validation,
	'formtext'=>'แก้ไขOrgGroupBu',
)); ?>