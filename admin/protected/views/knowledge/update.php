<?php
$this->breadcrumbs=array(
	'ระบบมุมสารพันความรู้'=>array('index'),
	'แก้ไขมุมสารพันความรู้',
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'formtext'=>'แก้ไขมุมสารพันความรู้','imageShow'=>$imageShow)); ?>