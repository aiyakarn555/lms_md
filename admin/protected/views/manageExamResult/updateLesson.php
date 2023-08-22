
<?php
$this->breadcrumbs=array(
	'จัดการผลการสอบบทเรียน'=>array('ManageLesson'),
	'แก้ไขผลการสอบบทเรียน',
);
?>

<?php 
if($type_cou == 1){
	echo $this->renderPartial('_formLesson', array(
		'model'=>$model,
		'type_cou'=>$type_cou,
		'course_id'=>$course_id,
		'gen_id'=>$gen_id,
		'result_status'=>$result_status,
		'name_id_search'=>$name_id_search,
		'email'=>$email,
		'lesson_id'=>$lesson_id,
		'user_id'=>$user_id,
		'formtext'=>'แก้ไขผลการสอบบทเรียน',
	)); 
}else{
	echo $this->renderPartial('_formLessonMsteams', array(
		'model'=>$model,
		'type_cou'=>$type_cou,
		'course_id'=>$course_id,
		'gen_id'=>$gen_id,
		'result_status'=>$result_status,
		'name_id_search'=>$name_id_search,
		'email'=>$email,
		'lesson_id'=>$lesson_id,
		'user_id'=>$user_id,
		'formtext'=>'แก้ไขผลการสอบบทเรียน',
	)); 
}


?>
