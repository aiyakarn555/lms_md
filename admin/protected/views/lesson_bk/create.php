<?php
$this->breadcrumbs=array(
	'ระบบบทเรียน'=>array('index'),
	'เพิ่มบทเรียน',
);
?>
<?php echo $this->renderPartial('_form', array('lesson'=>$lesson,'file'=>$file,'fileDoc'=>$fileDoc,'filePdf'=>$filePdf,'fileScorm'=>$fileScorm,'fileebook'=>$fileebook,'fileAudio'=>$fileAudio,'formtext'=>'เพิ่มบทเรียน')); ?>

