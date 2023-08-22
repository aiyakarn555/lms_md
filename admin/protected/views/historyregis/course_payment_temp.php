<?php
$this->breadcrumbs=array(
	'ประวัติอนุมัติหลักสูตรทฤษฎี(ชำระเงิน)',
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

				
<style>
	#CourseTemp_type_cou{
		width:28.5rem;
	}
</style>
				<div id="user" class="innerLR">

					<?php 
					$this->widget('AdvanceSearchForm', array(
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
									'dataProvider'=>$model->search_payment_history(),
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
											'header'=>'วันที่ชำระเงิน',
											'type'=>'html',
			// 'value'=>'UHtml::markSearch($data,"create_date")'
											'filter' => false,
											'value'=>function($data){
												return Helpers::changeFormatDate($data->date_set_payment,'datetime');
											},
											'filterHtmlOptions'=>array('style'=>'width:30px'),
											// 'htmlOptions'=>array('style'=>'text-align: center;width:100%;'),
											// 'headerHtmlOptions'=>array('style'=>'text-align:center;width:100%;'),
										),


										array(
											'header'=>'วันที่อนุมัติชำระเงิน',
											'type'=>'html',
			// 'value'=>'UHtml::markSearch($data,"create_date")'
											'filter' => false,
											'value'=>function($data){
												return Helpers::changeFormatDate($data->date_confirm_payment,'datetime');
											},
											'filterHtmlOptions'=>array('style'=>'width:30px'),
											// 'htmlOptions'=>array('style'=>'text-align: center;width:100%;'),
											// 'headerHtmlOptions'=>array('style'=>'text-align:center;width:100%;'),
										),

										array(
											'header'=>'ราคา',
											'type'=>'html',
											'filter' => false,
											'value'=>function($data){
												if($data->course->price == 'y'){
													return $data->course->course_price;
												}
											},
											'filterHtmlOptions'=>array('style'=>'width:30px'),
										),


											array(
											'type'=>'raw',
											'value'=>function($data){

												return '<button data-id="'.$data->id.'" class="btn btn-info" onclick="ShowImages('.$data->id.')">ดูหลักฐานการจ่ายเงิน</button>';
												
												// return  CHtml::button("ดูรูปภาพ",array('onclick'=>'ShowImages('.$data->id.')','class' => 'btn btn-info','data-id' =>$data->id));
											},
											'header' => 'หลักฐานการจ่ายเงิน',
											'htmlOptions'=>array('style'=>'text-align: center;'),
											'headerHtmlOptions'=>array( 'style'=>'text-align:center;width:5%;'),
										),
											array(
												'header'=>'ผู้อนุมัติ',
												'type'=>'html',
												'filter' => false,
												'value'=>function($data){
													return $data->profileconfirmpayment->firstname . " " . $data->profileconfirmpayment->lastname;
												},
												'filterHtmlOptions'=>array('style'=>'width:30px'),
											),
											array(
												'header'=>'หมายเหตุ',
												'type'=>'html',
												'filter' => false,
												'value'=>function($data){
													return $data->note_payment;
												},
												'filterHtmlOptions'=>array('style'=>'width:30px'),
											),
												array(
												'header' => 'สถานะ',
												'htmlOptions'=>array('style'=>'text-align: center;'),
												'headerHtmlOptions'=>array( 'style'=>'text-align:center;width:20%;'),
												'type'=>'raw',
												'value'=>function($data){
													if($data->status_payment == "y"){
														return '<button onclick="sendMsg(2,'.$data->id.')" class="btn btn-success">อนุมัติ</button>';
													}elseif($data->status_payment == "x"){
														return '<button onclick="sendMsg(1,'.$data->id.')" class="btn btn-danger">ไม่อนุมัติ</button>';
													}else{
														return '<button class="btn btn-warning">ไม่พบข้อมูล</button>';
													}
												},

										),
									
									),
));


?>
<?php 

// $sqlUser = "SELECT * from tbl_course_temp WHERE status  ='n'";
// $modelUser = Yii::app()->db->createCommand($sqlUser)->queryAll();

$criteria = new CDbCriteria;
$criteria->with = array('course','course.cates','profile');
$criteria->compare('courseonline.price','y');
$criteria->compare('t.status','y');
$criteria->addNotInCondition('t.status_payment',['w','n']);
$modelUser = CourseTemp::model()->findAll($criteria);

