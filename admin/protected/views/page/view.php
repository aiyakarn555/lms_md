<?php
/* @var $this PageController */
/* @var $model Page */

$this->breadcrumbs=array(
	'ระบบจำนวนการแสดงผล'=>array('index'),
	$model->page_num,
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
					'page_num',
					array(
						'name'=>'create_date',
						'value'=>ClassFunction::datethai($model->create_date,true,true,true),
					),
					array(
						'name'=>'create_by',
						'value'=>$model->usercreate->username
					),
					array(
						'name'=>'update_date',
						'value'=>ClassFunction::datethai($model->update_date,true,true,true),
					),
					array(
						'name'=>'update_by',
						'value'=>$model->userupdate->username
					),
				),
			)); ?>

		</div>
	</div>
</div>