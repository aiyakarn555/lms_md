<?php
/* @var $this FaqController */
/* @var $model Faq */

$this->breadcrumbs=array(
	'Faqs'=>array('index'),
	$model->faq_nid_=>array('view','id'=>$model->faq_nid_),
	'Update',
);

$this->menu=array(
	array('label'=>'List Faq', 'url'=>array('index')),
	array('label'=>'Create Faq', 'url'=>array('create')),
	array('label'=>'View Faq', 'url'=>array('view', 'id'=>$model->faq_nid_)),
	array('label'=>'Manage Faq', 'url'=>array('admin')),
);
?>

<h1>Update Faq <?php echo $model->faq_nid_; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>