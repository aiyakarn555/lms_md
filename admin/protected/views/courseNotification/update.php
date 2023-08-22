<?php
/* @var $this CourseNotificationController */
/* @var $model CourseNotification */

$this->breadcrumbs=array(
	'ตั้งค่าการแจ้งเตือนบทเรียน'=>array('index'),
	'แก้ไขระบบแจ้งเตือนบทเรียน',
);
$formtext = 'แก้ไขระบบแจ้งเตือนบทเรียน';
?>

<?php $this->renderPartial('_form', array('model'=>$model,'formtext'=>'แก้ไขระบบแจ้งเตือนบทเรียน')); ?>