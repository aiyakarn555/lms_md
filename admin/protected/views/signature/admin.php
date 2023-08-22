<?php
/* @var $this SignatureController */
/* @var $model Signature */

$this->breadcrumbs=array(
	'Signatures'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Signature', 'url'=>array('index')),
	array('label'=>'Create Signature', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#signature-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Signatures</h1>

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
	'id'=>'signature-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'sign_id',
		'sign_title',
		'sign_hide',
		'sign_path',
		'create_date',
		'create_by',
		/*
		'active',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
