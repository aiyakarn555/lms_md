<?php
/* @var $this PopupController */
/* @var $model Popup */

$this->breadcrumbs=array(
	'manage contactnew'=>array('admin'),
	'add',
);
?>
<?php $this->renderPartial('_form', array('model'=>$model,'notsave'=>$notsave)); ?>