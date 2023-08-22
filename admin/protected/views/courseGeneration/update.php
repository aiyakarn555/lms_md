<?php
$this->breadcrumbs=array(
	'ระบบรุ่นหลักสูตร',
	$model->gen_title,
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'formtext'=>'แก้ไขรุ่นหลักสูตร')); ?>