<?php
$this->breadcrumbs=array(
	'ระบบรุ่นหลักสูตร',
	$model->gen_title,
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		// 'gen_id',
		array(
			'name'=>'course_id',
			'type'=>'raw',
			'value'=> function ($data){
				return $data->course->course_title;
			}
		),
		// 'course_id',
		'gen_period_start',
		'gen_period_end',
		'gen_title',
		'gen_person',
		'status',
		array(
			'name'=>'create_by',
			'type'=>'raw',
			'value'=> function ($data){
				return $data->create->profile->firstname.' '.$data->create->profile->lastname;
			}
		),
		array(
			'name'=>'create_date',
			'type'=>'raw',
			'value'=> function ($data){
				return Helpers::lib()->changeFormatDate($data->create_date,'datetime');
			}
		),
		array(
			'name'=>'update_by',
			'type'=>'raw',
			'value'=> function ($data){
				return $data->create->profile->firstname.' '.$data->create->profile->lastname;
			}
		),
		array(
			'name'=>'update_date',
			'type'=>'raw',
			'value'=> function ($data){
				return Helpers::lib()->changeFormatDate($data->update_date,'datetime');
			}
		),
	),
)); ?>
