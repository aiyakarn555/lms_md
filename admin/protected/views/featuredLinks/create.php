<?php
//$titleName = 'เพิ่มลิ้งโฆษณา';
//$this->breadcrumbs=array($titleName);
$this->breadcrumbs=array(
	'ระบบจัดการลิงค์แนะนำ'=>array('admin'),
	'เพิ่มลิงค์แนะนำ',
);


?>
<?php $this->renderPartial('_form', array('model'=>$model,'formtext'=>'เพิ่มลิงค์แนะนำ','notsave'=>$notsave)); ?>