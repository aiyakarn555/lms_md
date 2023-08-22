<?php

$titleName = 'จัดการรุ่นหลักสูตร';
$formNameModel = 'CourseGeneration';

$this->breadcrumbs=array(
	'จัดการรุ่นหลักสูตร',
);

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    $.fn.yiiGridView.update('$formNameModel-grid', {
	        data: $(this).serialize()
	    });
	    return false;
	});
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$.updateGridView = function(gridID, name, value) {
	    $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
	    $.fn.yiiGridView.update(gridID, {data: $.param(
	        $("#"+gridID+" input, #"+gridID+" .filters select")
	    )});
	}
	$.appendFilter = function(name, varName) {
	    var val = eval("$."+varName);
	    $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("CourseGeneration[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);

?>

<div class="innerLR">
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>

		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<?php if (Controller::PButton(array($formNameModel.".create"))) { ?>
					<div class="btn-group" role="group" aria-label="...">
						<a href="<?= Yii::app()->controller->createUrl('create',['id'=>$_GET['id']]); ?>" type="button" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> เพิ่มรุ่นหลักสูตร</a>
					</div>
				<?php } ?>
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>	
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php
				$this->widget('AGridView', array(
					'id'=> $formNameModel.'-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'selectableRows' => 2,
					'rowCssClassExpression'=>'"items[]_{$data->gen_id}"',
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("CourseGeneration[news_per_page]");
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::PButton(
								array($formNameModel.".Delete", $formNameModel.".MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),						
						array(
							'name'=>'course_id',
							'htmlOptions'=>array('style'=>'text-align: left','width'=>'300px;'),
							'type'=>'html',
							'filter'=>false,
							'value'=> function($data){
								return (!empty($data->course->course_title)) ? $data->course->course_title : 'ยังไม่เพิ่มหลักสูตร';
							}
						),
						'gen_title',
						'gen_detail',
						'gen_detail_en',
						// array(
						// 	'type'=>'raw',
						// 	'value'=>function($data){
						// 		if($data->status == 1){
						// 			return CHtml::link("เปิด",array("/CourseGeneration/Updatestatus","id"=>$data->gen_id ,"course"=>$data->course_id), array("class"=>"btn btn-success"));
						// 		} else {
						// 			return CHtml::link("ปิด",array("/CourseGeneration/Updatestatus","id"=>$data->gen_id,"course"=>$data->course_id), array("class"=>"btn btn-danger"));
						// 		}
						// 	},
						// 	'header'=>'สถานะ',
						// 	'name'=>'status',
						// 	'htmlOptions'=>array('style'=>'text-align: center;'),
						// 	'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
						// ),
						array(
							'name'=>'status',
							'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px;'),
							'type'=>'html',
							'filter'=>false,
							'value'=> function($data){
								if($data->status == 1){
									return CHtml::link("เปิด",array("/CourseGeneration/active","id"=>$data->gen_id), array("class"=>"btn btn-success"));
								} else {
									return CHtml::link("ปิด",array("/CourseGeneration/active","id"=>$data->gen_id), array("class"=>"btn btn-danger"));
								}
							}
						),

						array(
							'name'=>'gen_period_start',
							'type'=>'html',
							'filter'=>false,
							'value'=> function($data){
								return Helpers::lib()->changeFormatDate($data->gen_period_start,'datetime');
							}
						),
						array(
							'name'=>'gen_period_end',
							'type'=>'html',
							'filter'=>false,
							'value'=> function($data){
								return Helpers::lib()->changeFormatDate($data->gen_period_end,'datetime');
							}
						),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array($formNameModel.".*") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton(array("'.$formNameModel.'.*"))' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton(array("'.$formNameModel.'.Update"))' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton(array("'.$formNameModel.'.Delete"))' 
								),
							),
						),
					),
				)); 
				?>
			</div>
		</div>
	</div>

		<?php 
		if(Controller::PButton(array($formNameModel.".Multidelete",$formNameModel.".Delete"))) : ?>
		<!-- Options -->
		<div class="separator top form-inline small">
			<!-- With selected actions -->
			<div class="buttons pull-left">
				<?php echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด","#",array(
					"class"=>"btn btn-primary btn-icon glyphicons circle_minus",
					"onclick"=>"return multipleDeleteNews('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','$formNameModel-grid');"
				)); ?>
			</div>
			<!-- // With selected actions END -->
			<div class="clearfix"></div>
		</div>
		<!-- // Options END -->
	<?php endif; ?>
</div>

<script type="text/javascript">
	
	$(".btn-status-course").change(function () {
			// console.log($(this).val());
			var course_id = $(this).val();
			if($(this).prop("checked") == true){
				// console.log("1");
				var status = 1;
			}else{
				// console.log("2");
				var status = 2;
			}

			$.ajax({
					type: 'POST',
					url: '<?php echo Yii::app()->createAbsoluteUrl("/CourseGeneration/updatestatus"); ?>',
					data: ({
						course_id: course_id,
						status: status,
					}),
					success: function(data) {
						console.log("success");
					}
				});

		});

</script>