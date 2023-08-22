<?php
/* @var $this CourseSampleController */
/* @var $model CourseSample */

$this->breadcrumbs=array(
	'ตัวอย่างบทเรียน'=>array('index'),
	'จัดการตัวอย่างบทเรียน',
);

$this->menu=array(
	array('label'=>'ย้อนกลับ', 'url'=>array('index')),
	array('label'=>'สร้างตัวอย่างบทเรียน', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#course-sample-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>จัดการตัวอย่างบทเรียน</h1>

<p>
คุณอาจเลือกที่จะป้อนตัวดำเนินการเปรียบเทียบ (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) ที่จุดเริ่มต้นของแต่ละค่าการค้นหาของคุณเพื่อระบุวิธีการเปรียบเทียบควรทำ
</p>

<?php echo CHtml::link('ค้นหาขั้นสูง','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'course-sample-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'sample_name',
		'sample_detail',
		'file',
		'active',
		'create_date',
		/*
		'update_date',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
