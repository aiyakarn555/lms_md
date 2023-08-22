<?php
/* @var $this ManageExamResultController */

$this->breadcrumbs=array(
	'จัดการผลการสอบหลักสูตร',
);
?>


<?php 
    $arr = array(1=> 'เรียนรู้ด้วยตัวเอง');
	$arrResult = array(1=> 'ผ่าน' , 2 => 'ไม่ผ่าน');
?>

<style type="text/css">
    .text-white{
        color: white;
    }
</style>

<div class="innerLR">
	<div class="widget">
		<div class="widget-head">
			<h4 class="heading glyphicons search">
				<i></i> ค้นหา:
			</h4>
		</div>
		<?php
		$form = $this->beginWidget('CActiveForm',
			array(
				'action'=>Yii::app()->createUrl($this->route),
				'method'=>'get',
			)
		);
		?>
		<div class="widget-body">
			<dl class="dl-horizontal">
				
				<div class="form-group">
					<dt><label>ประเภทหลักสูตร <b style="color: red"> *</b> : </label></dt>
					<dd>
						<select style="width: 500px;" required="" class="form-select " id="type_cous" aria-label="Default select example" name="type_cou">
							<option value="">--- เลือกประเภทหลักสูตร ---</option>
							<?php
								foreach($arr as $key => $val) {
									?>
									<option <?= ( $_GET['type_cou'] == $key ? 'selected="selected"' : '' ) ?> value="<?= $key ?>"><?= $val ?></option>
									<?php
								}
							?>
						</select>
					</dd>
				</div>

				<div class="form-group">
					<dt><label>หลักสูตร <b style="color: red"> *</b> : </label></dt>
					<dd>
						<select style="width: 500px;" required="" class="form-select " id="course_id" aria-label="Default select example" name="course_id">
							<option value="">--- เลือกหลักสูตร ---</option>
							<?php
								foreach($listCourse as $key => $val) {
									?>
									<option <?= ( $_GET['course_id'] == $key ? 'selected="selected"' : '' ) ?> value="<?= $key ?>"><?= $val ?></option>
									<?php
								}
							?>
						</select>
					</dd>
				</div>

				<div class="form-group" id="form_gen_id">
					<dt><label>รุ่น <b style="color: red"> *</b> : </label></dt>
					<dd>
						<select style="width: 500px;" required="" class="form-select " id="gen_id" aria-label="Default select example" name="gen_id">
							<option value="">--- เลือกรุ่น ---</option>
							<?php
								foreach($listGeneration as $key => $val) {
									?>
									<option <?= ( $_GET['gen_id'] == $key ? 'selected="selected"' : '' ) ?> value="<?= $key ?>"><?= $val ?></option>
									<?php
								}
							?>
						</select>
					</dd>
				</div>

				<div class="form-group">
					<dt><label>สถานะผลการสอบ <b style="color: red"> *</b> : </label></dt>
					<dd>
						<select style="width: 500px;" required="" class="form-select " id="result_status" aria-label="Default select example" name="result_status">
							<option value="">--- เลือกสถานะผลการสอบ ---</option>
							<?php
							foreach($arrResult as $key => $AA) {
								?>
								<option <?= ( $_GET['result_status'] == $key ? 'selected="selected"' : '' ) ?> value="<?= $key ?>"><?= $AA ?></option>
								<?php
							}
							?>
						</select>
					</dd>
				</div>

				<div class="form-group">
					<dt><label>ชื่อ - นามสกุล/เลขบัตรฯ : </label></dt>
					<dd>
						<input style="width: 500px;" name="name_id_search" type="text" class="form-control" placeholder="ชื่อ - นามสกุล/เลขบัตรประชาชน" value="<?= $_GET['name_id_search'] ?>" > 
					</dd>
				</div> 

				<div class="form-group">
					<dt><label>อีเมล : </label></dt>
					<dd>
						<input style="width: 500px;"  name="email" type="text" class="form-control" placeholder="อีเมล" value="<?= $_GET['email'] ?>" > 
					</dd>
				</div> 


				<div class="form-group">
					<dt></dt>
					<dd><button type="submit" class="btn btn-primary btn-icon glyphicons search"><i></i> Search</button></dd>
				</div>
			</dl>
		</div>
		<?php $this->endWidget(); ?>
	</div>
</div>




