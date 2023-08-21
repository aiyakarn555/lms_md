<?php
/* @var $this FaqTypeController */
/* @var $model FaqType */

$this->breadcrumbs=array(
	'Faq Types'=>array('index'),
	$model->faq_type_id=>array('view','id'=>$model->faq_type_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List FaqType', 'url'=>array('index')),
	array('label'=>'Create FaqType', 'url'=>array('create')),
	array('label'=>'View FaqType', 'url'=>array('view', 'id'=>$model->faq_type_id)),
	array('label'=>'Manage FaqType', 'url'=>array('admin')),
);
?>

<h1>Update FaqType <?php echo $model->faq_type_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>