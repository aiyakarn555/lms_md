<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!--Include Date Range Picker--> 
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>


<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('admin'),
	UserModule::t('Manage'),
);
//
	
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
	$.appendFilter("User[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
	?>
	<div id="user" class="innerLR">
		<?php
		$this->widget('AdvanceSearchForm', array(
			'data'=>$model,
			'route' => $this->route,
        //'id'=>'SearchFormAjax',
			'attributes'=>array(
//            array('name'=>'company_id','type'=>'list','query'=>Company::getCompanyList()),
				//array('name'=>'register_status','type'=>'list','query'=>$register_status),
				array('name'=>'register_status','type'=>'list','query'=>User::getregisstatusList()),
				array('name'=>'position_id','type'=>'list','query'=>Position::getPositionListSearch()),
            //array('name'=>'nameSearch','type'=>'text'),
//            array('name'=>'course','type'=>'list','query'=>$model->courseList),
				array('name'=>'create_at','type'=>'text'),

            //array('name'=>'course_point','type'=>'text'),
			),
		));?>
<style type="text/css">
.coolContainer h4:first-of-type {
    float: left;
}
.coolContainer h4:last-of-type {
    float: left;
}

</style>

		<div class="widget" style="margin-top: -1px;">
			<div class="widget-head">
				<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Confirm Registration"); ?></h4>
			</div>
			<div class="widget-body">
				<div>
					<?php echo Rights::t('core', 'ที่นี่คุณสามารถอนุมัติการสมัครสมาชิกให้กับผู้ใช้แต่ละราย'); ?>
				</div>
				<div class="coolContainer">
					<h4 class="name_pos"></h4><h4 class="num"> จำนวนผู้สมัคร <?= $model->searchmembership()->getItemCount(); ?> คน  จาก <?= $model->searchmembership()->getTotalItemCount(); ?> คน</h4>	
				</div>
				<div class="separator bottom form-inline small">
					<span class="pull-right">
						<label class="strong">แสดงแถว:</label>
						<?php echo $this->listPageShow($formNameModel); 
						?>
					</span>
				</div>
				<div class="spacer"></div>
				<div>
					<div class="overflow-table">	
					<!--  < ?php echo CHtml::link(UserModule::t('ค้นหาขั้นสูง'),'#',array('class'=>'search-button')); ?>
					<div class="search-form" style="display:none">
						< ?php $this->renderPartial('_search',array(
							'model'=>$model,
							)); ?>
						</div> --><!-- search-form -->					  
						<?php
							// $this->widget('AGridView', array(
							// 	'id'=>'user-grid',
							// 	'dataProvider'=>$model->searchmembership(),
							// 	'filter'=>$model,
							// 	'afterAjaxUpdate'=>'function(id, data){
							// 		$.appendFilter("[news_per_page]");	
							// 		InitialSortTable();
							// 	}',
							$this->widget('AGridView', array(

									'id'=>$formNameModel.'-grid',
									'dataProvider'=>$model->searchmembership(),
									'filter'=>$model,
									'selectableRows' => 2,
									//'rowCssClassExpression'=>'"items[]_{$data->id}"',
									// 'htmlOptions' => array(
									// 	'style'=> "margin-top: -1px;width:200%;",
									// ),
									'afterAjaxUpdate'=>'function(id, data){
										$.appendFilter("User[news_per_page]");
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
									'header'=>'No.',
									'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
								),
			// 					array(
			// 						'name' => 'idensearch',
			// 						'type'=>'raw',
			// 						'value' => '$data->profile->identification',
			// //'value' => 'CHtml::link(UHtml::markSearch($data, ),array("admin/view","id"=>$data->id))',
			// 					),

								 // array(
         //    // 'name' => 'posts',
         //   				 'header' => 'Post Count',
         //   				 'value' => 'count($data->id)',
        	// 			),
								array(
									'header' => 'ชื่อ - นามสกุล',
									'type'=>'html',
									'value'=>function($data){
										return $data->profile->firstname_en . ' ' . $data->profile->lastname_en;
									}
								),
								array(
									'header' => 'ตำแหน่งที่สมัคร',
									'type'=>'html',
									'value'=>function($data){
										return $data->position->position_title;
									}
								),
								array(
									'header' => 'เงินเดือนที่คาดหวัง',
									'type'=>'html',
									'value'=>function($data){
										return $data->profile->expected_salary;
									}
								),
								array(
									'header' => 'วันที่พร้อมเริ่มทำงาน',
									'type'=>'html',
									'value'=>function($data){
										return Helpers::lib()->changeFormatDateNew($data->profile->start_working,'date');;
									}
								),
								array(
									'header' => 'สถานะ',
									'type'=>'html',
									'value'=>function($data){

										if($data->register_status == 0){
											//echo CHtml::button("ปิด",array("class"=>"btn btn-danger ","data-id" => $data->id));
											echo "รอการตรวจสอบ";
										} else if($data->register_status == 2){
											echo "ไม่อนุมัติ";
										}
									}
								),
								// array(
								// 	'name'=>'email',
								// 	'type'=>'raw',
								// 	'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
								// ),
		// 'create_at',
								array(
									'header' => 'วันที่ลงทะเบียน',
									'type'=>'html',
									'filter' => false,
			// 'value'=>'UHtml::markSearch($data,"create_at")'
									'value'=>function($data){
										return Helpers::changeFormatDate($data->create_at,'datetime');
									},
								),
			// 					array(
			// 						'name'=>'careersearch',
			// 						'type'=>'raw',
			// 						'filter'=>User::getListCareer(),
			// 						'value' => '$data->profile->Career->career',
			// //'value' => 'CHtml::link(UHtml::markSearch($data, ),array("admin/view","id"=>$data->id))',
			// 					),
								// array(
								// 	'name'=>'orgchart_lv2',
								// 	'type'=>'raw',
								// 	'filter' => User::getListOrgCourse(),
								// 	'value'=>function($data){
								// 		$orgCoruse = json_decode($data->orgchart_lv2);
								// 		$criteria=new CDbCriteria;
								// 		$criteria->addInCondition('id', $orgCoruse);
								// 		$org = OrgChart::model()->findAll($criteria);
								// 		foreach ($org as $key => $value) {
								// 			$courseName .= ($key+1).'. '.$value->title.'<br>';
								// 		}
								// 		return $courseName;
								// 	},
								// ),
		// 'lastvisit_at',
								// array(
								// 	'name'=>'superuser',
								// 	'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
								// 	'filter'=>User::itemAlias("AdminStatus"),
								// ),
								array(
									'type'=>'raw',
									'value'=>function($data){
										 if($data->register_status == 0) {
										 	return '<button class="btn btn-info changeStatus" onclick="sendMsg('.$data->id.')" data-id = '.$data->id.'>รอการตรวจสอบ</button>';
										 // CHtml::button("รอการตรวจสอบ",array('onclick'=>'sendMsg('.$data->id.')','class' => 'btn btn-info changeStatus','data-id' =>$data->id));
									} else if($data->register_status == 2){
											echo '<button class="btn btn btn-secondary" onclick="sendMsg()" data-id = '.$data->id.'>ไม่อนุมัติ</button>';
											// CHtml::button("ไม่อนุมัติ",array('onclick'=>'',"class"=>"btn btn btn-secondary","data-id" => $data->id));
										}
									},
									'header' => 'อนุมัติสมัครสมาชิก',
									'htmlOptions'=>array('style'=>'text-align: center;'),
									'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
								),
								array(
									'type'=>'raw',
									'value'=>function($data){	
										echo '<button class="btn btn-success" onclick="sendMsgCheck('.$data->id.')" data-id = '.$data->id.'>ตรวจสอบ</button>';
										// CHtml::button("ตรวจสอบ",array('onclick'=>'sendMsgCheck('.$data->id.')',"class"=>"btn btn-success Check_information","data-id" => $data->id));
									},
									'header' => 'ตรวจสอบข้อมูลการสมัคร',
									'htmlOptions'=>array('style'=>'text-align: center;'),
									'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
								),
								// array(
								// 	'header' => 'พิมพ์ใบสมัคร',
								// 	'type' => 'raw',
								// 	'value' => function($data) {
        //                                        //var_dump($data->id);
        //                                         //return CHtml::button("พิมพ์",array('class' => 'btn btn btn-success print_pdf','data-id' => $data->id));
								// 		return CHtml::button('พิมพ์ใบสมัคร', array('submit' => array('admin/Printpdf', 'id'=> $data->id),'class' => 'btn btn btn-success'));
								// 	},'htmlOptions' => array(
								// 		'style'=> "text-align: center;",
								// 	),
								// ),
								array(
									'header' => 'ดาวน์โหลดเอกสารแนบ',
									'type' => 'raw',
									'value' => function($data) {

										// return CHtml::button('ดาวน์โหลดเอกสารแนบ', array('submit' => array('admin/Attach_load', 'id'=> $data->id),'class' => 'btn btn btn-success'));
										return '<a href="'.$this->createUrl("/user/admin/Attach_load", array("id" => $data->id)).'" class="btn btn btn-success">ดาวน์โหลดเอกสารแนบ</a>';
									},'htmlOptions' => array(
										'style'=> "text-align: center;",
									),
								),
								array(
									'header' => 'หมายเหตุ',
									'type'=>'html',
									'value'=>function($data){
										return $data->note;
									}
								),
								// array(
								// 	'class'=>'AButtonColumn',
								// 	'visible'=>Controller::PButton(
								// 		array("Admin.*", "Admin.View", "Admin.Update", "Admin.Delete")
								// 	),
								// 	'buttons' => array(
								// 		'view'=> array(
								// 			'visible'=>'Controller::PButton( array("Admin.*", "Admin.View") )'
								// 		),
								// 		// 'update'=> array(
								// 		// 	'visible'=>'false'
								// 		// ),
								// 		'update'=> array( 
								// 			'visible'=>'Controller::PButton( array("Admin.*", "Admin.Update") )' 
								// 		),
								// 		'delete'=> array(
								// 			'visible'=>'Controller::PButton( array("Admin.*", "Admin.Delete") )'
								// 		),
								// 	),
								// ),
							),
));

