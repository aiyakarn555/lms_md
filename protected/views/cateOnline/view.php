
<?php $this->breadcrumbs=array('นิสิตนักศึกษา'=>array('index'),$model->cate_title);?>
<?php $this->widget('ADetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'Datailhead',
			'value'=>'รายละเอียด'
		),
		array(
			'label'=>'วิดีโอตัวอย่าง',
			'type'=>'raw',
			'value' => $model->VdoEx,
		),
		/*array(
			'name'=>'cate_image',
			'type'=>'raw',
			'value'=> ($model->cate_image)?$model->ImageCheck:'-',
		),*/
		'cate_title',
		array(
			'name'=>'cate_detail',
			'type'=>'html',
			'value'=>$model->cate_detail,
		),
		array(
			'name'=>'CountCourse',
			'value'=>$model->CountCourse
		)
	),
)); ?>

