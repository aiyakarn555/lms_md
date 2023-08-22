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
// 	});
// 	$('.search-form form').submit(function(){
// 		$.fn.yiiGridView.update('user-grid', {
// 			data: $(this).serialize()
// 		});
// 		return false;
// 	});
// 	");$('#User_create_at').daterangepicker();
//  Yii::app()->clientScript->registerScript('search', "
// // 	$('.search-button').click(function(){
// // 		$('.search-form').toggle();
// // 		return false;
// // 		});
// // 		$('.search-form form').submit(function(){
// // 			$.fn.yiiGridView.update('user-grid', {
// // 				data: $(this).serialize()
// // 				});
// // 				return false;
// // 				});
// // 		$('.collapse-toggle').click();
//  				");
	?>
	<div id="user" class="innerLR">
		<?php
		$this->widget('AdvanceSearchForm', array(
			'data'=>$model,
			'route' => $this->route,
        //'id'=>'SearchFormAjax',
			'attributes'=>array(
//            array('name'=>'company_id','type'=>'list','query'=>Company::getCompanyList()),
				//array('name'=>'register_status','type'=>'list','query'=>User::getregisstatusList()),
				array('name'=>'position_id','type'=>'list','query'=>Position::getPositionListSearch()),
                //array('name'=>'month','type'=>'list','query'=>Month::getMonth()),
//            array('name'=>'course','type'=>'list','query'=>$model->courseList),
				//array('name'=>'lastvisit_at','type'=>'text'),

            //array('name'=>'course_point','type'=>'text'),
			),
		));?>


		<div class="widget" style="margin-top: -1px;">
			<div class="widget-head">
				<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>ระบบบริหารจัดการ E learning - ตรวจสอบและจัดการการเข้าใช้งานบุคคลทั่วไป <?php //echo $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Confirm Registration"); ?></h4>
			</div>
			<div class="widget-body">
				<div>
					<?php echo Rights::t('core', 'ที่นี่คุณสามารถตรวจสอบและจัดการการเข้าใช้งานบุคคลทั่วไป'); ?>
<!-- 					<h3>กรุณาป้อนข้อมูลให้ถูกต้อง แล้วกด ปุ่มค้นหา</h3> -->
				</div>
				<div class="separator bottom form-inline small">
					<span class="pull-right">
						<label class="strong">แสดงแถว:</label>
						<?php echo $this->listPageShow($formNameModel);?>
					</span>
				</div>
				<div class="spacer"></div>
				<div>

					<!--  < ?php echo CHtml::link(UserModule::t('ค้นหาขั้นสูง'),'#',array('class'=>'search-button')); ?>
					<div class="search-form" style="display:none">
						< ?php $this->renderPartial('_search',array(
							'model'=>$model,
							)); ?>
						</div> --><!-- search-form -->

						<?php 
						$this->widget('AGridView', array(
							'id'=>'user-grid',
							'dataProvider'=>$model->searchaccessPersonal(),
							'filter'=>$model,
							'afterAjaxUpdate'=>'function(id, data){
								$.appendFilter("[news_per_page]");	
								InitialSortTable();
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
									'header' => 'วันที่เข้าใช้งานล่าสุด',
									'type'=>'html',
									'filter' => false,
			// 'value'=>'UHtml::markSearch($data,"create_at")'
									'value'=>function($data){
										return Helpers::changeFormatDate($data->lastvisit_at,'datetime');
									},
								),
								array(
									'header' => 'จำนวนวันที่ไม่เข้าใช้งาน',
									'type'=>'html',
									'filter' => false,
			// 'value'=>'UHtml::markSearch($data,"create_at")'
									'value'=>function($data){
										$now = new DateTime();
                                        $input = new DateTime($data->lastvisit_at);
                                        $diff = $input->diff($now); 
                                       echo $diff->format('%a วัน');
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
											echo CHtml::button("เปิดเข้าใช้งาน",array("class"=>"btn btn-success changeStatus","data-id" => $data->id));			
									},
									'header' => 'จัดการ',
									'htmlOptions'=>array('style'=>'text-align: center;'),
									'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
								),
								// array(
								// 	'type'=>'raw',
								// 	'value'=>function($data){	
								// 		echo CHtml::button("ตรวจสอบ",array("class"=>"btn btn-success Check_information","data-id" => $data->id));
								// 	},
								// 	'header' => 'ตรวจสอบข้อมูลการสมัคร',
								// 	'htmlOptions'=>array('style'=>'text-align: center;'),
								// 	'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
								// ),
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
<!-- <div class="modal fade" tabindex="-1" role="dialog" id="selectModal1">
	<div class="modal-dialog modal-lg" >
		<div class="modal-content">

		</div>
	</div>
</div>

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
</div> -->

						<script>
							$( ".changeStatus" ).click(function() {
								var btn = $(this);
								var id = btn.attr("data-id");
								//var _items = ["อนุมัติ","ไม่อนุมัติ"];
								swal({
									title: "ต้องการเปิดการใช้งานผู้ใช้งานหรือไม่",
									text: "เลือก",
									type: "info",
									showCancelButton: true,
									confirmButtonClass: "btn-danger",
									confirmButtonText: "ใช่",
									cancelButtonText: "ไม่",
									closeOnConfirm: false,
									closeOnCancel: false,
									showLoaderOnConfirm: true
								},
								function(isConfirm) {
							          if (isConfirm) {
										$.ajax({
											url: "<?= $this->createUrl('admin/Open_employee'); ?>", 
											type: "POST",
											data:  {id:id},
											success: function(result){

												if (result) {
													setTimeout(function () {
														swal("ลบสำเร็จ!", "ระบบได้ทำการเปิดการใช้งานผู้ใช้งานเรียบร้อยแล้ว", "success");
													}, 1000);
													location.reload();
												}else{
													setTimeout(function () {
														swal("ไม่สำเร็จ!", "ไม่สามารถเปิดใช้งานได้)", "error");
													}, 1000);
													location.reload();
												}	
											}
										});
										}else{
									    	location.reload();
									    } 
									}
								
								);
								
							});

						</script>
					</div>

				</div><!-- form -->
			</div>
		</div>
	</div>
	<!-- END innerLR -->
