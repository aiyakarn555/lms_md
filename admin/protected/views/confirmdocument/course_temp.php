<?php
$this->breadcrumbs = array(
	'อนุมัติหลักสูตร(เอกสารแนบ)',
);
$formNameModel = 'CourseTemp';

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
		$.fn.yiiGridView.update('$formNameModel-grid', {
			data: $(this).serialize()
			});
			return false;
			});
			");

// Yii::app()->clientScript->registerScript(
// 	'updateGridView',
// 	<<<EOD
// 	$.updateGridView = function(gridID, name, value) {
// 		$("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
// 		$.fn.yiiGridView.update(gridID, {data: $.param(
// 			$("#"+gridID+" input, #"+gridID+" .filters select")
// 			)});
// 		}
// 		$.appendFilter = function(name, varName) {
// 			var val = eval("$."+varName);
// 			$("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
// 		}
// 		$.appendFilter("CourseTemp[news_per_page]", "news_per_page");
// 		EOD,
// 		CClientScript::POS_READY
// 	);

	?>
	<div id="user" class="innerLR">

		<?php $this->widget('AdvanceSearchForm', array(
			'data' => $model,
			'route' => $this->route,
			'attributes' => array(
				array('name' => 'courseTi', 'type' => 'text'),
				array('name' => 'fullname', 'type' => 'text'),
			)
		));
		?>
		<div class="widget" style="margin-top: -1px;">
			<div class="widget-head">
				<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Registration"); ?></h4>
			</div>
			<div class="widget-body">

				<div class="separator bottom form-inline small">
					<span class="pull-right">
						<label class="strong">แสดงแถว:</label>
						<?php echo $this->listPageShow($formNameModel); ?>
					</span>
				</div>
				<div class="clear-div"></div>
				<div class="overflow-table">
					<?php $this->widget('AGridView', array(

						'id' => $formNameModel . '-grid',
						'dataProvider' => $model->search_document(),
						'filter' => $model,
						'selectableRows' => 2,
					//'rowCssClassExpression'=>'"items[]_{$data->id}"',
					// 'htmlOptions' => array(
					// 	'style'=> "margin-top: -1px;width:200%;",
					// ),
						'afterAjaxUpdate' => 'function(id, data){
							$.appendFilter("CourseTemp[news_per_page]");
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

							'columns' => array(
								array(
									'header' => 'No.',
									'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
									'filterHtmlOptions' => array('style' => 'width:1px;'),
									'htmlOptions' => array('style' => 'text-align: center;hight:5%;'),
								),
								array(
									'header' => 'รหัสพนักงาน',
									'type' => 'html',
									'filter' => false,
									'value' => function ($data) {
										return "?";
									},
									'filterHtmlOptions' => array('style' => 'width:30px'),
								),
								array(
									'header' => 'รหัสบัตรประจำตัวฯ',
									'type' => 'html',
									'filter' => false,
									'value' => function ($data) {
										return $data->profile->identification;
									},
									'filterHtmlOptions' => array('style' => 'width:30px'),
								),

								array(
									'header' => 'ชื่อ - นามสกุล',
									'type' => 'html',
									'filter' => false,
									'value' => function ($data) {
										return $data->profile->firstname . " " . $data->profile->lastname;
									},
									'filterHtmlOptions' => array('style' => 'width:30px'),
								),

								array(
									'header' => 'หลักสูตร',
									'type' => 'html',
									'filter' => false,
									'value' => function ($data) {
										return $data->course->course_title;
									},
									'filterHtmlOptions' => array('style' => 'width:30px'),
								),


								array(
									'header' => 'วันที่แนบเอกสาร',
									'type' => 'html',
							// 'value'=>'UHtml::markSearch($data,"create_date")'
									'filter' => false,
									'value' => function ($data) {
										return Helpers::changeFormatDate($data->date_set_document, 'datetime');
									},
									'filterHtmlOptions' => array('style' => 'width:30px'),
							// 'htmlOptions'=>array('style'=>'text-align: center;width:100%;'),
							// 'headerHtmlOptions'=>array('style'=>'text-align:center;width:100%;'),
								),


								array(
									'type' => 'raw',
									'value' => function ($data) {

										return '<button data-id="' . $data->id . '" class="btn btn-info" onclick="ShowImages(' . $data->id . ')">ตรวจสอบเอกสารแนบ</button>';

								// return  CHtml::button("ดูรูปภาพ",array('onclick'=>'ShowImages('.$data->id.')','class' => 'btn btn-info','data-id' =>$data->id));
									},
									'header' => 'เอกสารแนบ',
									'htmlOptions' => array('style' => 'text-align: center;'),
									'headerHtmlOptions' => array('style' => 'text-align:center;width:5%;'),
								),
								array(
									'header' => 'การอนุมัติ',
							// 'filterHtmlOptions'=>array('style'=>'width:30px'),
									'htmlOptions' => array('style' => 'text-align: center;'),
									'headerHtmlOptions' => array('style' => 'text-align:center;width:20%;'),
									'type' => 'raw',
									'value' => function ($data) {
										$criteria = new CDbCriteria;
										$criteria->compare('course_id', $data->course_id);
										$criteria->compare('course_temp_id', $data->id);
										$criteria->compare('user_id', $data->user_id);
										$criteria->compare('active', 'y');
										$courseDocument = CourseDocument::model()->findAll($criteria);
										$status = true;
										foreach ($courseDocument as $key => $value) {
											if ($value->confirm_status != "y") {
												$status = false;
											}
										}
										$onclick = 'onclick="sendMsg(1,' . $data->id . ')"';
										$disabled = "";
										if (!$status) {
											$onclick = '';
											$disabled = "disabled";
										}

										return '<button data-id="' . $data->id . '" class="btn btn-success" ' . $disabled . ' ' . $onclick . ' > อนุมัติ</button>
										<button data-id="' . $data->id . '" class="btn btn-danger" onclick="sendMsg(2,' . $data->id . ')" > ไม่อนุมัติ</button>';
								// return  CHtml::button("เปลี่ยนรหัสผ่าน",array('onclick'=>'sendMsg('.$data->id.')','class' => 'btn btn-info','data-id' =>$data->id));

									},

								),

								array(
									'header' => 'การล็อค',
									'type' => 'raw',
									'value' => function ($data) {
										if ($data->lock_document == 'n') {
											return '<input  id="toggle-event" type="checkbox" data-toggle="toggle" data-onstyle="success" value="'.$data->id.'">';
									//return CHtml::link("ปิด", array("/ConfirmDocument/LockDocumentCourse", "id" => $data->id), array("class" => "btn btn-danger"));
										} else {
											return '<input  id="toggle-event" type="checkbox" checked data-toggle="toggle" data-onstyle="success" value="'.$data->id.'">';
									//return CHtml::link("เปิด", array("/ConfirmDocument/LockDocumentCourse", "id" => $data->id), array("class" => "btn btn-success"));
										}
									},
									'htmlOptions' => array('style' => 'text-align: center;width:100px;'),
									'headerHtmlOptions' => array('style' => 'text-align:center;width:100px;'),
								),

							),
));


