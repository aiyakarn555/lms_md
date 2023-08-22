<style>
	.glyphicons.user i:before {
    position: absolute;
    left: 8px;
    top: 6px;
    font: 16px/1em 'Glyphicons';
	}
	.glyphicons.user{
		padding: 5px 8px 5px 28px;
	}

	.zoom {
		transition: transform .2s; /* Animation */
	}

	.zoom:hover {
		position: relative;
		z-index:9999;
		transform: scale(3); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
	}
</style>
<?php
$this->breadcrumbs=array(
	// UserModule::t('Users')=>array('/user'),
	UserModule::t('Manage'),
);
$formNameModel = 'User';


// $type_emp = 0;
// $Department_ID = array();
// $type_emp = 2;

// $Department = Department::model()->findAll('active = "y" AND lang_id = 1 AND type_employee_id = 2');
// foreach ($Department as $key => $value) {
// $Department_ID[] = $value->id;
// }
// $criteria= new CDbCriteria;
// 	$criteria->compare('active','y');
// 	$criteria->compare('lang_id',1);
// 	$criteria->addInCondition('department_id', $Department_ID);
// 	$ListPosition = Position::model()->findAll($criteria);
if ($_GET['kind'] == 'p') {
	$criteria= new CDbCriteria;
	$criteria->compare('active','y');
	$OrgGroupBu = OrgGroupBu::model()->findAll($criteria);
	$OrgBu = OrgBu::model()->findAll($criteria);
	$OrgDepartment = OrgDepartment::model()->findAll($criteria);
	$OrgDivision = OrgDivision::model()->findAll($criteria);
	$OrgSection = OrgSection::model()->findAll($criteria);
	$OrgSubSection = OrgSubSection::model()->findAll($criteria);
}else{
	$criteria= new CDbCriteria;
	$criteria->compare('active','y');
	$OrgCountry = OrgCountry::model()->findAll($criteria);
	$OrgCountryCompany = OrgCountryCompany::model()->findAll($criteria);
	$OrgCountryDepartment = OrgCountryDepartment::model()->findAll($criteria);
	$OrgCountryDivision = OrgCountryDivision::model()->findAll($criteria);
	$OrgCountrySection = OrgCountrySection::model()->findAll($criteria);
	$OrgCountryTeam = OrgCountryTeam::model()->findAll($criteria);
}




