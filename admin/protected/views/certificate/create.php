<?php
/* @var $this CertificateController */
/* @var $model Certificate */

$this->breadcrumbs=array(
	'Certificates'=>array('index'),
	'Create',
);

?>

<?php $this->renderPartial('_form', array('model'=>$model,'formtext'=>'เพิ่มใบประกาศนียบัตร',)); ?>