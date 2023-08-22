<?php
/* @var $this LevelController */
/* @var $model Level */

$this->breadcrumbs=array(
	'กำหนดการเปิดใช้กลุ่ม + Login'=>array('index'),
	$model->level_name,
);
?>

<div class="innerLR">
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> รายละเอียดข้อมูล</h4>
		</div>
		<div class="widget-body">

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'htmlOptions' => array('class'=>'table table-bordered table-striped'),
			'itemTemplate'=> "<tr class=\"{class}\"><th class='span3'>{label}</th><td>{value}</td></tr>\n",
			'itemCssClass' => array('odd','even'),
			'attributes'=>array(
				'level_name',
				array(
					'name'=>'level_create_date',
					'value'=>ClassFunction::datethai($model->level_create_date,true,true,true),
				),
				array(
					'name'=>'level_create_by',
					'value'=>$model->usercreate->username
				),
				array(
					'name'=>'level_update_date',
					'value'=>ClassFunction::datethai($model->level_update_date,true,true,true),
				),
				array(
					'name'=>'level_update_by',
					'value'=>$model->userupdate->username
				),
			),
		)); ?>

		</div>
	</div>
</div>