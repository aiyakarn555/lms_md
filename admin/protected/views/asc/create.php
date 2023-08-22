
<?php
$this->breadcrumbs=array(
	'จัดการหน่วยงาน'=>array('index'),
	'เพิ่มหน่วยงาน',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มหน่วยงาน'
)); ?>
