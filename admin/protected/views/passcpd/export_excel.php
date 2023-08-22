<?php
$titleName = 'ระบบReport ผู้ผ่านการเรียน';
$formNameModel = 'Passcours';

$this->breadcrumbs=array($titleName);

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    $.fn.yiiGridView.update('$formNameModel-grid', {
	        data: $(this).serialize()
	    });
	    return false;
	});
	$('#export').click(function(){
	   	window.location = '". $this->createUrl('//Passcours/ReportPass')  . "?' + $(this).parents('form').serialize() + '&export=true';
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
	$.appendFilter("Passcours[news_per_page]", "news_per_page");
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
				<!--span class="pull-left">
					<?php echo CHtml::tag('button',array(
						'class' => 'btn btn-primary btn-icon glyphicons print',
						'id'=> 'export',
					),'<i></i>ออกรายงาน'); ?>
				</span-->
<!--				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>	-->
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php


				$this->widget('AGridView', array(
					'id'=>$formNameModel.'-grid',
					'dataProvider'=>$model->passcourscheck()->highsearch(),
					'filter'=>$model,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Passcours[news_per_page]");	
						InitialSortTable();
						$("#passcours_date").datepicker({
						   	"dateFormat": "dd/mm/yy",
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
                                                        'header'=>'ลำดับที่',
                                                        'value'=>'$row+1',  //  row is zero based
                                                    'htmlOptions' => array(
						    	'width'=>'5%',
                                                        'style' => 'text-align:center;',
						  	),
                                                ),
                                                array(
							'header' => 'รหัสบัตรประชาชน',
							'type' => 'raw',
							'value' => function($data) {
								return $data->user->bookkeeper_id;
							},
						),
                                                array(
							'header' => 'รหัสผู้ทำบัญชี',
							'type' => 'raw',
							'value' => function($data) {
								return $data->user->bookkeeper_id;
							},
						),
                                                array(
							'header' => 'เลขทะเบียนผู้สอบบัญชี',
							'type' => 'raw',
							'value' => function($data) {
								return $data->user->auditor_id;
							},
						),
						array(
							'header' => 'ชื่อ - สกุล',
//							'name'=>'passcours_user',
							'filter'=>CHtml::activeTextField($model,'user_name'),
							'type' => 'raw',
							'value'=>'$data->NameUser',
						    'htmlOptions' => array(
						    	'width'=>'120',
						  	),
						),
						array(
                                                        'header' => 'วันที่สมัครเป็นสมาชิก',
							'value' => function($data) {
								return Helpers::lib()->changeFormatDate($data->user->create_at, 'datetime');
							},
						    'htmlOptions' => array(
						    	'width'=>'110',
						    	'style' => 'text-align:center;',
						  	),
						    ),
                                                array(
                                                        'header' => 'วันที่เข้าอบรม',
//							'name'=>'passcours_date',
							'value' => function($data) {
								return Helpers::lib()->changeFormatDate($data->passcours_date, 'datetime');
							},
						    'htmlOptions' => array(
						    	'width'=>'110',
						    	'style' => 'text-align:center;',
						  	),
						    ),
                                                    array(
                                                        'header' => 'วันที่จบการอบรม',
//							'name'=>'passcours_date',
							'value' => function($data) {
								return Helpers::lib()->changeFormatDate($data->passcours_date, 'datetime');
							},
						    'htmlOptions' => array(
						    	'width'=>'110',
						    	'style' => 'text-align:center;',
						  	),
						    ),
                                                    array(
                                                        'header' => 'วันที่พิมพ์ใบรับรอง(สอบผ่าน 60%)',
//							'name'=>'passcours_date',
							'value' => function($data) {
								return Helpers::lib()->changeFormatDate($data->passcours_date, 'datetime');
							},
						    'htmlOptions' => array(
						    	'width'=>'110',
						    	'style' => 'text-align:center;',
						  	),
						    ),
						array(
							'header' => 'ประเภทสมาชิก',
							'type' => 'html',
							'value' => function($data) {
								return $data->Profiles->Type->name;
							},
						),
						array(
							'header' => 'ที่อยู่',
							'type' => 'raw',
							'value' => function($data) {
								return $data->Profiles->address;
							},
						),
                                                                array(
							'header' => 'เบอร์โทร',
							'type' => 'raw',
							'value' => function($data) {
								return $data->Profiles->phone;
							},
						),
                                                                array(
							'header' => 'อีเมลล์',
							'type' => 'raw',
							'value' => function($data) {
								return $data->user->email;
							},
						),
					),
				)); ?>
			</div>
		</div>
	</div>
</div>
