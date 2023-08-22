<?php
/* @var $this InstitutionController */
/* @var $model Institution */

$this->breadcrumbs=array(
	'รหัสหลักสูตร '=>array('index'),
	$model->id,
);

?>

<h1>View รหัสหลักสูตร #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code_gm',
		'code_md',
		'name_md',
		'note',
	),
)); ?>
