<?php
$this->breadcrumbs=array(
	'ระบบบทเรียน'=>array('index'),
	'เพิ่มบทเรียน',
);
?>
<?php echo $this->renderPartial('_form', array('lesson'=>$lesson,'file'=>$file,'formtext'=>'เพิ่มบทเรียน')); ?>

