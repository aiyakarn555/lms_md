<?php
/* @var $this DivisionController */
/* @var $model Division */
$this->breadcrumbs=array(
	'manage language'=>array('admin'),
	'edit',
);


?>
<!-- 
<h1>Update Language <?php echo $model->id; ?></h1> -->

<?php $this->renderPartial('_form', array('model'=>$model,'formtext'=>'edit','imageShow'=>$imageShow)); ?>