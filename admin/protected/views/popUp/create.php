<?php
/* @var $this PopupController */
/* @var $model Popup */

$this->breadcrumbs=array(
	'manage popup'=>array('admin'),
	'add',
);
?>
<?php $this->renderPartial('_form', array('model'=>$model,'formtext'=>'add','notsave'=>$notsave)); ?>