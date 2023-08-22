<?php
$this->breadcrumbs=array(
	'ประวัติอนุมัติหลักสูตรทฤษฎี(เอกสารแนบ)',
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
	$.appendFilter("CourseTemp[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);

				?>
				<div id="user" class="innerLR">

					<?php $this->widget('AdvanceSearchForm', array(
						'data'=>$model,
						'route' => $this->route,
						'attributes'=>array( 
							array('name'=>'courseTi','type'=>'text'),
							array('name'=>'fullname','type'=>'text'),
							array('name'=>'datestr','type'=>'text'),
							array('name'=>'dateend','type'=>'text'),
						)
					));
					?>
					<div class="widget" style="margin-top: -1px;">
						<div class="widget-head">
							<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration"); ?></h4>
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
									'dataProvider'=>$model->search_document_history(),
									'filter'=>$model,
									'selectableRows' => 2,
									//'rowCssClassExpression'=>'"items[]_{$data->id}"',
									// 'htmlOptions' => array(
									// 	'style'=> "margin-top: -1px;width:200%;",
									// ),
									'afterAjaxUpdate'=>'function(id, data){
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

									'columns'=>array(
										array(
											'header'=>'No.',
											'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
											'filterHtmlOptions'=>array('style'=>'width:1px;'), 
											'htmlOptions'=>array('style'=>'text-align: center;hight:5%;'),
										),

										array(
											'header'=>'ชื่อ - นามสกุล',
											'type'=>'html',
											'filter' => false,
											'value'=>function($data){
												return $data->profile->firstname . " " . $data->profile->lastname;
											},
											'filterHtmlOptions'=>array('style'=>'width:30px'),
										),

										array(
											'header'=>'หลักสูตร',
											'type'=>'html',
											'filter' => false,
											'value'=>function($data){
												return $data->course->course_title;
											},
											'filterHtmlOptions'=>array('style'=>'width:30px'),
										),
										array(
											'header'=>'วันที่แนบเอกสาร',
											'type'=>'html',
											'filter' => false,
											'value'=>function($data){
												return Helpers::changeFormatDate($data->date_set_document,'datetime');
											},
											'filterHtmlOptions'=>array('style'=>'width:30px'),
											// 'htmlOptions'=>array('style'=>'text-align: center;width:100%;'),
											// 'headerHtmlOptions'=>array('style'=>'text-align:center;width:100%;'),
										),
										array(
											'header'=>'วันที่อนุมัติแนบเอกสาร',
											'type'=>'html',
											'filter' => false,
											'value'=>function($data){
												return Helpers::changeFormatDate($data->date_confirm_document,'datetime');
											},
											'filterHtmlOptions'=>array('style'=>'width:30px'),
											// 'htmlOptions'=>array('style'=>'text-align: center;width:100%;'),
											// 'headerHtmlOptions'=>array('style'=>'text-align:center;width:100%;'),
										),


											array(
											'type'=>'raw',
											'value'=>function($data){

												return '<button data-id="'.$data->id.'" class="btn btn-info" onclick="ShowImages('.$data->id.')">ตรวจสอบเอกสารแนบ</button>';
												
												// return  CHtml::button("ดูรูปภาพ",array('onclick'=>'ShowImages('.$data->id.')','class' => 'btn btn-info','data-id' =>$data->id));
											},
											'header' => 'เอกสารแนบ',
											'htmlOptions'=>array('style'=>'text-align: center;'),
											'headerHtmlOptions'=>array( 'style'=>'text-align:center;width:5%;'),
										),
											array(
												'header'=>'ผู้อนุมัติ',
												'type'=>'html',
												'filter' => false,
												'value'=>function($data){
													return $data->profileconfirmdocument->firstname . " " . $data->profileconfirmdocument->lastname;
												},
												'filterHtmlOptions'=>array('style'=>'width:30px'),
											),
											array(
												'header'=>'หมายเหตุ',
												'type'=>'html',
												'filter' => false,
												'value'=>function($data){
													if($data->status_document == "y"){
														return "-";
													}elseif($data->status_document == "x"){
														return $data->note_document;
													}else{
														return "ไม่พบข้อมูล";
													}
													
												},
												'filterHtmlOptions'=>array('style'=>'width:30px'),
											),
											array(
												'header' => 'สถานะ',
												'htmlOptions'=>array('style'=>'text-align: center;'),
												'headerHtmlOptions'=>array( 'style'=>'text-align:center;width:20%;'),
												'type'=>'raw',
												'value'=>function($data){
													if($data->status_document == "y"){
														return '<button onclick="sendMsg(2,'.$data->id.')" class="btn btn-success">อนุมัติ</button>';
													}elseif($data->status_document == "x"){
														return '<button onclick="sendMsg(1,'.$data->id.')" class="btn btn-danger">ไม่อนุมัติ</button>';
													}else{
														return '<button class="btn btn-warning">ไม่พบข้อมูล</button>';
													}
												// return  CHtml::button("เปลี่ยนรหัสผ่าน",array('onclick'=>'sendMsg('.$data->id.')','class' => 'btn btn-info','data-id' =>$data->id));

												},

										),
											array(
												'header' => 'การล็อค',
												'type'=>'raw',
												'value'=>function($data){
													if($data->lock_document == 'n'){
														// return CHtml::link("ปิด",array("/HistoryRegis/LockDocumentCourse","id"=>$data->id), array("class"=>"btn btn-danger"));
														return '<input  id="toggle-event" type="checkbox" data-toggle="toggle" data-onstyle="success" value="'.$data->id.'">';
													} else {
														// return CHtml::link("เปิด",array("/HistoryRegis/LockDocumentCourse","id"=>$data->id), array("class"=>"btn btn-success"));
														return '<input  id="toggle-event" type="checkbox" checked data-toggle="toggle" data-onstyle="success" value="'.$data->id.'">';
													}
												},
												'htmlOptions'=>array('style'=>'text-align: center;width:100px;'),
												'headerHtmlOptions'=>array( 'style'=>'text-align:center;width:100px;'),
											),
									
									),
));


