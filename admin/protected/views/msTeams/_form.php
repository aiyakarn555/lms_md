<script src="<?php echo $this->assetsBase;; ?>/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo $this->assetsBase;; ?>/js/jquery.uploadifive.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jwplayer/jwplayer.js" type="text/javascript"></script>
<script type="text/javascript">jwplayer.key="MOvEyr0DQm0f2juUUgZ+oi7ciSsIU3Ekd7MDgQ==";</script>


<style>
	<style>
	.checkbox label:after {
		content: '';
		display: table;
		clear: both;
	}

	.checkbox .cr {
		position: relative;
		display: inline-block;
		border: 1px solid #a9a9a9;
		border-radius: .25em;
		width: 1.3em;
		height: 1.3em;
		float: left;
		margin-right: .5em;
	}

	.radio .cr {
		border-radius: 50%;
	}

	.checkbox .cr .cr-icon {
		position: absolute;
		font-size: .8em;
		line-height: 0;
		top: 50%;
		left: 20%;
	}

	.checkbox label {
		display: inline-block;
	}

	.checkbox label input[type="checkbox"]{
		display: none;
	}

	.checkbox label input[type="checkbox"] + .cr > .cr-icon{
		transform: scale(3) rotateZ(-20deg);
		opacity: 0;
		transition: all .3s ease-in;
	}

	.checkbox label input[type="checkbox"]:checked + .cr > .cr-icon{
		transform: scale(1) rotateZ(0deg);
		opacity: 1;
	}

	.checkbox label input[type="checkbox"]:disabled + .cr{
		opacity: .5;
	}
