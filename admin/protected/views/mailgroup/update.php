<?php
/* @var $this MailgroupController */
/* @var $model Mailgroup */

$this->breadcrumbs=array(
	'ระบบส่งเมล์'=>array('admin'),
	'แก้ไข Group Mail',
);
?>

<?php echo $this->renderPartial('_form', array(
	'mailuser'=>$mailuser,
	'model'=>$model,
	'personlist'=>$personlist,
	'paidpersons'=>$paidpersons,
	'formtext' => "แก้ไข Group Mail")); ?>