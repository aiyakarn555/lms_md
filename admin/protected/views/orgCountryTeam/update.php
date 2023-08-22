<?php
/* @var $this OrgCountryTeamController */
/* @var $model OrgCountryTeam */

$this->breadcrumbs=array(
	'จัดการ OrgCountryTeam'=>array('index'),
	'แก้ไขOrgCountryTeam',
);
?>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'Validation'=>$Validation,
	'formtext'=>'แก้ไขOrgCountryTeam',
)); ?>