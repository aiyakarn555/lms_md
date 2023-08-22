
<?php
$this->breadcrumbs=array(
	'OrgChart'=>array('manageOrg'),
	'เพิ่ม',
);
?>
<?php echo $this->renderPartial('_formDivision', array(
	'model'=>$model,
	'formtext'=>'เพิ่ม'
)); ?>
