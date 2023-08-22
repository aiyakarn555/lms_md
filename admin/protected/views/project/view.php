<?php
$this->breadcrumbs=array(
	'ระบบโครงการ'=>array('index'),
	$model->name,
);
?>

<div class="innerLR">
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> รายละเอียดข้อมูล</h4>
		</div>
		<div class="widget-body">

			<?php
			$attributes = array(
				'name',
				array(
					'name' => 'start_date',
					'value' => ClassFunction::datethai($model->start_date,true,true,false)
				),
				array(
					'name' => 'expire_date',
					'value' => ClassFunction::datethai($model->expire_date,true,true,false)
				),
				array(
					'name' => 'university_ids',
					'value' => getUniversities($model)
				)
			);

			$this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'htmlOptions' => array('class'=>'table table-bordered table-striped'),
				'itemTemplate'=> "<tr class=\"{class}\"><th class='span3'>{label}</th><td>{value}</td></tr>\n",
				'itemCssClass' => array('odd','even'),
				'attributes'=>$attributes,
			));

			function getUniversities($model){
				$universityName = array();
				if(count($model->universities) > 0){
					foreach($model->universities as $university){
						$universityName[] = $university->name;
					}
				}
				return implode(", ",$universityName);
			}
			?>

		</div>
	</div>
</div>

