<?php
// $this->headerText = "Update Group";
$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$model->group_name=>array('view','id'=>$model->id),
	'Update',
);
	?>

	<h1>Update Group <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'model_p'=>$model_p,'pController' => $pController)); ?>