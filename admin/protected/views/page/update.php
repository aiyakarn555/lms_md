<?php
$FormText = 'แก้ไขจำนวนการแสดงผล'; 
$this->breadcrumbs=array( 'ระบบจำนวนการแสดงผล'=>array('index'), $FormText, );
$this->renderPartial('_form', array('model'=>$model,'FormText'=>$FormText, 'alert'=>$alert));
?>