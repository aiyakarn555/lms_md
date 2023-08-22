<?php
/* @var $this CompanyController */
/* @var $model Company */

$this->breadcrumbs=array(
	'Companies'=>array('admin'),
	$model->company_id,
);


?>

<h1>View Company #<?php echo $model->company_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'company_id',
		'company_title',
		'create_date',
	),
)); ?>
