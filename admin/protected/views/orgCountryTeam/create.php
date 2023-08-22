<?php
/* @var $this OrgCountryTeamController */
/* @var $model OrgCountryTeam */

$this->breadcrumbs=array(
	'จัดการ OrgCountryTeam'=>array('index'),
	'เพิ่มOrgCountryTeam',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มOrgCountryTeam',
	'Validation'=>$Validation,
)); ?>