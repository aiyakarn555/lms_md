<?php
/* @var $this MailgroupController */
/* @var $model Mailgroup */

$this->breadcrumbs = array(
    'ระบบส่งเมล์' => array('admin'),
    'เพิ่ม Group Mail',
);
?>

<?php echo $this->renderPartial('_form', array(
    'mailuser'=>$mailuser,
    'model' => $model,
    'formtext' => "เพิ่ม Group Mail",
    'personlist' => $personlist,
    'paidpersons' => $paidpersons,
)); ?>