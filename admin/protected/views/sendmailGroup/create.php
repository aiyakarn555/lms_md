<?php
/* @var $this SendmailGroupController */
/* @var $model LogSendmailGroup */

$this->breadcrumbs=array(
	'ส่งอีเมล์แบบกลุ่ม'=>array('admin'),
	'ส่งอีเมล์',
);

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>