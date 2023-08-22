<?php
/* @var $this ManageController */
/* @var $model Manage */

$this->breadcrumbs=array(
	'Manages'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Manage', 'url'=>array('index')),
	array('label'=>'Create Manage', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#manage-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Manages</h1>

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
	'id'=>'manage-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'manage_id',
		'id',
		'group_id',
		'manage_row',
		'create_date',
		'create_by',
		/*
		'update_date',
		'update_by',
		'active',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
