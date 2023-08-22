<?php
$this->breadcrumbs=array(
	'manage popup'=>array('admin'),
	'edit',
);
?>
<?php $this->renderPartial('_form', array('model'=>$model,'formtext'=>'edit','notsave'=>$notsave,'imageShow'=>$imageShow)); ?>