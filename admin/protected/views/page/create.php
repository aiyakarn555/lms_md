<?php
$FormText = 'เพิ่มจำนวนการแสดงผล'; 
$this->breadcrumbs=array( 'ระบบจำนวนการแสดงผล'=>array('index'), $FormText, );
$this->renderPartial('_form', array('model'=>$model,'FormText'=>$FormText));
?>