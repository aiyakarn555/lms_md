
<?php
$this->breadcrumbs=array(
	'ระบบบทเรียน'=>array('index'),
	'แก้ไขบทเรียน',
);
?>
<?php echo $this->renderPartial('_form', array('lesson'=>$lesson,'file'=>$file,'imageShow'=>$imageShow,'formtext'=>'แก้ไขบทเรียน')); ?>
