<?php
/* @var $this FileEbookController */
/* @var $model FileEbook */

$this->breadcrumbs=array(
	'File Ebooks'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List FileEbook', 'url'=>array('index')),
	array('label'=>'Create FileEbook', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#file-ebook-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage File Ebooks</h1>

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
	'id'=>'file-ebook-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'lesson_id',
		'file_name',
		'filename',
		'length',
		'file_position',
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