<?php if(isset($_GET['type_cou'])){ ?>
    <div class="widget" id="export-table33" >
        <div class="widget-head">
            <div class="widget-head">
                <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i>ค้นหาโดยใช้ หลักสูตร</h4>
            </div>
        </div> 
        <div class="widget-body" >
         <table class="table table-bordered table-striped" id="myTable">
            <thead>
                <tr>
                    <th  class="center text-white" rowspan="2">ลำดับ</th>
                    <th  class="center text-white" rowspan="2">เลขบัตรประชาชน</th>                            
                    <th  class="center text-white" rowspan="2">ชื่อ - นามสกุล</th>
					<th  class="center text-white" colspan="2">ผลการสอบ</th>
					<th  class="center text-white" rowspan="2">จัดการ</th>
                </tr>
				<tr>
					<th class="center text-white" rowspan="2">สอบก่อนเรียน</th>
                    <th class="center text-white" rowspan="2">สอบหลังเรียน</th>
				</tr>
            </thead>

            <tbody>
					<?php
							$getPages = $_GET['page'];
                            if($getPages = $_GET['page']!=0 ){
                                $getPages = $_GET['page'] -1;
                            }

							$start_cnt = $dataProvider->pagination->pageSize * $getPages;
							foreach($result as $i => $val) {

								$statusPre = ($val["courseStatusPre"]=="y") ? "text-success":"text-danger" ;
								$statusPost = ($val["courseStatusPost"]=="y") ? "text-success":"text-danger" ;

								?>
								<tr>
									<td ><?= $start_cnt+1?></td>
								    <td class="center"><?= $val["idCard"] ?></td>
									<td class="center"><?= $val["fName"] ?> <?= $val["lName"] ?></td>
									<td class="center" >
                                            <b><span class="<?=$statusPre?>"><?= isset($val["courseScorePre"]) ? $val["courseScorePre"] :"-"  ?></span>
                                        /
                                        <?= isset($val["courseTotalPre"]) ? $val["courseTotalPre"] :"-" ?></b>
                                    </td>
									<td class="center" >
                                            <b><span class="<?=$statusPost?>"><?= isset($val["courseScorePost"]) ? $val["courseScorePost"] :"-"  ?></span>
                                        /
                                        <?= isset($val["courseTotalPost"]) ? $val["courseTotalPost"] :"-" ?></b>
                                    </td>
									<td class="center" style="width:20px;">
										<?=  CHtml::link("<i></i> แก้ไขผลการสอบ",array("/manageExamResult/update",
										"type_cou"=>$_GET['type_cou'],
										"course_id"=>$_GET["course_id"],
										"gen_id"=>$_GET['gen_id'],
										"result_status"=>$_GET['result_status'],
										"name_id_search"=>$_GET['name_id_search'],
										"email"=>$_GET['email'],
										"user_id"=>$val["userId"]
										),array("class"=>"btn btn-danger btn-icon glyphicons pencil")); ?>
									</td>
								</tr>
								<?php
								$start_cnt++;
							}

                        ?>
        	</tbody>
    </table>
</div>
</div>
<?php } ?>


<script>

	$(document).ready( function () {	
        // $('#myTable').DataTable();
    });

	<?php if(isset($_GET['type_cou']) && $_GET['type_cou'] == 2){ ?>
			$("#gen_id").prop('required',false);
			$("#form_gen_id").css("display", "none");
	<?php } ?>
	<?php if(isset($_GET['gen_id']) && $_GET['gen_id'] == 0){ ?>
			$("#gen_id").html("<option value='0'>ยังไม่มีรุ่น</option>");
	<?php } ?>
	$('#type_cous').on('change', function() {
		<?php unset($listCourse) ?>
		<?php unset($listGeneration) ?>
		if(this.value !== ""){
			if(this.value == 2){
				$("#gen_id").prop('required',false);
				$("#form_gen_id").css("display", "none");
			}else{
				$("#form_gen_id").css("display", "");
				$("#gen_id").prop('required',true);
			}
			$("#course_id").html("<option value=''>กรุณารอสักครู่...</option>");
			var dataString = "type="+this.value;
			$.ajax({
				type: 'GET',
				data: dataString,
				url: "<?= $this->createUrl('ManageExamResult/ListCourse') ?>",
				success: function (data) {
					$("#course_id").html("<option value=''>--- เลือกหลักสูตร ---</option>");
					var result = JSON.parse(data);
					if(result.length > 0){
						$.each( result, function( index, d ) {
							$('#course_id').append($('<option>', { 
								value: d[0],
								text : d[1] 
							}));
						});
					}else{
						$("#course_id").html("<option value='0'>ยังไม่มีหลักสูตรเรียนรู้ด้วยตัวเอง</option>");
					}
					
				}
			});
		}else{
			$("#course_id").html("<option value=''>--- เลือกหลักสูตร ---</option>");
			$("#gen_id").html("<option value=''>--- เลือกรุ่น ---</option>");
		}
	
	});

	$('#course_id').on('change', function() {
		<?php unset($listCourse) ?>
		<?php unset($listGeneration) ?>
		if(this.value !== "" && $("#type_cous").val() == 1){
			$("#gen_id").html("<option value=''>กรุณารอสักครู่...</option>");
			var dataString = "course_id="+this.value;
			$.ajax({
				type: 'GET',
				data: dataString,
				url: "<?= $this->createUrl('ManageExamResult/ListGeneration') ?>",
				success: function (data) {
					$("#gen_id").html("<option value=''>--- เลือกรุ่น ---</option>");
					var result = JSON.parse(data);
					if(result.length > 0){
						$.each( result, function( index, d ) {
							$('#gen_id').append($('<option>', { 
								value: d[0],
								text : d[1] 
							}));
						});
					}else{
						$("#gen_id").html("<option value='0'>ยังไม่มีรุ่น</option>");
					}
					
				}
			});
		}else{
			$("#gen_id").html("<option value=''>--- เลือกรุ่น ---</option>");
		}
		
	});
</script>