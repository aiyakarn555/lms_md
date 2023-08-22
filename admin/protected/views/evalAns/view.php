<?php
$this->breadcrumbs=array(
	'ระบบแบบสอบถามความพึงพอใจ'=>array('//Evaluate/index'),
	'รายชื่อผู้ตอบแบบความพึงพอใจ' =>array('//Evaluate/user','id'=>$ans),
	'คำตอบของผู้ใช้',
);

Yii::app()->clientScript->registerScript('export', "
	$('#export').click(function(){
	    window.location = '". $this->createUrl('//EvalAns/ReportUser')  . "?' + $(this).parents('form').serialize() + '&export=true&id=".$id."&ans=".$ans."';
	    return false;
	});
");
?>

<div class="innerLR">
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> คำตอบของผู้ใช้</h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<span class="pull-right">
					<?php echo CHtml::tag('button',array(
						'class' => 'btn btn-primary btn-icon glyphicons print',
						'id'=> 'export',
					),'<i></i>ออกรายงาน'); ?>
				</span>
				<span class="pull-left">
					<label class="strong"><h4><?php echo $modelCourseOnline->course_title; ?></h4></label>
				</span>	
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<br>
				<table width="100%" class="table table-striped table-bordered table-condensed dataTable table-primary" style="background: #fff;">
					<thead>
						<tr>
							<th rowspan="2" style="text-align:center;">หัวข้อแบบสอบถาม</th>
						</tr>
						<tr>
							<th style="text-align:center;">มากที่สุด (5)</th>
							<th style="text-align:center;">มาก (4)</th>
							<th style="text-align:center;">ปานกลาง (3)</th>
							<th style="text-align:center;">น้อย (2)</th>
							<th style="text-align:center;">น้อยที่สุด (1)</th>
						</tr>
					</thead>
					<tbody>

						<?php foreach ($modelEvaluate as $i => $value): ?>
							<tr>
								<td style="width: 25%;">
									<div><?php echo $value->eva->eva_title; ?></div>
								</td>
								<td style="text-align:center;width: 15%;">
									<?php echo CHtml::radioButton("[$i]eval_answer", 
										ClassFunction::_CheckRadio($value->eval_answer,"5"), array(
										'disabled'=>'disabled'
									)); ?>
								</td>
								<td style="text-align:center;width: 15%;">
									<?php echo CHtml::radioButton("[$i]eval_answer", 
										ClassFunction::_CheckRadio($value->eval_answer,"4"), array(
										'disabled'=>'disabled'
									)); ?>
								</td>
								<td style="text-align:center;width: 15%;">
									<?php echo CHtml::radioButton("[$i]eval_answer", 
										ClassFunction::_CheckRadio($value->eval_answer,"3"), array(
										'disabled'=>'disabled'
									)); ?>
								</td>
								<td style="text-align:center;width: 15%;">
									<?php echo CHtml::radioButton("[$i]eval_answer", 
										ClassFunction::_CheckRadio($value->eval_answer,"2"), array(
										'disabled'=>'disabled'
									)); ?>
								</td>
								<td style="text-align:center;width: 15%;">
									<?php echo CHtml::radioButton("[$i]eval_answer", 
										ClassFunction::_CheckRadio($value->eval_answer,"1"), array(
										'disabled'=>'disabled'
									)); ?>
								</td>
							</tr>
						<?php endforeach; ?>	

					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>