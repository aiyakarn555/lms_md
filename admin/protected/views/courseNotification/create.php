<?php
/* @var $this CourseNotificationController */
/* @var $model CourseNotification */

$this->breadcrumbs=array(
	'ตั้งค่าการแจ้งเตือนบทเรียน'=>array('index'),
	'เพิ่มระบบแจ้งเตือนบทเรียน',
);

?>

<?php $this->renderPartial('_form', array('model'=>$model,'formtext'=>'เพิ่มระบบแจ้งเตือนบทเรียน')); ?>