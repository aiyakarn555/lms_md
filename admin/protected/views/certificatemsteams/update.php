<?php
/* @var $this CertificateController */
/* @var $model Certificate */

$this->breadcrumbs=array(
	'CertificateMsTeams'=>array('index'),
	'แก้ไข',
);

?>
<?php $this->renderPartial('_form', array('model'=>$model,'sign' => $sign,'formtext'=>'แก้ไขใบประกาศนียบัตรห้องเรียนออนไลน์',)); ?>