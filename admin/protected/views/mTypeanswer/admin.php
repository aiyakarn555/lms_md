<?php
/* @var $this MTypeanswerController */
/* @var $model MTypeanswer */

$this->breadcrumbs=array(
	'Mtypeanswers'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List MTypeanswer', 'url'=>array('index')),
	array('label'=>'Create MTypeanswer', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#mtypeanswer-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Mtypeanswers</h1>

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
	'id'=>'mtypeanswer-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'Tan_nID',
		'Tan_cNameTH',
		'Tan_cNameEN',
		'Tan_cDescriptionTH',
		'Tan_cDescriptionEN',
		'Tan_cRulesTH',
		/*
		'Tan_cRulesEN',
		'cCreateBy',
		'dCreateDate',
		'cUpdateBy',
		'dUpdateDate',
		'cActive',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
