<?php
/* @var $this FormSurveyController */
/* @var $model FormSurvey */

$this->breadcrumbs=array(
	'Form Surveys'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List FormSurvey', 'url'=>array('index')),
	array('label'=>'Create FormSurvey', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#form-survey-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Form Surveys</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'form-survey-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'fs_id',
		'fs_head',
		'fs_title',
		'fs_type',
		'startdate',
		'enddate',
		/*
		'create_date',
		'create_by',
		'update_date',
		'update_by',
		'active',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
