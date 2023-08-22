<?php
$titleName = 'การอนุมัติการดาวน์โหลด';
$formNameModel = 'LibraryRequest';

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
	$.appendFilter("LibraryRequest[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>
<?php 

	?>
<div class="innerLR">
	
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<form action="download" method="GET">
					<div class="row">
						<div class="col-md-1 text-right">
							<h5>สถานะ :</h5>
						</div>
						<div class="col-md-8">
							<select class="form-control" name="LibraryRequest[req_status]" style="width: 200px;">
								<option >ทั้งหมด</option>
								<option value="1" <?php if(isset($_GET['LibraryRequest']['req_status']) && $_GET['LibraryRequest']['req_status'] == 1){ echo "selected"; } ?>>รอการอนุมัติ</option>
								<option value="2" <?php if(isset($_GET['LibraryRequest']['req_status']) && $_GET['LibraryRequest']['req_status'] == 2){ echo "selected"; } ?>>อนุมัติ</option>
								<option value="3" <?php if(isset($_GET['LibraryRequest']['req_status']) && $_GET['LibraryRequest']['req_status'] == 3){ echo "selected"; } ?>>ปฏิเสธ</option>
							</select>
						</div>
					</div>
					<div class="row" style="padding-top: 20px;">
						<div class="col-md-1"></div>
						<div class="col-md-8">
							<button class="btn btn-primary" type="submit">ค้นหา</button>
						</div>
					</div>
				</form>
				<hr>

				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>	
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php $this->widget('AGridView', array(
					'id'=>$formNameModel.'-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'selectableRows' => 2,
					'rowCssClassExpression'=>'"items[]_{$data->req_id}"',
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("LibraryRequest[news_per_page]");
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
						// array(
						// 	'visible'=>Controller::PButton(array($formNameModel.".MultiDelete")),
						// 	'class'=>'CCheckBoxColumn',
						// 	'id'=>'chk',
						// ),
						array(
							'header'=>'',
							// 'value'=>'$data->req_status',

							'type'=>'raw',
							'filter'=>false,
			                'htmlOptions' => array(
			                   'style' => 'width:20px; text-align: center',
			                ),  
			                'value'=> function ($data){
			                	if($data->req_status == 1){
			                		return "<input type='checkbox' value='".$data->req_id."' onclick='chkbox_app(this)' class='chkboxapp'>";
			                	}elseif($data->req_status == 2){
			                		// return "<font color='green'>อนุมัติ</font>";

			                	}elseif($data->req_status == 3){
			                		return "<input type='checkbox' value='".$data->req_id."' onclick='chkbox_app(this)' class='chkboxapp'>";
			                	}
			                }
						),

						array(
							'name'=>'user_id',
							// 'value'=>'$data->usercreate->profile->firstname',
							'filter'=>false,
			                'htmlOptions' => array(
			                   'style' => 'width:130px',
			                ),  
			                'value'=> function ($data){
			                	return $data->usercreate->profile->firstname." ".$data->usercreate->profile->lastname;
			                }
						),
						array(
							'name'=>'library_id',
							'value'=>'$data->file->library_name',
							'filter'=>false,
			                'htmlOptions' => array(
			                   'style' => 'width:130px',
			                ),  
						),
						array(
							'name'=>'req_status',
							// 'value'=>'$data->req_status',

							'type'=>'raw',
							'filter'=>false,
			                'htmlOptions' => array(
			                   'style' => 'width:130px',
			                ),  
			                'value'=> function ($data){
			                	if($data->req_status == 1){
			                		return "<font color='orange'>รอการอนุมัติ</font>";
			                	}elseif($data->req_status == 2){
			                		return "<font color='green'>อนุมัติ</font>";

			                	}elseif($data->req_status == 3){
			                		return "<font color='red'>ปฏิเสธ</font>";
			                	}
			                }
						),
						array(
							'name'=>'created_date',
							'value'=>'$data->created_date',
							'filter'=>false,
			                'htmlOptions' => array(
			                   'style' => 'width:130px',
			                ),  
			                // 'value'=> function ($data){

			                // }
						),
						array(
							'header'=>'จัดการ',							
							'type'=>'raw',
							'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px'),
							'value'=> function ($data){
								if($data->req_status == 1){
	return CHtml::button("อนุมัติ", array("class"=>"btn btn-success btn-icon", "onclick"=>"acceptF(".$data->req_id.")"))." ".CHtml::button("ปฏิเสธ", array("class"=>"btn btn-danger btn-icon", "onclick"=>'rejectF('.$data->req_id.')'));
								}elseif($data->req_status == 2){
	return CHtml::button("ปฏิเสธ", array("class"=>"btn btn-danger btn-icon", 'onclick' => 'rejectF('.$data->req_id.')'));
								}elseif($data->req_status == 3){
	return CHtml::button("อนุมัติ", array("class"=>"btn btn-success btn-icon", 'onclick' => 'acceptF('.$data->req_id.')'));
								}
							}
							// 'value'=>'CHtml::link("เลือกข้อสอบ (".$data->getCountTest("course").")", array(
					  //     		"CourseOnline/Formcourse",
					  //     		"id"=>$data->course_id,
					  //     		"type"=>"course"
					  //     		), array(
							// 	"class"=>"btn btn-primary btn-icon"
						 //    )); ',
						),

				  //       array(
						// 	'type'=>'raw',
						// 	'value'=>'CHtml::link("<i></i>","", array("class"=>"glyphicons move btn-action btn-inverse"))',
						// 	'htmlOptions'=>array('style'=>'text-align: center; width:50px;', 'class'=>'row_move'),
						// 	'header' => 'ย้าย',
						// 	'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
						// ),						
						// array(            
						// 	'class'=>'AButtonColumn',
						// 	'visible'=>Controller::PButton( 
						// 		array("LibraryRequest.*", "LibraryRequest.View", "LibraryRequest.Update", "LibraryRequest.Delete") 
						// 	),
						// 	'buttons' => array(
						// 		'view'=> array( 
						// 			'visible'=>'Controller::PButton( array("LibraryRequest.*", "LibraryRequest.View") )' 
						// 		),
						// 		'update'=> array( 
						// 			'visible'=>'Controller::PButton( array("LibraryRequest.*", "LibraryRequest.Update") )' 
						// 		),
						// 		'delete'=> array( 
						// 			'visible'=>'Controller::PButton( array("LibraryRequest.*", "LibraryRequest.Delete") )' 
						// 		),
						// 	),
						// ),
					),
				)); ?>
			</div>
		</div>
	</div>	


	<div class="row">
		<div class="col-md-12">
			<button class="btn btn-defualt btn-icon" onclick="btn_app()"> อนุมัติทั้งหมด</button>
		</div>
	</div>