if(!empty($modelUser)){
	foreach ($modelUser as $key => $value) {
		?>

		<div class="modal fade" id="selectImages<?=$value['id']?>" tabindex="-1" role="dialog" aria-labelledby="course-booking">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">หลักฐานการจ่ายเงิน</h4>
            </div>
            <div class="modal-body body-pay">

                    <div class="pay-course">
                        <h4>ธนาคารที่โอนเข้า</h4>
                        <?php
                        $valueb = BankBooking::model()->findByPk($value['bank_id']);
                        ?>
                            <div class=" row-pay align-items-center">
                                <img class="mx-2" src="<?php echo Yii::app()->baseUrl; ?>/../uploads/bank/<?= $valueb->id ?>/<?= $valueb->bank_images ?>" width="80" alt="">
                                <div class="account-bank" >
                                <h4 class="">ธนาคาร : <span class="text-main"><?= $valueb->bank_name ?></span></h4>
                                <h4 class="">ชื่อบัญชี : <span class="text-main"><?= $valueb->account_name ?></span></h4>
                                <h4 class="">หมายเลขบัญชี : <span class="text-main"><?= $valueb->account_number ?></span></h4>

								<h4 class="">จำนวนเงินที่โอน : <span class="text-main"><?=$value['money']?></span> บาท</h4>
								<h4 class="">วันเวลาที่โอน : <span class="text-main"><?=Helpers::changeFormatDate($value['date_slip'],'datetime')?></span></h4>
                                </div>
                            </div>
                    </div>
                    <div class="pay-course">
					<h4 class="">รูปภาพหลักฐานการโอน : </h4>
                       <?php if(file_exists(YiiBase::getPathOfAlias('webroot').'/../uploads/coursepayment/'.$value['file_payment'])){ ?>
							<img src="<?php echo Yii::app()->request->baseUrl.'/../uploads/coursepayment/'.$value['file_payment'] ?>" class="" width="500" height="400" alt="">
						<?php }else{  ?>
							<img src="<?php echo Yii::app()->theme->baseUrl.'/images/default-avatar.png' ?>" width="500" height="400" class="" alt="">

						<?php } ?>
                    </div>

            </div>

        </div>
    </div>
</div>


		<!-- <div class="modal fade" tabindex="-1" role="dialog" id="selectImages<?=$value['id']?>" >
			<div class="modal-dialog modal-lg" role="document" style="width: 500px;height:400px;">
				<div class="modal-content">
					<div class="modal-header" style="background-color: #3C8DBC;">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" style="color: #fff;font-size: 22px;">&times;</span></button>
						<h4 class="modal-title" style="font-size: 20px;color: #fff;padding: .3em;">ข้อความ</h4> 
					</div>
					<div class="modal-body" style="align-self: center;">
						<?php if(file_exists(YiiBase::getPathOfAlias('webroot').'/../uploads/coursepayment/'.$value['file_payment'])){ ?>
							<img src="<?php echo Yii::app()->request->baseUrl.'/../uploads/coursepayment/'.$value['file_payment'] ?>" class="" width="500" height="400" alt="">
						<?php }else{  ?>
							<img src="<?php echo Yii::app()->theme->baseUrl.'/images/default-avatar.png' ?>" width="500" height="400" class="" alt="">
						<?php } ?>
						
					</div>
					<div class="modal-footer" style="background-color: #eee;">
						<button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
						 <button id="btnSubmit" type="submit" class="btn btn-primary" onclick="saveModal()">บันทึก</button> 
					</div>
				</div>
			</div>
		</div> -->
		
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
			var txt = 'อนุมัติ';
		}else{
			var txt = 'ไม่อนุมัติ';
		}
		swal({
			title: "เปลี่ยนสถานะเป็น "+txt+" ใช่หรือไม่",
			text: "กรอกหมายเหตุ",
			type: "input",
			confirmButtonClass: "btn-danger",
			showCancelButton: true,
			allowEnterKey: true,
			closeOnConfirm: false,
			confirmButtonText: "ตกลง",
			cancelButtonText: "ยกเลิก",
			animation: "slide-from-top",
		},
		function(isConfirm) {
			if (isConfirm === null) return false;

			if (isConfirm === "") {
				swal.showInputError("กรอกหมายเหตุหมายเหตุ");
				return false
			}
			if(isConfirm != false){
				$.ajax({
					url: "<?= $this->createUrl('CourseOnline/ConfirmCourse'); ?>", 
					type: "POST",
					data:  {id:id,type:ty,description:isConfirm},
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
		

	}


</script>
