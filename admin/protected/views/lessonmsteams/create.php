<?php
$this->breadcrumbs=array(
	'ระบบบทเรียนรู้ทางไกล'=>array('index'),
	'เพิ่มบทเรียนรู้ทางไกล',
);
?>
<?php echo $this->renderPartial('_form', array('lesson'=>$lesson,'formtext'=>'เพิ่มบทเรียนรู้ทางไกล','fileDoc'=>$fileDoc)); ?>

