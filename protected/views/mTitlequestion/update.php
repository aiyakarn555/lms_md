<?php
/* @var $this MTitlequestionController */
/* @var $model MTitlequestion */

$this->breadcrumbs=array(
	'Mtitlequestions'=>array('index'),
	$model->Tit_nID=>array('view','id'=>$model->Tit_nID),
	'Update',
);

$this->menu=array(
	array('label'=>'List MTitlequestion', 'url'=>array('index')),
	array('label'=>'Create MTitlequestion', 'url'=>array('create')),
	array('label'=>'View MTitlequestion', 'url'=>array('view', 'id'=>$model->Tit_nID)),
	array('label'=>'Manage MTitlequestion', 'url'=>array('admin')),
);
?>

<h1>Update MTitlequestion <?php echo $model->Tit_nID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>