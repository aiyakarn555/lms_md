
<?php
$this->breadcrumbs=array(
	'OrgChart'=>array('manageOrg'),
	'แก้ไข',
);
?>
<?php echo $this->renderPartial('_formDivision', array(
	'model'=>$model,
	'formtext'=>'แก้ไข'
)); ?>
