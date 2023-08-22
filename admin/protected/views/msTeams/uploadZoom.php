
<?php
$this->breadcrumbs=array(
	'ห้องเรียนรู้ทางไกล'=>array('index'),
	'อัปโหลดรูปภาพ',
);
?>

<?php echo $this->renderPartial('form_upload', array(
	'model'=>$model,
	'formtext'=>'อัปโหลดรูปภาพ'
)); ?>