?>
<?php

				// $sqlUser = "SELECT * from tbl_course_temp WHERE status  ='n'";
				// $modelUser = Yii::app()->db->createCommand($sqlUser)->queryAll();

$criteria = new CDbCriteria;
$criteria->with = array('course', 'course.cates', 'profile');
$criteria->compare('courseonline.active', 'y');
$criteria->compare('courseonline.status', '1');
$criteria->compare('courseonline.document_status', 'y');
$criteria->compare('categorys.cate_show', '1');
$criteria->compare('t.status', 'y');
$criteria->compare('t.status_document', 'w');
$criteria->addCondition('courseonline.course_date_end >= :date_now');
$criteria->params[':date_now'] = date('Y-m-d H:i');
$modelUser = CourseTemp::model()->findAll($criteria);

if (!empty($modelUser)) {
	foreach ($modelUser as $key => $value) {
		$criteria = new CDbCriteria;
		$criteria->compare('course_id', $value->course_id);
		$criteria->compare('course_temp_id', $value->id);
		$criteria->compare('user_id', $value->user_id);
		$criteria->compare('active', 'y');
		$courseDocument = CourseDocument::model()->findAll($criteria);

		$criteria = new CDbCriteria;
		$criteria->compare('code_md', $value->course->course_md_code);
		$criteria->compare('type', 1);
		$MtCode = MtCodeMd::model()->find($criteria);
		?>
		<div class="modal fade" id="selectImages<?= $value->id ?>" tabindex="-1" role="dialog" aria-labelledby="course-booking">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">ตรวจสอบเอกสารหลักสูตร</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<label class="text-danger note" style="margin-left:1rem">หมายเหตุ : <?= $MtCode != null ? $MtCode->note : "ไม่พบหมายเหตุ" ?></label>
						</div>
						<div class="table-responsive">
							<table class="table">
								<tr>
									<th class="active" scope="col">ลำดับ</th>
									<th class="active" scope="col">ชื่อไฟล์เอกสาร</th>
									<th class="active" scope="col">วันที่</th>
									<th class="active" scope="col">เอกสาร</th>
									<th class="active" style="text-align: center;" scope="col">เลือก</th>
									<th class="active" scope="col">สถานะ</th>
									<th class="active" scope="col">จัดการ</th>
								</tr>
								<tbody>
									<?php $id_all = array(); ?>
									<?php foreach ($courseDocument as $keyfile => $file) { ?>
										<?php
										$status = "";
										if ($file->confirm_status == "n") {
											$status = "รอการตรวจสอบ";
										} elseif ($file->confirm_status == "y") {
											$status = "อนุมัติ";
										} elseif ($file->confirm_status == "x") {
											$status = "ไม่อนุมัติ";
										}

										?>
										<?php array_push($id_all,$file->id);  ?>
										<tr>
											<td class="success" scope="row"><?= $keyfile + 1 ?></td>
											<td class="success" scope="row"><?= $file->file_name ?></td>
											<td class="success" scope="row"><?= $file->created_date ?></td>
											<?php if (file_exists(YiiBase::getPathOfAlias('webroot') . '/../uploads/coursedocument/' . $file->course_id . '/' . $file->user_id . '/' . $file->file_address)) { ?>
												<td class="success" scope="row"><a class="btn btn-primary" target="_blank" href="<?= Yii::app()->baseUrl ?>/../uploads/coursedocument/<?= $file->course_id ?>/<?= $file->user_id ?>/<?= $file->file_address ?>">ตรวจสอบเอกสาร</a></td>
											<?php } else { ?>
												<td class="success" scope="row"><a class="btn btn-default" href="javascript:void(0)">ไม่พบเอกสาร</a></td>
											<?php } ?>

											<td class="success" style="text-align: center;" scope="row"><input type="checkbox" class="document_input_id_<?= $key ?>" id="document_id<?= $file->id ?>" name="document_id[]" value="<?= $file->id ?>"></td>
											<td class="success" scope="row"><?= $status ?></td>
											<td class="success" scope="row"><button type="button" class="btn btn-danger btn_remove_doc" value="<?= $file->id ?>">X</button></td>
										</tr>
									<?php } ?>
									<tr>
										<td colspan="4" class="active"> </td>
										<td class="active" style="text-align: center;" scope="row">
											<input type="checkbox" class="document_id_all" name="all-check" id="all-check" parent_id="<?= implode(',', $id_all) ?>"> <label for="all-check">เลือกทั้งหมด</label>
										</td>
										<td colspan="2" class="active"></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success btn_manage_doc" status="confirm" textalert="อนุมัติ" parent_id="<?= $key ?>">อนุมัติ</button>
						<button type="button" class="btn btn-danger btn_manage_doc" status="cancel" textalert="ไม่อนุมัติ" parent_id="<?= $key ?>">ไม่อนุมัติ</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
					</div>
				</div>
			</div>
		</div>

		<?php
	}
}  ?>
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
	$(".document_id_all").click(function() {
		var array_id = ($(this).attr("parent_id")).split(",");
		if ($(this).is(":checked")) {
			var status = true;
		} else {
			var status = false;
		}
		array_id.forEach((item, index) => {
			$("#document_id" + item).prop('checked', status);
		});
	});

	$(".btn_remove_doc").click(function() {
		var id = $(this).attr("value");

		swal({
			title: "ยืนยันที่จะลบใช่หรือไม่",
			text: "",
			type: "info",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "ใช่",
			cancelButtonText: "ไม่",
			closeOnConfirm: true,
			closeOnCancel: true,
		},
		function(isConfirm) {
			if (isConfirm) {
				$.ajax({
					url: "<?= $this->createUrl('ConfirmDocument/DeleteCourseDoc'); ?>",
					type: "POST",
					data: {
						id: id
					},
					success: function(data) {
						if (data == "success") {
							setTimeout(function() {
								swal("สำเร็จ", "", "success");
							}, 2000);
							location.reload();
						} else {
							setTimeout(function() {
								swal("ไม่สำเร็จ", "", "danger");
							}, 2000);
							location.reload();
						}
					}
				});
			}
		});

	});

	$(".btn_manage_doc").click(function() {
		var id = $(this).attr("parent_id");
		var status = $(this).attr("status");
		var textalert = $(this).attr("textalert");
		const input = $(".document_input_id_" + id);
		var array_id = new Array();
		for (var i = input.length - 1; i >= 0; i--) {
			if ($(input[i]).is(":checked")) {
				array_id.push($(input[i]).attr("value"));
			}
		}
		if (array_id.length == 0) {
			swal("ไม่สามารถทำรายการได้", "กรุณาเลือกรายการ", "warning");
		} else {
			swal({
				title: "ยืนยันที่จะ" + textalert + "ใช่หรือไม่",
				text: "",
				type: "info",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "ใช่",
				cancelButtonText: "ไม่",
				closeOnConfirm: true,
				closeOnCancel: true,
			},
			function(isConfirm) {
				if (isConfirm) {
					$.ajax({
						url: "<?= $this->createUrl('ConfirmDocument/ManageStatusCourseDoc'); ?>",
						type: "POST",
						data: {
							array_id: array_id,
							status: status
						},
						success: function(data) {
							if (data == "success") {
								setTimeout(function() {
									swal("สำเร็จ", "", "success");
								}, 2000);
								location.reload();
							} else {
								setTimeout(function() {
									swal("ไม่สำเร็จ", "", "danger");
								}, 2000);
								location.reload();
							}
						}
					});
				}
			});
		}
	});

	function ShowImages(id) {
		$('#selectImages' + id).modal('show');
	}

	function sendMsg(type, id) {
		var ty = type;

		if (ty == 1) {
			swal({
				title: "ยืนยันที่จะอนุมัติใช่หรือไม่",
				text: "",
				type: "info",
				showCancelButton: true,
				confirmButtonClass: "btn-danger",
				confirmButtonText: "ใช่",
				cancelButtonText: "ไม่",
				closeOnConfirm: true,
				closeOnCancel: true,
			},
			function(isConfirm) {
				if (isConfirm) {
					$.ajax({
						url: "<?= $this->createUrl('ConfirmDocument/ConfirmCourse'); ?>",
						type: "POST",
						data: {
							id: id,
							type: ty
						},
						success: function(data) {
							setTimeout(function() {
								swal("สำเร็จ", "", "success");
							}, 2000);
							location.reload();
						}
					});

				}
			}
			);
		} else {
			swal({
				title: "ยืนยันที่จะไม่อนุมัติใช่หรือไม่",
				text: "กรอกหมายเหตุ",
				type: "input",
				showCancelButton: true,
				allowEnterKey: true,
				closeOnConfirm: false,
				confirmButtonText: "ตกลง",
				cancelButtonText: "ยกเลิก",
				animation: "slide-from-top",
			},

			function(inputValue) {
				if (inputValue === null) return false;

				if (inputValue === "") {
					swal.showInputError("กรอกหมายเหตุหมายเหตุ");
					return false
				}
				if (inputValue != false) {
					$.ajax({
						url: "<?= $this->createUrl('ConfirmDocument/ConfirmCourse'); ?>",
						type: "POST",
						data: {
							id: id,
							type: ty,
							description: inputValue
						},
						success: function(data) {
							setTimeout(function() {
								swal("สำเร็จ", "", "success");
							}, 2000);
							location.reload();
						}
					});
				}



			});
		}
	}


	$('[id^="toggle-event"]').change(function() {
		var id = this.value;
		$.ajax({
			url: "<?= $this->createUrl('ConfirmDocument/LockDocumentCourse'); ?>", 
			type: "POST",
			data:  {id:id},
			success: function(data){
					swal("สำเร็จ", "", "success");
					$("#SearchFormAjax").yiiActiveForm('resetForm');
				}
			});
	});
</script>