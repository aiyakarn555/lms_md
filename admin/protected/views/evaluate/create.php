<?php
$this->breadcrumbs=array(
	'ระบบแบบสอบถามความพึงพอใจ'=>array('index'),
	'เพิ่มแบบสอบถามความพึงพอใจ',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มแบบสอบถามความพึงพอใจ'
)); ?>