// echo '<pre>';
// var_dump($ListPosition);die;

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
				<div id="user" class="innerLR">

					<!-- <?php $this->widget('AdvanceSearchForm', array(
						'data'=>$model,
						'route' => $this->route,
						'attributes'=>array( 
							array('name'=>'idensearch','type'=>'text'),
							array('name'=>'email','type'=>'text'),
							array('name'=>'activkey','type'=>'text'),
							array('name'=>'create_at','type'=>'text'),
							array('name'=>'lastvisit_at','type'=>'text'),
							array('name'=>'superuser','type'=>'list','query' => $model->itemAlias('AdminStatus')),
							array('name'=>'status','type'=>'list','query' => $model->itemAlias('UserStatus')),
						)
					));
					?> -->
					<div class="widget" style="margin-top: -1px;">
						<div class="widget-head">
							<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration"); ?></h4>
						</div>
						<div class="widget-body">
							<!-- <div>
								<?php echo Rights::t('core', 'ที่นี่คุณสามารถดูว่ามีการมอบหมายสิทธิ์ใดให้กับผู้ใช้แต่ละราย'); ?>
								<button onclick="googleSheet()" class="btn btn-danger w-100 text-4 py-2 my-4" data-loading-text="Loading..." style='background-color:#E0001A;'>อัปเดตสมาชิก</button>
							</div> -->
							 <div class="separator bottom form-inline small">
								<span class="pull-right">
									<label class="strong">แสดงแถว:</label>
									<?php echo $this->listPageShow($formNameModel);?>
								</span>
							</div> 
							<div class="clear-div"></div>
							<div class="overflow-table">					
								<?php if($_GET['kind'] == 'p'){ $this->widget('AGridView', array(

									'id'=>$formNameModel.'-grid',
									'dataProvider'=>$model->search(),
									'filter'=>$model,
									'selectableRows' => 2,
									//'rowCssClassExpression'=>'"items[]_{$data->id}"',
									'htmlOptions' => array(
										'style'=> "margin-top: -1px;width:200%;",
									),
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
											'filterHtmlOptions'=>array('style'=>'width:30px;'), 
											'htmlOptions'=>array('style'=>'text-align: center;hight:5%;'),
										),
										array(
											'name'=>'fullname',
											'type'=>'html',
											'value'=>function($data){
												return $data->profile->prefix_th.' '.$data->profile->firstname.' '.$data->profile->lastname;
											},
											'filterHtmlOptions'=>array('style'=>'width:30px'),
											'htmlOptions'=>array('style'=>'text-align: center;'),
										),
										
										array(
											'name'=>'email',
											'type'=>'raw',
											'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
											'filterHtmlOptions'=>array('style'=>'width:10px'),
			
										),
										array(
											'name'=>'status',
											'type'=>'raw',
											'value'=>'User::itemAlias("UserStatus",$data->status)',
											'filter' => User::itemAlias("UserStatus"),
											'filterHtmlOptions'=>array('style'=>'width:30px'),
											//'htmlOptions'=>array('style'=>'text-align: center;width:100%;'),
										),
										array(
											'name'=>'online_status',
											'type'=>'raw',
											'value'=>'User::chk_online($data->id,$data->lastactivity,$data->online_status)',
											'filter' => User::itemAlias("Online"),
											'filterHtmlOptions'=>array('style'=>'width:30px'),
											//'htmlOptions'=>array('style'=>'text-align: center;width:100%;'),
										),
										array(
											'header'=>'จัดการ',
											'type'=>'raw',
											'htmlOptions' => array(
														   'style' => 'width:10px;text-align: center;',
														),
											'value'=>function($data){
									 
											 $text .= '
											 <a class="btn-action glyphicons eye_open btn-info" title="ดูรายละเอียด" href="'.Yii::app()->controller->createUrl('admin/'.$data->id).'"><i></i></a>
											 ';
									 
											 return $text;
											},
										   
									 
										   ),
										
										
									),
));


}else{ $this->widget('AGridView', array(

	'id'=>$formNameModel.'-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'selectableRows' => 2,
	//'rowCssClassExpression'=>'"items[]_{$data->id}"',
	'htmlOptions' => array(
		'style'=> "margin-top: -1px;width:100%;",
	),
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
			'filterHtmlOptions'=>array('style'=>'width:10px;'), 
			'htmlOptions'=>array('style'=>'text-align: center;hight:5%;width:3%;'),
		),
		array(
			'name'=>'fullname',
			'type'=>'html',
			'value'=>function($data){
				return $data->profile->firstname_en.' '.$data->profile->lastname_en;
			},
			'filterHtmlOptions'=>array('style'=>'width:10%'),
			'htmlOptions'=>array('style'=>'text-align: left;width:10%;'),
		),
		
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
			'filterHtmlOptions'=>array('style'=>'width:10%'),
			'htmlOptions'=>array('style'=>'width:10%;'),

		),
		array(
			'header' => 'Reset ภาพถ่าย',
			'type' => 'raw',
			'value'=>function($data){
				$text .= '<button class="btn btn-danger" onClick="confirm_Reset('.$data->id.')" title="Reset">Reset</button>';

				return $text;
			},
			// 'value' => function($val) {
			// 	$examData = Score::model()->find(array(
			// 		'condition' => 'user_id=:user_id AND active="y" AND type="pre"',
			// 		'params' => array(':user_id' => $val->user_id)));
			// 	if($examData){
			// 		$evntExam = 'reset_pre';
			// 		$btnClassExam = 'btn-danger';
			// 	} else {
			// 		$evntExam = '';
			// 		$btnClassExam = '';
			// 	}
			// 	return CHtml::button("Reset",array('class' => 'btn '.$evntExam.' '.$btnClassExam.'','data-id' => $val->user_id));
			// },
			'htmlOptions' => array(
				'style'=> "text-align: center;width:5%;",
			),
			'filterHtmlOptions'=>array('style'=>'width:100px'),
		),
		array(
			'header' => 'รูปภาพยืนยันตัวตน',
			'type' => 'raw',
			'value'=>function($data){
				if (file_exists(YiiBase::getPathOfAlias('webroot') . '/../uploads/FaceRegis/' . $data->id.'.jpg')) {
						$src = Yii::app()->baseUrl.'/../uploads/FaceRegis/'.$data->id.'.jpg';
				}else{
					if(file_exists(YiiBase::getPathOfAlias('webroot') . '/../../../uploads/FaceRegis/' . $data->id.'.jpg')){
						$src = Yii::app()->theme->baseUrl . '/../../../uploads/FaceRegis/' .$data->id.'.jpg';
					}else{
						$src = "<div align='center'>-</div>";
					}
				}

				if(!strpos($src,"div")){	
					$src = '<img id="myImg" src="'.$src.'" class="zoom">';
				}
				return $src;
			},'htmlOptions'=>array('width'=>'110rem')
		),
		array(
			'header' => 'บัตรประชาชน',
			'type' => 'raw',
			'value'=>function($data){
				if (file_exists(YiiBase::getPathOfAlias('webroot') . '/../uploads/IdCard/' . $data->id.'.jpg')) {
					$src = Yii::app()->baseUrl.'/../uploads/IdCard/'.$data->id.'.jpg';
				}else{
					if(file_exists(YiiBase::getPathOfAlias('webroot') . '/../../../uploads/IdCard/' . $data->id.'.jpg')){
						$src = Yii::app()->theme->baseUrl . '/../../../uploads/IdCard/' .$data->id.'.jpg';
					}else{
						$src = "<div align='center'>-</div>";
					}
				}

				if(!strpos($src,"div")){
					$src = '<img id="myImg" src="'.$src.'" class="zoom">';
				}
				return $src;
			},'htmlOptions'=>array('width'=>'110rem')
		),
		array(
			'header' => 'Profile',
			'type' => 'raw',
			'value'=>function($data){
				if (file_exists(YiiBase::getPathOfAlias('webroot') . '/../uploads/users/' . $data->id . '/' . $data->profile->profile_picture)) {
					$src = Yii::app()->baseUrl.'/../uploads/users/' . $data->id . '/' . $data->profile->profile_picture;
				}else{
					if(file_exists(YiiBase::getPathOfAlias('webroot') . '/../../../uploads/users/' . $data->id .'/'.$data->profile->profile_picture)){
						$src = Yii::app()->theme->baseUrl . '/../../../uploads/users/' . $data->id .'/'.$data->profile->profile_picture;
					}else{
						$src = "<div align='center'>-</div>";
					}
				}

				if(!strpos($src,"div")){
					$src = '<img id="myImg" src="'.$src.'" class="zoom">';
				}
				return $src;
				
			},'htmlOptions'=>array('width'=>'110rem')
		),
		array(
			'header' => 'แก้ไขรูปภาพ Profile',
			'type' => 'raw',
			// 'value'=>function($data){
	 
			// 	$text .= '<button class="btn btn-info glyphicons user" title="แก้ไขรูปภาพ Profile"><i></i> แก้ไขรูปภาพ</button>';
		
			// 	return $text;
			//    },
			   'value'=>'CHtml::link("<i></i> แก้ไขรูปภาพ", array(
					      		"/user/admin/EditProfilePhoto?id=".$data->id
					      		), array(
								"class"=>"btn btn-info glyphicons user"
						    )); ',
			
			'htmlOptions' => array(
				'style'=> "text-align: center;width:5%;",
			),
			'filterHtmlOptions'=>array('style'=>'width:100px'),
		),
		array(
			'header' => 'รหัสผ่าน',
			'type' => 'raw',
			'value' =>function($data){
				return '<button class="btn btn-danger" title="แก้ไขรหัสผ่าน" onClick="editPassword('.$data->id.')">Edit Password</button>';
			}
		),
		array(
			'name'=>'status',
			'type'=>'raw',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
			'filter' => User::itemAlias("UserStatus"),
			'filterHtmlOptions'=>array('style'=>'width:5%'),
			'htmlOptions' => array(
				'style'=> "text-align: center;width:5%;",
			),
			//'htmlOptions'=>array('style'=>'text-align: center;width:100%;'),
		),
		array(
			'name'=>'online_status',
			'type'=>'raw',
			'value'=>'User::chk_online($data->id,$data->lastactivity,$data->online_status)',
			'filter' => User::itemAlias("Online"),
			'filterHtmlOptions'=>array('style'=>'width:5%'),
			'htmlOptions' => array(
				'style'=> "text-align: center;width:5%;",
			),
		),
		array(
			'header'=>'จัดการ',
			'type'=>'raw',
			'htmlOptions' => array(
						   'style' => 'width:5%;;text-align: center;',
						),
			'value'=>function($data){
	 
			 $text .= '
			 <a class="btn-action glyphicons eye_open btn-info" title="ดูรายละเอียด" href="'.Yii::app()->controller->createUrl('admin/'.$data->id).'"><i></i></a>
			 ';
	 
			 return $text;
			},
		   
	 
		   ),
		
		
	),
)); ?>