?>
<?php 

// $sqlUser = "SELECT * from tbl_course_temp WHERE status  ='n'";
// $modelUser = Yii::app()->db->createCommand($sqlUser)->queryAll();

$criteria = new CDbCriteria;
$criteria->with = array('course','course.cates','profile');
$criteria->compare('courseonline.document_status','y');
$criteria->compare('t.status','y');
$criteria->addNotInCondition('t.status_document',['w','n']);
$modelUser = CourseTemp::model()->findAll($criteria);
if(!empty($modelUser)){
	foreach ($modelUser as $key => $value) {
		$criteria = new CDbCriteria;
		$criteria->compare('course_id',$value->course_id);
		$criteria->compare('course_temp_id',$value->id);
		$criteria->compare('user_id',$value->user_id);
		$criteria->compare('active','y');
		$courseDocument = CourseDocument::model()->findAll($criteria);
		?>
<div class="modal fade"  id="selectImages<?=$value['id']?>" tabindex="-1" role="dialog" aria-labelledby="course-booking">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ตรวจสอบเอกสารหลักสูตร</h4>
      </div>
      <div class="modal-body">
      	<div class="table-responsive">
      		<table class="table">
      			<tr>
      				<th class="active" scope="col">ลำดับ</th>
      				<th class="active" scope="col">ชื่อไฟล์เอกสาร</th>
      				<th class="active" scope="col">เอกสาร</th>
      			</tr>
      			<tbody>
      				<?php foreach ($courseDocument as $keyfile => $file) { ?>
      					<tr>
      						<td class="success" scope="row"><?=$keyfile+1?></td>
      						<td class="success" scope="row"><?=$file->file_name?></td>
      						<td class="success" scope="row"><a class="btn btn-primary" target="_blank" href="<?= Yii::app()->baseUrl ?>/../uploads/coursedocument/<?=$file->course_id?>/<?=$file->user_id?>/<?= $file->file_address ?>">ตรวจสอบเอกสาร</a></td>
      					</tr>
      				<?php } ?>
      			</tbody>
      		</table>
      	</div>
      </div>
      <div class="modal-footer">
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
	$(document).ready(function(){
        $("#CourseTemp_datestr").datepicker({
			dateFormat:'yy-mm-dd',
			onSelect: function(selected) {
				$("#CourseTemp_dateend").datepicker("option","minDate", selected)
              }
          });
        $("#CourseTemp_dateend").datepicker({     
			dateFormat:'yy-mm-dd',
			onSelect: function(selected) {
				$("#CourseTemp_datestr").datepicker("option","maxDate", selected)
             }
         });     
	});
	function ShowImages(id){
		$('#selectImages'+id).modal('show');
	}
	function sendMsg(type,id){
		var ty = type;

		if(ty == 1){
			swal({
				title: "เปลี่ยนสถานะเป็น อนุมัติ ใช่หรือไม่",
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
						data:  {id:id,type:ty},
						success: function(data){
							setTimeout(function () {
								swal("สำเร็จ", "", "success");
							}, 2000);
							location.reload();
						}
					});

				} 
			}
			);
		}else{
			swal({
				title: "เปลี่ยนสถานะเป็น ไม่อนุมัติ ใช่หรือไม่",
				text: "กรอกหมายเหตุ",
				type: "input",
				showCancelButton: true,
				allowEnterKey: true,
				closeOnConfirm: false,
				confirmButtonText: "ตกลง",
				cancelButtonText: "ยกเลิก",
				animation: "slide-from-top",
			},

			function (inputValue) {
				if (inputValue === null) return false;

				if (inputValue === "") {
					swal.showInputError("กรอกหมายเหตุหมายเหตุ");
					return false
				}
				if(inputValue != false){
					$.ajax({
						url: "<?= $this->createUrl('ConfirmDocument/ConfirmCourse'); ?>", 
						type: "POST",
						data:  {id:id,type:ty,description:inputValue},
						success: function(data){
							setTimeout(function () {
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
			url: "<?= $this->createUrl('HistoryRegis/LockDocumentCourse'); ?>", 
			type: "POST",
			data:  {id:id},
			success: function(data){
					swal("สำเร็จ", "", "success");
					$("#SearchFormAjax").yiiActiveForm('resetForm');
					// location.reload();
				}
			});
	});
	
</script>
