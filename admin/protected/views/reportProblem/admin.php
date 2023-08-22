<?php
/* @var $this ReportProblemController */
/* @var $model ReportProblem */

$this->breadcrumbs=array(
	'Report Problems'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ReportProblem', 'url'=>array('index')),
	array('label'=>'Create ReportProblem', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#report-problem-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Report Problems</h1>

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
	'id'=>'report-problem-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'firstname',
		'lastname',
		'email',
		'tel',
		'report_type',
		array(
			'name'=>'status',
			'value'=>'ReportProblem::itemAlias("UserStatus",$data->status)',
			'filter' => ReportProblem::itemAlias("UserStatus"),
		),
		'report_date',
		'accept_report_date',
		/*
		'report_title',
		'report_detail',
		'report_pic',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{accept} {delete}', // <-- TEMPLATE WITH THE TWO STATES
        	'htmlOptions'=>array(
                'width'=>90,
        ),
        'buttons' => array(
                'accept'=>array(
                        'label'=>'accept',
                        'url'=>'Yii::app()->createUrl("ReportProblem/accept", array("id"=>$data->id))',
                        'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/accept.png',
                ),
        	),
		),
	),
)); ?>
