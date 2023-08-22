<?php
/* @var $this ProjectController */
/* @var $model Project */
$this->breadcrumbs=array(
	'ระบบโครงการ'=>array('index'),
	'เพิ่มโครงการ',
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'formtext'=>'เพิ่มโครงการ')); ?>