<?php } ?>
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

</div><!-- form -->
</div>
</div>
</div>
<!-- END innerLR -->
<script type="text/javascript">

	function confirm_Reset(user_id) {
		swal({
			title: "แจ้งเตือน",
			text: "ยืนยันการ Reset กรุณากรอกรหัสผ่าน",
			type: "input",
			inputType: "password",
			showCancelButton: true,
			allowEnterKey: true,
			closeOnConfirm: false,
			confirmButtonText: "ตกลง",
			cancelButtonText: "ยกเลิก",
			animation: "slide-from-top",
		},
		function (inputValue) {
			if(inputValue != false){
				$.ajax({
					type: "POST",
					url: "<?php echo Yii::app()->createUrl("learnReset/confirmPass"); ?>",
					data: { passInput:inputValue },
					success: function(data){
						if(data){
							reset_photo(user_id);
						}else{
							swal({
								title: "แจ้งเตือน",
								text: "รหัสผ่านไม่ถูกต้อง",
								type: "warning",
								confirmButtonText: "ตกลง",
							});
						}
					},
				});
			}
		});
	}

	function reset_photo(user_id) {
		if(user_id != ""){
			$.ajax({
				type: "POST",
				url: "<?php echo Yii::app()->createUrl("user/admin/ResetPhoto"); ?>",
				data: { user_id:user_id },
				success: function(data){
					swal({
						title: "ระบบ",
						text: "Reset ภาพถ่าย เรียบร้อยแล้ว",
						type: "success",
						confirmButtonText: "ตกลง",
					});
					location.reload();

				},
			});
		}
	}

