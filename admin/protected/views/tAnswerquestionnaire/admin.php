<?php
/* @var $this TAnswerquestionnaireController */
/* @var $model TAnswerquestionnaire */

$this->breadcrumbs=array(
	'Tanswerquestionnaires'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TAnswerquestionnaire', 'url'=>array('index')),
	array('label'=>'Create TAnswerquestionnaire', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tanswerquestionnaire-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Tanswerquestionnaires</h1>

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
	'id'=>'tanswerquestionnaire-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'Ans_nID',
		'Cho_cNameTH',
		'Cho_cNameEN',
		'Sch_cNameTH',
		'Sch_cNameEN',
		'Ans_Description',
		/*
		'Ans_cOther',
		'Ans_cComment',
		'cCreateBy',
		'dCreateDate',
		'cUpdateBy',
		'dUpdateDate',
		'cActive',
		'Gra_nID',
		'Qna_nID',
		'Cho_nID',
		'Sch_nID',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
