
<?php
$this->breadcrumbs=array(
	'ระบบบทเรียน(สถาบัน)'=>array('index'),
	'แก้ไขบทเรียน(สถาบัน)',
);
?>
<?php echo $this->renderPartial('_form', array('lesson'=>$lesson,'file'=>$file,'fileDoc'=>$fileDoc,'filePdf'=>$filePdf,'fileScorm'=>$fileScorm,'fileAudio'=>$fileAudio,'imageShow'=>$imageShow,'fileebook'=>$fileebook,'formtext'=>'แก้ไขบทเรียน(สถาบัน)')); ?>
