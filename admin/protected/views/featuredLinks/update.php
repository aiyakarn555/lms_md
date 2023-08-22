<?php

$this->breadcrumbs=array(
	'ระบบจัดการลิงค์แนะนำ'=>array('admin'),
	'แก้ไขลิงค์แนะนำ',
);
?>
<?php $this->renderPartial('_form', array('model'=>$model,'formtext'=>'แก้ไขลิงค์แนะนำ','notsave'=>$notsave)); ?>