
<?php
$this->breadcrumbs=array(
	'ห้องเรียนรู้ทางไกล(สถาบัน)'=>array('index'),
	'เพิ่มห้องเรียนรู้ทางไกล(สถาบัน)',
);
?>
<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'formtext'=>'เพิ่มห้องเรียนรู้ทางไกล(สถาบัน)',
	'messageError'=>$messageError
)); ?>