?>

<!-- modal message -->
<div class="modal fade" tabindex="-1" role="dialog" id="selectModal1">
	<div class="modal-dialog modal-lg" >
		<div class="modal-content">

		</div>
	</div>
</div>
<!-- end modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="selectModal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header" style="background-color: #3C8DBC;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: #fff;font-size: 22px;">&times;</span></button>
				<h4 class="modal-title" style="font-size: 20px;color: #fff;padding: .3em;">ข้อความ</h4>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer" style="background-color: #eee;">
				<button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
				<button id="btnSubmit" type="submit" class="btn btn-primary" onclick="saveModal()">บันทึก</button>
			</div>
		</div>
	</div>
</div>
</div>
<!-- 
						<div class="modal fade" id="modal-id-card">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										
										<h4 class="modal-title text-white"><i class="fa fa-lock" aria-hidden="true"></i>
										แก้ไขบัตรประชาชน สำหรับเรียนหลักสูตร CPD</h4>
									</div>
									<div class="modal-body"
									style="padding: 4em 0;background: url(<?php echo Yii::app()->theme->baseUrl; ?>/images/books.png"
									);
									">
								</div>
								<div class="modal-footer">
									<?php echo CHtml::submitButton('ยืนยัน', array('class' => 'btn btn-sm', 'style' => 'font-size:20px;')); ?>
									<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
								</div>
							</div>
						</div> -->
						<script>
							$(document).ready(function() { 
							 $('#User_register_status').empty(); //remove all child nodes
                               var newOption = $('<option value="">ทั้งหมด</option><option value="1">รอการตรวจสอบ</option><option value="2">ไม่อนุมัติ</option>');
                               $('#User_register_status').append(newOption);
							$('#User_register_status').trigger('chosen:updated');
							});
							//$( ".changeStatus" ).click(function() {
								function sendMsg(id){
								// var btn = $(this);
								// var id = btn.attr("data-id");
								//var _items = ["อนุมัติ","ไม่อนุมัติ"];
								swal({
									title: "ต้องการอนุมัติการสมัครหรือไม่",
									text: "เลือก",
									type: "info",
									showCancelButton: true,
									confirmButtonClass: "btn-danger",
									confirmButtonText: "อนุมัติ",
									cancelButtonText: "ไม่อนุมัติ",
									closeOnConfirm: false,
									closeOnCancel: false,
									showLoaderOnConfirm: true
								},
								function(isConfirm) {
									if (isConfirm) {
										$.ajax({
											url: "<?= $this->createUrl('admin/Confirm'); ?>", 
											type: "POST",
											data:  {id:id},
											success: function(result){
												if (result) {
													setTimeout(function () {
														swal("อนุมัติสำเร็จ!", "ระบบได้ทำการอนุมัติเรียบร้อยแล้ว", "success");
													}, 2000);
													location.reload();
												}else{
													setTimeout(function () {
														swal("อนุมัติไม่สำเร็จ!", "ไม่สามารถอนุมัติได้)", "error");
													}, 2000);
													location.reload();
												}	
											}
										});

									} else {
										swal({
											title: "ระบุสาเหตุ",
											text: "ระบุสาเหตุที่ไม่อนุมัติ",
											type: "input",
											inputPlaceholder: "ข้อความไม่อนุมัติ",
											showCancelButton: true,
											allowEnterKey: true,
											closeOnConfirm: false,
											showLoaderOnConfirm: true,
											confirmButtonText: "ตกลง",
											cancelButtonText: "ยกเลิก",
											animation: "slide-from-top",
										},
										function (inputValue) {
											if(inputValue != false){

												$.ajax({
													type : 'POST',
													url : "<?= $this->createUrl('admin/Notapproved'); ?>",
													data: { passInput:inputValue,
														id:id
													}
													,success:function(data){
														console.log(data);
														if (data) {
															setTimeout(function () {
																swal("สำเร็จ!", "ระบบได้ทำการส่งอีเมลล์แจ้งผู้สมัครเรียบร้อยแล้ว", "success");
															}, 4000);
															location.reload();

														}else{
															setTimeout(function () {
																swal("ไม่สำเร็จ!", "ไม่สามารถแก้ไขข้อมูลได้)", "error");
															}, 2000);
															location.reload();
														}

													}
												});
											}
										}
										);  
									}
								}
								);

								}
						//	});

						//	$( ".Check_information" ).click(function() {
							function sendMsgCheck(id){
								// var btn = $(this);
								// var id = btn.attr("data-id");
								$.ajax({
									url: "<?= $this->createUrl('admin/Checkinformation'); ?>", 
									type: "POST",
									data:  {id:id},
									success: function(data){
										//console.log(data);
										$('#selectModal .modal-title').html('ตรวจสอบข้อมูลการสมัคร');
										$('#selectModal .modal-body').html(data);
										$('#btnSubmit').css('display','none');
										$('#selectModal').modal('show');
										// if(result == 1) btn.addClass('btn-success').removeClass('btn-danger');
										// else btn.addClass('btn-danger').removeClass('btn-success');
										// btn.val(_items[result]);
										// location.reload();
										$(".save_data").click(function(){
											var val = $(".position_id").val();
											var id = $(".position_id").attr('id');
											if (val != '') {
												$.ajax({
													url: "<?= $this->createUrl('admin/Changeposition'); ?>", 
													type: "POST",
													data:  {id:id,
														val:val},
														success: function(data){
										//console.log(data);
										location.reload();
									}
								});
											}else{
												location.reload();
											}
										});
									}
								});
							}
							//});
           $(document).ready(function() {      
           var e = document.getElementById("User_position_id");
           var strUser = e.options[e.selectedIndex].text;
           if (strUser === "ทั้งหมด") {
            $('.name_pos').hide();
           }else{
                var format =  "ตำแหน่ง"+" "+strUser;
             $('.name_pos').text(format);
           }
               var tex = $('.empty').text();
            if (tex) {
            	$('.name_pos').hide();
            	$('.num').text("จำนวนผู้สมัคร 0 คน จาก 0 คน")
            }else{
            	$('.num').show()            
            }
           	});

						</script>
					</div>

				</div><!-- form -->
			</div>
		</div>
	</div>
	<!-- END innerLR -->

