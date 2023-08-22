<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!--Include Date Range Picker--> 
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-chosen.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/chosen.jquery.js"></script>
<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('admin'),
	UserModule::t('Manage'),
);
//
// $this->menu=array(
//     array('label'=>UserModule::t('Create User'), 'url'=>array('create')),
//     array('label'=>UserModule::t('Manage Users'), 'url'=>array('admin')),
//     array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
//     array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
// );

// Yii::app()->clientScript->registerScript('search', "
// 	$('.search-button').click(function(){
// 		$('.search-form').toggle();
// 		return false;
// 		});
// 		$('.search-form form').submit(function(){
// 			$.fn.yiiGridView.update('user-grid', {
// 				data: $(this).serialize()
// 				});
// 				return false;
// 				});
// 				");
// Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
// 	$('#User_create_at').attr('readonly','readonly');
// 	$('#User_create_at').css('cursor','pointer');
// 	$('#User_create_at').daterangepicker();

// EOD
// , CClientScript::POS_READY);
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
	$.appendFilter("User[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
	?>
<style type="text/css">
.coolContainer h4:first-of-type {
    float: left;
}
.coolContainer h4:last-of-type {
    float: left;
}

</style>
	<div id="user" class="innerLR">
		<?php $this->widget('AdvanceSearchForm', array(
			'data'=>$model,
			'route' => $this->route,
			'attributes'=>array(
			//array('name'=>'status','type'=>'text'),
				array('name'=>'status','type'=>'list','query'=>$model->getapproveList()),
				array('name'=>'position_id','type'=>'list','query'=>Position::getPositionListSearch()),
				array('name'=>'create_at','type'=>'text'),
			),
		));?>
		<div class="widget" style="margin-top: -1px;">
			<div class="widget-head">
				<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Confirm Registration"); ?></h4>
			</div>
			<div class="widget-body">
				<div>
					<?php echo Rights::t('core', 'ที่นี่คุณสามารถอนุมัติการเข้าใช้งานระบบให้กับผู้ใช้แต่ละราย'); ?>
				</div>
				<div class="coolContainer">
					<h4 class="name_pos"></h4><h4 class="num"> จำนวนผู้สมัคร <?= $model->searchapprove()->getItemCount(); ?> คน  จาก <?= $model->searchapprove()->getTotalItemCount(); ?> คน</h4>	
				</div>
			 <div class="separator bottom form-inline small">
					<span class="pull-right">
						<label class="strong">แสดงแถว:</label>
						<?php echo $this->listPageShow($formNameModel);?>
					</span>
				</div>
				<div class="spacer"></div>
				<div>

					<!--  <?php echo CHtml::link(UserModule::t('ค้นหาขั้นสูง'),'#',array('class'=>'search-button')); ?>
					<div class="search-form" style="display:none">
						< ?php $this->renderPartial('_search',array(
							'model'=>$model,
							)); ?>
						</div> -->

						<?php 
						// $this->widget('AGridView', array(
						// 	'id'=>'user-grid',
						// 	'dataProvider'=>$model->searchapprove(),
						// 	'filter'=>$model,
						// 	'afterAjaxUpdate'=>'function(id, data){
						// 		$.appendFilter("[news_per_page]");	
						// 		InitialSortTable();
						// 	}',
						$this->widget('AGridView', array(

									'id'=>$formNameModel.'-grid',
									'dataProvider'=>$model->searchapprove(),
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
								array(
									'header' => 'ชื่อ - นามสกุล',
									'type'=>'html',
									'value'=>function($data){
										return $data->profile->firstname_en . ' ' . $data->profile->lastname_en;
									}
								),
								array(
									'header' => 'ตำแหน่ง',
									'type'=>'html',
									'value'=>function($data){
										return $data->position->position_title;
									}
								),
								array(
									'header' => 'สถานะตรวจสอบ',
									'type'=>'html',
									'value'=>function($data){

										if($data->status == 1 && $data->register_status == 0){
											//echo CHtml::button("ปิด",array("class"=>"btn btn-danger ","data-id" => $data->id));
											echo "รออนุมัติ";
										} else if($data->status == 0 && $data->register_status == 2){
											echo "ไม่ผ่านอนุมัติ";
											//echo CHtml::button("รอการตรวจสอบ",array("class"=>"btn btn-success ","data-id" => $data->id));
										}
									}
								),
			// 					array(
			// 						'name' => 'idensearch',
			// 						'type'=>'raw',
			// 						'value' => '$data->profile->identification',
			// //'value' => 'CHtml::link(UHtml::markSearch($data, ),array("admin/view","id"=>$data->id))',
			// 					),
								// array(
								// 	'name'=>'email',
								// 	'type'=>'raw',
								// 	'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
								// ),
								// array(
								// 	'name'=>'email',
								// 	'type'=>'raw',
								// 	'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
								// ),
		// 'create_at',
								array(
									'header' => 'วันที่ลงทะเบียน',
									//'name'=>'create_at',
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
										if($data->status == 1 && $data->register_status == 0){
											echo '<button class="btn btn-info changeStatus" onclick="sendMsgCheck('.$data->id.')">รออนุมัติ</button>';
											// CHtml::button("รออนุมัติ",array('onclick'=>'sendMsgCheck('.$data->id.')',"class"=>"btn btn-info changeStatus","data-id" => $data->id));
										} else if($data->status == 0 && $data->register_status == 0) {
											echo '<button class="btn btn-danger">ไม่ผ่านอนุมัติ</button>';
											// CHtml::button("ไม่ผ่านอนุมัติ",array("class"=>"btn btn-danger","data-id" => $data->id));
										}
										// else {
										// 	echo CHtml::button("ไม่ผ่าน",array("class"=>"btn btn-danger ","data-id" => $data->id));
										// }
									},
									'header' => 'ยืนยันการสมัครสมาชิก',
									'htmlOptions'=>array('style'=>'text-align: center;'),
									'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
								),
								array(
									'header' => 'สาเหตุที่ไม่ผ่าน',
									'type'=>'html',
									'value'=>function($data){
										return $data->not_passed;
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

<script>
	// $( ".changeStatus" ).click(function() {
	// 	var btn = $(this);
	// 	var id = btn.attr("data-id");
		function sendMsgCheck(id){
								// var _items = ["ระงับการใช้งาน","เปิดการใช้งาน"];
								// swal({
								// 	title: "โปรดรอสักครู่",
								// 	text: "ระบบกำลังส่งอีเมล",
								// 	type: "info",
								// 	showConfirmButton: false
								// });
								swal({
									title: "ต้องการอนุมัติการเข้าใช้งานหรือไม่",
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
									//url: "<?= $this->createUrl('admin/active'); ?>", 
									url: "<?=Yii::app()->createUrl('user/admin/active');?>",
									type: "POST",
									data:  {id:id},
									success: function(result){
										console.log(result);
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
									}else {
										swal({
											title: "ระบุสาเหตุที่ไม่ผ่าน",
											text: "ระบุสาเหตุที่ไม่ผ่าน",
											type: "input",
                    //inputType: "password",
                    inputPlaceholder: "ข้อความไม่แจ้งไม่ผ่าน",
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
                			url : "<?= $this->createUrl('admin/NotPassed'); ?>",
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
							//});
}

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