function googleSheet(){

	swal({
		title: "คุณต้องการอัปเดตใช่หรือไม่",
		text: "เลือก",
		type: "info",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "ใช่",
		cancelButtonText: "ไม่",
		closeOnConfirm: true,
		closeOnCancel: false,
						},
							function(isConfirm) {
							if (isConfirm) {
								$.ajax({
									url: "<?= ($_GET['kind'] == 'p' ? Yii::app()->createUrl('/../../quickstart_provide.php') : Yii::app()->createUrl('/../../quickstart_reginal.php') ); ?>", 
									type: "GET",
									success: function(response){
										$.blockUI({message: '<h1>Processing</h1>'});
										$.ajax({
											url: "<?= ($_GET['kind'] == 'p' ?  $this->createUrl('admin/Googlesheet?type=p') : $this->createUrl('admin/Googlesheet?type=r') ); ?>", 
											type: "POST",
											data:  {response:response},
											success: function(data){
												// console.log(data);
												if (data) {
													setTimeout(function () {
														swal("สำเร็จ", "อัปเดตสำเร็จ", "success");
													}, 10000);
													location.reload();
												}
											},
											error: function(data){
												$.unblockUI(); 
												swal("ไม่สำเร็จ", "เกิดข้อผิดพลาด", "warning");
											}
										});
									}
								});
								
							}
					
	});

}
// function sendMsg(id){

