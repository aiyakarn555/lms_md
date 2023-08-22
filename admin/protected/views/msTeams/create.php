
<?php
$this->breadcrumbs=array(
	'ห้องเรียนรู้ทางไกล'=>array('index'),
	'เพิ่มห้องเรียนรู้ทางไกล',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มห้องเรียนรู้ทางไกล',
	'messageError'=>$messageError
)); ?>
