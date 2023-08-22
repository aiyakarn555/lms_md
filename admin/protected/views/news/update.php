<?php
$this->breadcrumbs=array(
	'ระบบข่าวสารและกิจกรรม'=>array('index'),
	'แก้ไขข่าวสารและกิจกรรม',
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'formtext'=>'แก้ไขข่าวสารและกิจกรรม','imageShow'=>$imageShow)); ?>