// 	swal({
// 		title: "คุณต้องการเปลี่ยนรหัสผ่านใช่หรือไม่",
// 		text: "เลือก",
// 		type: "info",
// 		showCancelButton: true,
// 		confirmButtonClass: "btn-danger",
// 		confirmButtonText: "ใช่",
// 		cancelButtonText: "ไม่",
// 		closeOnConfirm: true,
// 		closeOnCancel: false,
// 									//showLoaderOnConfirm: true
// 								},
// 								function(isConfirm) {
// 									if (isConfirm) {
// 										$.ajax({
// 											url: "<?= $this->createUrl('admin/ChangePassword'); ?>", 
// 											type: "POST",
// 											data:  {id:id},
// 											success: function(data){

// 												$('#selectModal .modal-title').html('กรุณากรอกรหัสผ่านใหม่');
// 												$('#selectModal .modal-body').html(data);
// 												$('#btnSubmit').css('display','none');
// 												$('#selectModal').modal('show');
// 												$(".save_data").click(function(){
// 													var password = $("#password").val();
// 													var verifyPassword = $("#verifyPassword").val();

// 													$.ajax({
// 														url: "<?= $this->createUrl('admin/ChangePasswordUser'); ?>", 
// 														type: "POST",
// 														data:  {id:id,
// 															password:password,
// 															verifyPassword:verifyPassword,

// 														},
// 														success: function(data){
// 															console.log(data);
// 															if (data) {
// 																setTimeout(function () {
// 																	swal("สำเร็จ", "เปลี่ยนรหัสผ่านสำเร็จ)", "success");
// 																}, 10000);
// 																location.reload();
// 															}else{
// 																setTimeout(function () {
// 																	swal("ไม่สำเร็จ!", "ไม่สามารถเปลี่ยนรหัสผ่านสำเร็จ)", "error");
// 																}, 10000);
// 																location.reload();
// 															}
// 														}
// 													});

// 												});
// 											}
// 										});
										
// 									} else {
// 										setTimeout(function () {
// 											swal("ไม่สำเร็จ!", "ไม่สามารถเปลี่ยนรหัสผ่านสำเร็จ)", "error");
// 										}, 2000);
// 										location.reload();
// 									}
// 								}
// 								);

// }

function editPassword(id){
	swal({
		title: "คุณต้องการเปลี่ยนรหัสผ่านใช่หรือไม่",
		text: "เลือก",
		type: "info",
		showCancelButton: true,
		confirmButtonClass: "btn-danger",
		confirmButtonText: "ใช่",
		cancelButtonText: "ไม่",
		closeOnConfirm: false,
		closeOnCancel: false
	},
	function(isConfirm){
		if (isConfirm){
			swal.close();
			$.ajax({
				url: "<?= $this->createUrl('admin/ChangePassword'); ?>", 
				type: "POST",
				data:  {id:id},
				success: function(data){
					$('#selectModal .modal-title').html('กรุณากรอกรหัสผ่านใหม่');
					$('#selectModal .modal-body').html(data);
					$('#btnSubmit').css('display','none');
					$('#selectModal').modal('show');
					$(".save_data").click(function(){
						var password = $("#password").val();
						var verifyPassword = $("#verifyPassword").val();
						$.ajax({
							url: "<?= $this->createUrl('admin/ChangePasswordUser'); ?>", 
							type: "POST",
							data:  {id:id,
								password:password,
								verifyPassword:verifyPassword,
							},
							success: function(data){
								const arr = JSON.parse(data);
								setTimeout(function () {
										if(arr['check']){
											$('#selectModal').modal('toggle');
										}
										swal(arr['title'], arr['text'], arr['type']);
								}, 1000);
							}
						});
					});
				}
			});

			} else {
				swal("ยกเลิก", "ยกเลิกการเปลี่ยนรหัสผ่าน", "warning");
				e.preventDefault();
			}
	});
}
</script>