</style>
</style>
<div class="innerLR">
	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i><?php echo $formtext;?>
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<div class="form">
				<?php $form=$this->beginWidget('AActiveForm', array(
					'id'=>'course-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true
					),
					'errorMessageCssClass' => 'label label-important',
					'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>

				<?php 
				$attSearch = array("class"=>"form-control span8",'disable_search' => false);
				// $array_md_code = array_diff(array_merge(CHtml::listData(MsTeams::model()->findAll(),'course_md_code', 'course_md_code'),CHtml::listData(CourseOnline::model()->findAll(),'course_md_code', 'course_md_code')),[""]);
				// sort($array_md_code);

				if($model->course_md_code != null || $model->ms_teams_number != null){
					$codeOld = MtCodeMd::model()->find(array(
						'condition'=>'code_md=:code_md ',
						'params' => array(':code_md' => $model->course_md_code != null ? $model->course_md_code : $model->ms_teams_number )
					));

				}
				$criteria = new CDbCriteria;
				$criteria->compare('type',2);
				$new_code_arr = CHtml::listData(MtCodeMd::model()->findAll($criteria),'code_md', 'code_gm');

				$new_code_arr = array('' =>'เลือกรหัสหลักสูตร GM') + $new_code_arr;

				$msTeamsNumberArr = CHtml::listData(MtCodeMd::model()->findAll($criteria),'code_md', 'code_md');

				$msTeamsNumberArr = array('' =>'รหัสหลักสูตร กรมเจ้าท่า') + $msTeamsNumberArr;

				$hostzoom_arr = CHtml::listData(ZoomHosting::model()->findAll(),'id', 'hostmail');

				if($model->isNewRecord)
				{
					$attHostmail = array("class"=>"form-control span8",'disable_search' => false);
					$attStartDate = array('class' => 'default_datetimepicker datestr','autocomplete'=>'off');
					$attTimeStartDate = array('class' => 'default_datetimepicker_time','autocomplete'=>'off');
					$attDuration = array('placeholder'=>"เวลาต่ำสุด 30 นาทื",'min'=>"30",'style'=>"width:208px",'size'=>60,'maxlength'=>255, 'class'=>'span8');
					$attDurationAuthen = array('placeholder'=>"เวลาต่ำสุด 10 นาที",'min'=>"0",'style'=>"width:208px",'size'=>60,'maxlength'=>255, 'class'=>'span8');
					$attEndDate = array('class' => 'default_datetimepicker dateend','autocomplete'=>'off');
					$attTimeEndDate = array('class' => 'default_datetimepicker_time','autocomplete'=>'off');
				}else{
					$attHostmail = array("class"=>"form-control span8",'disable_search' => false,'disabled'=>true);
					$attStartDate = array('class' => 'default_datetimepicker datestr','autocomplete'=>'off','readonly'=>true);
					$attTimeStartDate = array('class' => 'default_datetimepicker_time','autocomplete'=>'off','readonly'=>true);
					$attDuration = array('placeholder'=>"เวลาต่ำสุด 30 นาทื",'min'=>"30",'style'=>"width:208px",'size'=>60,'maxlength'=>255, 'class'=>'span8','readonly'=>true);
					$attDurationAuthen = array('placeholder'=>"เวลาต่ำสุด 10 นาทื",'min'=>"10",'style'=>"width:208px",'size'=>60,'maxlength'=>255, 'class'=>'span8');
					$attEndDate = array('class' => 'default_datetimepicker dateend','autocomplete'=>'off','readonly'=>true);
					$attTimeEndDate = array('class' => 'default_datetimepicker_time','autocomplete'=>'off','readonly'=>true);
				}
				?>

				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>


				<div class="row">
					<div class="col-md-12">
						<?php echo $form->labelEx($model,'isNameSameCode'); ?>
						<?php echo $form->checkBox($model,'isNameSameCode',array(
							'data-toggle'=> 'toggle','value'=>"y", 'uncheckValue'=>"n"
						)); ?>
						<?php echo $form->error($model,'isNameSameCode'); ?>
					</div>
				</div>

				<div class="row name_ms_teams" style="display: none;">
					<div class="col-md-12">
						<?php echo $form->labelEx($model,'name_ms_teams'); ?>
						<?php echo $form->textField($model,'name_ms_teams',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'name_ms_teams'); ?>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<?php echo $form->labelEx($model,'course_md_code'); ?>
						<?php echo Chosen::activeDropDownList($model, 'course_md_code', $new_code_arr, $attSearch); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'course_md_code'); ?>
					</div>
					<div class="col-md-8">
						<?php echo $form->labelEx($model,'ms_teams_number'); ?>
						<?php echo Chosen::activeDropDownList($model, 'ms_teams_number', $msTeamsNumberArr, $attSearch); ?>
						<?php //echo $form->textField($model,'ms_teams_number',array('size'=>60,'maxlength'=>255, 'class'=>'span8','value'=>"$model->course_md_code" )); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'ms_teams_number'); ?>
					</div>
				</div> 

				<div class="row">
					<div class="col-md-12">
						<label> ชื่อหลักสูตร </label>
						<input type="text" id="name_code" value="<?=$codeOld->name_md?>" readonly="readonly" maxlength= '255' class="span8" size='60'>
					</div>
				</div>


				<div class="row">
					<div class="col-md-12">
						<?php echo $form->labelEx($model,'instructor_name'); ?>
						<?php echo $form->textField($model,'instructor_name',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'instructor_name'); ?>
					</div>
				</div> 
				
				

	<!-- <div class="row">
		<div class="col-md-12">
		<?php echo $form->labelEx($model,'url_join_meeting'); ?>
		<?php echo $form->textField($model,'url_join_meeting',array('size'=>100,'maxlength'=>255, 'class'=>'span8')); ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'url_join_meeting'); ?>
		</div>
	</div> -->

	

	<div class="row">
		<div class="col-md-12">
			<label><h4>รายละเอียดห้องเรียนออนไลน์</h4></label>
			<textarea name="MsTeams[detail_ms_teams]" class="survey-header-detail tinymce" id="MsTeams_detail_ms_teams" cols="30" rows="10"><?php echo ($model->detail_ms_teams); ?></textarea>
		</div>

	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<?php echo $form->labelEx($model,'hostmail'); ?>
			<?php echo Chosen::activeDropDownList($model, 'hostmail', $hostzoom_arr, $attHostmail); ?>
			<?php echo $this->NotEmpty();?>
			<?php echo $form->error($model,'hostmail'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?php echo $form->labelEx($model,'start_date'); ?>
			<?php echo $form->textField($model,'start_date',$attStartDate); ?>
			<?php echo $this->NotEmpty();?>
			<?php echo $form->error($model,'start_date'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?php echo $form->labelEx($model,'end_date'); ?>
			<?php echo $form->textField($model,'end_date',$attEndDate); ?>
			<?php echo $this->NotEmpty();?>
			<?php echo $form->error($model,'end_date'); ?>
		</div>
	</div> 

	<div class="row">
		<div class="col-md-12">
			<?php echo $form->labelEx($model,'time_start_date'); ?>
			<?php echo $form->textField($model,'time_start_date',$attTimeStartDate); ?>
			<?php echo $this->NotEmpty();?>
			<?php echo $form->error($model,'time_start_date'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?php echo $form->labelEx($model,'time_end_date'); ?>
			<?php echo $form->textField($model,'time_end_date',$attTimeEndDate); ?>
			<?php echo $this->NotEmpty();?>
			<?php echo $form->error($model,'time_end_date'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?php echo $form->labelEx($model,'duration'); ?>
			<?php echo $form->numberField($model,'duration',$attDuration); ?>
			<?php echo $this->NotEmpty();?>
			<?php echo $form->error($model,'duration'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?php echo $form->labelEx($model,'duration_authen'); ?>
			<?php echo $form->numberField($model,'duration_authen',$attDurationAuthen); ?>
			<?php echo $this->NotEmpty();?>
			<?php echo $form->error($model,'duration_authen'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?php echo $form->labelEx($model,'price'); ?>
			<?php echo $form->checkBox($model,'price',array(
				'data-toggle'=> 'toggle','id'=>"pricechk",'value'=>"y", 'uncheckValue'=>"n"
			)); ?>
			<?php echo $form->error($model,'price'); ?>
		</div>
	</div>

<div class="row course_price_chk" style="display: none;">
		<?php echo $form->labelEx($model,'ms_price'); ?>
		<?php echo $form->numberField($model,'ms_price',array('size'=>60,'min'=>"0",'maxlength'=>255,'class'=>'span8','oninput'=>"this.value = Math.abs(this.value)")) ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'ms_price'); ?>
	</div> 



	<?php if($model->isNewRecord){ ?>
		<div class="row">
			<div class="col-md-12">
				<?php echo $form->labelEx($model,'document_status'); ?>
				<?php echo $form->checkBox($model,'document_status',array(
					'data-toggle'=> 'toggle','value'=>"y", 'uncheckValue'=>"n"
				)); ?>
				<?php echo $form->error($model,'document_status'); ?>
			</div>
		</div>
	<?php } ?>



	<br>
	<div class="row">
		<div class="col-md-12">
			<?php echo $form->labelEx($model,'intro_video'); ?>
			<div class="fileupload fileupload-new" data-provides="fileupload">
				<div class="input-append">
					<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($model, 'intro_video'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
				</div>
			</div>
			<?php echo $form->error($model,'intro_video'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<font color="#990000">
				<?php echo $this->NotEmpty();?> ตัวอย่างวิดีโอ ไม่ควรมีขนาดเกิน 2 GB
			</font>
		</div>
	</div>
	<?php 
	$idx = $model->id;
	$uploadFolder = Yii::app()->getUploadUrl(null)."../msteams/";
	if($model->intro_video != null){

		?>
		<div class="row" style="padding-top:20px; width:480px;">
			<div id="vdo<?php echo $idx; ?>">Loading the player...</div>
		</div>
		<script type="text/javascript">
			var playerInstance<?php echo $idx; ?> = jwplayer("vdo<?php echo $idx; ?>").setup({
				file: '<?php echo $uploadFolder.$model->intro_video; ?>'
			});

			playerInstance<?php echo $idx; ?>.onReady(function() {
				if(typeof $("#vdo<?php echo $idx; ?>").find("button").attr('onclick') == "undefined"){
					$("#vdo<?php echo $idx; ?>").find("button").attr('onclick','return false');
				}
				playerInstance<?php echo $idx; ?>.onPlay(function(callback) {
					console.log(callback);
				});
			});

		</script>
	<?php } ?>
	<br>


	

	<br>
	<div class="row">
		<div class="col-md-12">
			<?php
			if(isset($imageShow)){
				echo CHtml::image(Yush::getUrl($model, Yush::SIZE_THUMB, $imageShow), $imageShow,array(
					"class"=>"thumbnail"
				));
			}
			?>
		</div>
	</div>
	<br>

	<div class="row">
		<div class="col-md-12">
			<?php echo $form->labelEx($model,'ms_teams_picture'); ?>
			<div class="fileupload fileupload-new" data-provides="fileupload">
				<div class="input-append">
					<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($model, 'ms_teams_picture'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
				</div>
			</div>
			<?php echo $form->error($model,'ms_teams_picture'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<font color="#990000">
				<?php echo $this->NotEmpty();?> รูปภาพควรมีขนาด 250x180(แนวนอน) หรือ ขนาด 250x(xxx) (แนวยาว)
			</font>
		</div>
	</div>
	<br>

	<div class="row buttons">
		<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
	</div>
	<?php $this->endWidget(); ?>
</div><!-- form -->
</div>
</div>
</div>
<!-- END innerLR -->
<script type="text/javascript">
	$( document ).ready(function() {
		<?php if (isset($messageError) && $messageError != null) { ?>
			swal({
				title: "ไม่สามารถเลือกเวลา "+"<?=$messageError?>",
				text: "กรุณาเลือกเวลาในการเปิดห้องเรียนใหม่อีกครั้ง",
			});
		<?php } ?>
	});

	$("#MsTeams_start_date").on('change', function(){

		if($("#MsTeams_end_date").val() != ""){

			$("#MsTeams_time_start_date").val(null);
			$("#MsTeams_time_end_date").val(null);

			var myDatest = this.value;

			myDatest = myDatest.split("-");
			var newDateSt = new Date( myDatest[0], myDatest[1] - 1, myDatest[2]);
			// console.log(newDateSt.getTime());

			var myDate = $("#MsTeams_end_date").val();
			myDate = myDate.split("-");
			var newDateEn = new Date( myDate[0], myDate[1] - 1, myDate[2]);
			// console.log(newDateEn.getTime());

			if(newDateEn.getTime() < newDateSt.getTime()){
				swal({
					title: "",
					text: "วันที่สิ้นสุดเข้าเรียนไม่ควรน้อยกว่าวันที่เข้าเรียน",
				});
				$("#MsTeams_end_date").val($("#MsTeams_start_date").val())
			}

		}
	})


	$("#MsTeams_end_date").on('change', function(){

		$("#MsTeams_time_start_date").val(null);
		$("#MsTeams_time_end_date").val(null);

		if($("#MsTeams_start_date").val() == ""){
			swal({
				title: "",
				text: "กรุณาเลือกวันที่เข้าเรียน",
			});
			$("#MsTeams_end_date").val(null)

		}else{
			var myDatest = $("#MsTeams_start_date").val();

			myDatest = myDatest.split("-");
			var newDateSt = new Date( myDatest[0], myDatest[1] - 1, myDatest[2]);
			// console.log(newDateSt.getTime());

			var myDate = this.value;
			myDate = myDate.split("-");
			var newDateEn = new Date( myDate[0], myDate[1] - 1, myDate[2]);
			// console.log(newDateEn.getTime());

			if(newDateEn.getTime() < newDateSt.getTime()){
				swal({
					title: "",
					text: "วันที่สิ้นสุดเข้าเรียนไม่ควรน้อยกว่าวันที่เข้าเรียน",
				});
				$("#MsTeams_end_date").val($("#MsTeams_start_date").val())
			}

		}
	})


	$("#MsTeams_time_end_date").on('change', function(){

		if($("#MsTeams_time_start_date").val() == ""){
			swal({
				title: "",
				text: "กรุณาเลือกเวลาเริ่มเข้าเรียน",
			});
			$("#MsTeams_time_end_date").val(null)

		}else{

			var TimeSt = $("#MsTeams_time_start_date").val();
			var TimeEN = $("#MsTeams_time_end_date").val();

			var myDatest = $("#MsTeams_start_date").val();
			var myDatestEn = $("#MsTeams_end_date").val();


			myDatest = myDatest.split("-");
			var newDateSt = new Date( myDatest[0], myDatest[1] - 1, myDatest[2]);

			myDate = myDatestEn.split("-");
			var newDateEn = new Date( myDate[0], myDate[1] - 1, myDate[2]);

			if(newDateEn.getTime() == newDateSt.getTime() || myDatestEn == ""){
				if(TimeEN <= TimeSt){
					swal({
						title: "",
						text: "เวลาสิ้นสุดสิ้นสุดเข้าเรียนไม่ควรน้อยกว่าหรือเท่ากับเวลาเริ่มเข้าเรียน",
					});
					$("#MsTeams_time_end_date").val(null)
				}
			}
			
		}
	})

	$("#MsTeams_time_start_date").on('change', function(){

		if($("#MsTeams_time_end_date").val() != ""){

			var TimeSt = $("#MsTeams_time_start_date").val();
			var TimeEN = $("#MsTeams_time_end_date").val();

			var myDatest = $("#MsTeams_start_date").val();
			var myDatestEn = $("#MsTeams_end_date").val();


			myDatest = myDatest.split("-");
			var newDateSt = new Date( myDatest[0], myDatest[1] - 1, myDatest[2]);

			myDate = myDatestEn.split("-");
			var newDateEn = new Date( myDate[0], myDate[1] - 1, myDate[2]);

			if(newDateEn.getTime() == newDateSt.getTime() || myDatestEn == ""){
				if(TimeEN <= TimeSt){
					swal({
						title: "",
						text: "เวลาสิ้นสุดสิ้นสุดเข้าเรียนไม่ควรน้อยกว่าหรือเท่ากับเวลาเริ่มเข้าเรียน",
					});
					$("#MsTeams_time_end_date").val(null)
				}
			}
			
		}
	})


	// function checkSubmit() {
	// 	<?php if(!$model->isNewRecord){ ?>
	// 		return true;
	// 	<?php } ?>
	// 	if($("#MsTeams_start_date").val() == ""){
	// 		swal({
	// 			title: "ไม่สามารถบันทึกข้อมูลได้",
	// 			text: "กรุณาเลือกวันที่เข้าเรียน",
	// 		});
	// 		return false;
	// 	}else if($("#MsTeams_end_date").val() == ""){
	// 		swal({
	// 			title: "ไม่สามารถบันทึกข้อมูลได้",
	// 			text: "กรุณาเลือกวันที่สิ้นสุดเข้าเรียน",
	// 		});
	// 		return false;
	// 	}else if($("#MsTeams_time_start_date").val() == ""){
	// 		swal({
	// 			title: "ไม่สามารถบันทึกข้อมูลได้",
	// 			text: "กรุณาเลือกเวลาเริ่มเข้าเรียน",
	// 		});
	// 		return false;
	// 	}else if($("#MsTeams_time_end_date").val() == ""){
	// 		swal({
	// 			title: "ไม่สามารถบันทึกข้อมูลได้",
	// 			text: "กรุณาเลือกเวลาสิ้นสุดเข้าเรียนได้",
	// 		});
	// 		return false;
	// 	}

	// 	$.ajax({
	// 		type: "POST",
	// 		url: "<?=$this->createUrl("/MsTeams/CheckTimeZoom");?>",
	// 		data: { 
	// 			start_date:$("#MsTeams_start_date").val(),
	// 			end_date:$("#MsTeams_end_date").val(),
	// 			time_start_date:$("#MsTeams_time_start_date").val(),
	// 			time_end_date:$("#MsTeams_time_end_date").val(),
	// 			hostmail:$("#MsTeams_hostmail").val(),
	// 			 },
	// 		success: function(data){
	// 			var result = JSON.parse(data);
	// 			if(result['status'] == "true"){
	// 				return true;
	// 			}else{
	// 				swal({
	// 					title: "ไม่สามารถเลือกเวลา "+result["date_duplicate"],
	// 					text: "กรุณาเลือกเวลาในการเปิดห้องเรียนใหม่อีกครั้ง",
	// 				});
	// 				return false;
	// 			}
	// 		},
	// 	});
	// }
	<?php 	if($model->isNameSameCode == "y"){ ?>
		$('.name_ms_teams').show();
	<?php } ?>

	$('#MsTeams_isNameSameCode').change(function () {
		if(this.checked){
			$(".name_ms_teams").show();
		}else{
			$(".name_ms_teams").hide();
		}
	});

	<?php 	if($model->price == "y"){ ?>
		$('.course_price_chk').show();
	<?php } ?>
	$('#pricechk').change(function () {
		if(this.checked) {
			
			$('.course_price_chk').show();

		}else{
			$('.course_price_chk').hide();
			$('#MsTeams_ms_price').val(0);
		}

	});


	jQuery.datetimepicker.setLocale('th');
	$.datetimepicker.setLocale('th');
	$('.default_datetimepicker').datetimepicker({
		timepicker: false,
		closeOnDateSelect: true,
		format: 'Y-m-d',
        // yearOffset: 543,
        scrollMonth: false,
        scrollInput: false
    });

	var strdate = "<?= date_format(date_create($model->start_date), "Y-m-d") ?>";
	$('.datestr').val(strdate);

	var dateend = "<?= date_format(date_create($model->end_date), "Y-m-d") ?>";
	$('.dateend').val(dateend);


	$('.default_datetimepicker_time').datetimepicker({
		datepicker:false,
		format:'H:i'
	});
	$('#default_datetimepicker').datetimepicker({step:10});


	$('#MsTeams_course_md_code').on('change', function() {
		$.ajax({
			type: "POST",
			url: "<?=$this->createUrl("/MsTeams/SetNameCode");?>",
			data: { code:this.value },
			success: function(data){
				const obj = JSON.parse(data);
				if(!$('#MsTeams_isNameSameCode').is(":checked")){
					$("#MsTeams_name_ms_teams").val(obj['name_md']);
					$("#MsTeams_ms_teams_number").val(obj['code_md']).trigger('chosen:updated');
				}else{
					$("#MsTeams_ms_teams_number").val(obj['code_md']).trigger('chosen:updated');
				}
				$('#name_code').val(obj['name_md']);
			},
		});

	});

	$('#MsTeams_ms_teams_number').on('change', function() {

		$.ajax({
			type: "POST",
			url: "<?=$this->createUrl("/MsTeams/SetNameCode");?>",
			data: { code:this.value },
			success: function(data){
				const obj = JSON.parse(data);
				if(!$('#MsTeams_isNameSameCode').is(":checked")){
					$("#MsTeams_name_ms_teams").val(obj['name_md']);
					$("#MsTeams_course_md_code").val(obj['code_md']).trigger('chosen:updated');
				}else{
					$("#MsTeams_course_md_code").val(obj['code_md']).trigger('chosen:updated');
				}
				$('#name_code').val(obj['name_md']);
			},
		});

	});

</script>  

<script>
	$(function () {
		init_tinymce();
	});
</script>