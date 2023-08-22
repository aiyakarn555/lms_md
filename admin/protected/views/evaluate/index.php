
<?php
$titleName = 'ระบบแบบสอบถามความพึงพอใจ';
$formNameModel = 'CourseOnline';

$this->breadcrumbs=array($titleName);
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
	$.appendFilter("CourseOnline[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array('name'=>'course_title','type'=>'text'),
			//array('name'=>'course_point','type'=>'text'),
		),
	));?>
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>	
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php $this->widget('AGridView', array(
					'id'=>$formNameModel.'-grid',
					'dataProvider'=>$model->courseonlinecheck()->search(),
					'filter'=>$model,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("CourseOnline[news_per_page]");
						InitialSortTable();	
				        jQuery("#course_date").datepicker({
						   	"dateFormat": "dd/mm/yy",
						   	"showAnim" : "slideDown",
					        "showOtherMonths": true,
					        "selectOtherMonths": true,
				            "yearRange" : "-5+10", 
					        "changeMonth": true,
					        "changeYear": true,
				            "dayNamesMin" : ["อา.","จ.","อ.","พ.","พฤ.","ศ.","ส."],
				            "monthNamesShort" : ["ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.",
				                "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."],
					   })
					}',
					'columns'=>array(
						array(
							'header'=>'รูปภาพ',
							'type'=>'raw',
							'value'=> 'Controller::ImageShowIndex($data,$data->course_picture)',
							'htmlOptions'=>array('width'=>'110')
						),
						array(
							'name'=>'course_title',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"course_title")'
						),
						array(
							'header'=>'จำนวนแบบสอบถาม',
							'value'=>'$data->EvaluateCount',
					        'htmlOptions'=>array('width'=>'180px','style'=>'text-align:center;'),
				            'headerHtmlOptions'=>array(
				            	'style'=>'text-align:center;'
				            ),
						),
					    array(
					    	'header'=>'ตรวจสอบคำตอบผู้ใช้งาน',
					        'value'=>'CHtml::link("ตรวจสอบคำตอบผู้ใช้งาน", array(
					      		"Evaluate/user",
					      		"id"=>"$data->id"
					      		), array(
								"class"=>"btn btn-primary btn-icon"
						    )); ',
					        'type'=>'raw',
					        'htmlOptions'=>array('width'=>'220px','style'=>'text-align:center;'),
				            'headerHtmlOptions'=>array(
				            	'style'=>'text-align:center;'
				            ),
					    ),
					    array(
					    	'header'=>'เช็คคำถาม',
					        'value'=>'CHtml::link("เช็คคำถาม", array(
					      		"Evaluate/admin",
					      		"id"=>"$data->id"
					      		), array(
								"class"=>"btn btn-primary btn-icon"
						    )); ',
					        'type'=>'raw',
					        'htmlOptions'=>array('width'=>'120px','style'=>'text-align:center;'),
				            'headerHtmlOptions'=>array(
				            	'style'=>'text-align:center;'
				            ),
					    ),
					),
				)); ?>
			</div>
		</div>
	</div>

</div>
