
<?php
$this->breadcrumbs=array(
	'จัดการผลการสอบหลักสูตร'=>array('ManageCourse'),
	'แก้ไขผลการสอบหลักสูตร',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
    'type_cou'=>$type_cou,
	'course_id'=>$course_id,
	'gen_id'=>$gen_id,
	'result_status'=>$result_status,
	'name_id_search'=>$name_id_search,
	'email'=>$email,
	'user_id'=>$user_id,
    'formtext'=>'แก้ไขผลการสอบหลักสูตร',
)); ?>
