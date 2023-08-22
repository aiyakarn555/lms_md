<?php
/* @var $this FormSurveyController */
/* @var $model FormSurvey */

// $this->breadcrumbs=array(
// 	'Form Surveys'=>array('index'),
// 	$model->fs_id=>array('view','id'=>$model->fs_id),
// 	'Update',
// );

// $this->menu=array(
// 	array('label'=>'List FormSurvey', 'url'=>array('index')),
// 	array('label'=>'Create FormSurvey', 'url'=>array('create')),
// 	array('label'=>'View FormSurvey', 'url'=>array('view', 'id'=>$model->fs_id)),
// 	array('label'=>'Manage FormSurvey', 'url'=>array('admin')),
// );
?>

<h1>Update FormSurvey <?php //echo $model->fs_id; ?></h1>
<?php if($model=="คุณได้ยืนยันแบบสอบถามแล้วไม่สามารถแก้ไขได้"){
		echo "คุณได้ยืนยันแบบสอบถามแล้วไม่สามารถแก้ไขได้";	
	}
	else
	{
		echo $this->renderPartial('_formupdate', array('model'=>$model,'formtext'=>'แก้ไข')); 
	}
	 ?>
	