</div>



<script type="text/javascript">
	function chkbox_app(tag){
		// console.log(tag);
	}

	var arr_chkbox = [];
	function btn_app(){
		arr_chkbox = [];
		$( ".chkboxapp" ).each(function( index ) {
			if($(this).prop("checked") == true){
				arr_chkbox.push($(this).val());
				// console.log($(this).val());
			}
		});
		// console.log(arr_chkbox.length);

		if(arr_chkbox.length < 0){
			alert("กรุณาเลือกรายการก่อน");
		}else{
			approve_all();
		}
	}

	function approve_all(){
		$.ajax({
			url : 'approveall',
			data : {
				arr_chkbox:arr_chkbox,
			},
			type : 'POST',
			success : function(data){
				if(data != "error"){
					window.location.reload();
				}else{
					alert("ทำรายการใหม่");
				}                 
			},              
		});
	}


	function acceptF(library){
		swal({
			title: 'ยืนยันใช่ไหม',
			text: "ที่จะอนุมัติการดาวน์โหลด",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'ยืนยัน',
			cancelButtonText: 'ยกเลิก'
		}, function(isConfirm) {
			if (isConfirm) {
				$.ajax({
					url : 'accept',
					data : {
						id:library,
					},
					type : 'GET',
					success : function(data){
						if(data != "error"){
							window.location.reload();
						}else{
							alert("ทำรายการใหม่");
						}                 
					},              
				});
			}
		});
	}

	function rejectF(library){
		swal({
			title: 'ยืนยันใช่ไหม',
			text: "ที่จะปฏิเสธการดาวน์โหลด",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'ยืนยัน',
			cancelButtonText: 'ยกเลิก'
		}, function(isConfirm) {
			if (isConfirm) {
				$.ajax({
					url : 'reject',
					data : {
						id:library,
					},
					type : 'GET',
					success : function(data){
						if(data != "error"){
							window.location.reload();							
						}else{
							alert("ทำรายการใหม่");
						}                 
					},              
				});
			}
		});
		
	}



</script>