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

				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>


				<div class="row">
					<div class="col-md-12">
						<?php echo $form->labelEx($model,'name_ms_teams'); ?>
						<?php echo $form->textField($model,'name_ms_teams',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'name_ms_teams'); ?>
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
			<label><h4>รายละเอียดห้องเรียนรู้ทางไกล</h4></label>
			<textarea name="MsTeams[detail_ms_teams]" class="survey-header-detail tinymce" id="MsTeams_detail_ms_teams" cols="30" rows="10"><?php echo ($model->detail_ms_teams); ?></textarea>
		</div>

	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<?php echo $form->labelEx($model,'start_date'); ?>
			<?php echo $form->textField($model,'start_date',array('class' => 'default_datetimepicker datestr','autocomplete'=>'off')); ?>
			<?php echo $this->NotEmpty();?>
			<?php echo $form->error($model,'start_date'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?php echo $form->labelEx($model,'time_start_date'); ?>
			<?php echo $form->textField($model,'time_start_date',array('class' => 'default_datetimepicker_time','autocomplete'=>'off')); ?>
			<?php echo $this->NotEmpty();?>
			<?php echo $form->error($model,'time_start_date'); ?>
			<div class="error help-block">
			<div class="label label-important" id="err_msonline_time_start" style="display:none">
					เวลาเริ่มต้นต้องน้อยกว่าเวลาสิ้นสุด
			</div>
		</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?php echo $form->labelEx($model,'end_date'); ?>
			<?php echo $form->textField($model,'end_date',array('class' => 'default_datetimepicker dateend','autocomplete'=>'off')); ?>
			<?php echo $this->NotEmpty();?>
			<?php echo $form->error($model,'end_date'); ?>
		</div>
	</div> 

	<div class="row">
		<div class="col-md-12">
			<?php echo $form->labelEx($model,'time_end_date'); ?>
			<?php echo $form->textField($model,'time_end_date',array('class' => 'default_datetimepicker_time','autocomplete'=>'off')); ?>
			<?php echo $this->NotEmpty();?>
			<?php echo $form->error($model,'time_end_date'); ?>
			<div class="error help-block">
			<div class="label label-important" id="err_msonline_time_end" style="display:none">
				เวลาสิ้นสุดต้องมากว่าเวลาเริ่มต้น
			</div>
		</div>
		</div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->checkBox($model,'price',array(
			'data-toggle'=> 'toggle','id'=>"pricechk",'value'=>"y", 'uncheckValue'=>"n"
		)); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row course_price_chk" style="display: none;">
		<?php echo $form->labelEx($model,'ms_price'); ?>
		<?php echo $form->numberField($model,'ms_price',array('min'=>"0",'maxlength'=>255,'class'=>'span8','oninput'=>"this.value = Math.abs(this.value)")); ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'ms_price'); ?>
	</div> 


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
	// $('.default_datetimepicker').datetimepicker({
	// 	timepicker: false,
	// 	closeOnDateSelect: true,
	// 	format: 'Y-m-d',
    //     // yearOffset: 543,
    //     scrollMonth: false,
    //     scrollInput: false
    // });

	var strdate = "<?= date_format(date_create($model->start_date), "Y-m-d") ?>";
	$('.datestr').val(strdate);

	var dateend = "<?= date_format(date_create($model->end_date), "Y-m-d") ?>";
	$('.dateend').val(dateend);


	// $('.default_datetimepicker_time').datetimepicker({
	// 	datepicker:false,
	// 	format:'H:i'
	// });
	$('#default_datetimepicker').datetimepicker({step:10});

	var startDate = $("input[name='MsOnline[start_date]']");
	var endDate = $("input[name='MsOnline[end_date]']");
	startDate.datetimepicker({
		timepicker: false,
		closeOnDateSelect: true,
		format: 'Y-m-d',
        scrollMonth: false,
        scrollInput: false,
		onShow:function( ct ) {
			if(endDate.val() != ""){
				console.log($("input[name='MsOnline[time_start_date]']").val());
				var setMaxDate= new Date(endDate.val()).toLocaleDateString('en-ZA');
				this.setOptions({
					maxDate: setMaxDate
							? setMaxDate
							: false
				})
			}
		}
	});


	endDate.datetimepicker({
		timepicker: false,
		closeOnDateSelect: true,
		format: 'Y-m-d',
        scrollMonth: false,
        scrollInput: false,
		onShow:function( ct ) {
			if(startDate.val() != ""){
				var setMinDate = new Date(startDate.val()).toLocaleDateString('en-ZA');
				this.setOptions({
					minDate: setMinDate
							? setMinDate
							: false
				})
			}
		}
	});

	var startTime = $("input[name='MsOnline[time_start_date]']");
	var endTime = $("input[name='MsOnline[time_end_date]']");
	startTime.datetimepicker({
		format:'H:i',
		datepicker:false,
		onChangeDateTime:function( ct ) {
			if(endTime.val() != "" && endDate.val() != ""){
				var setDateStart = new Date(startDate.val());
				var setDateEnd = new Date(endDate.val());

				setDateStart = setDateStart.toLocaleDateString('en-ZA');
				setDateEnd = setDateEnd.toLocaleDateString('en-ZA');

				var setTimeStart = new Date(ct);
					setHourStart = setTimeStart.getHours();
					setMinuteStart = setTimeStart.getMinutes();

				var setTimeEnd = endTime.val().split(":");
					setHourEnd = setTimeEnd[0];
					setMinuteEnd = setTimeEnd[1];

				if(setDateStart == setDateEnd && ((setHourStart > setHourEnd ) || (setHourStart == setHourEnd && setMinuteStart >= setMinuteEnd)) ){
					$('#err_msonline_time_start').css('display','');
					startTime.val("");
				}else{
					$('#err_msonline_time_start').css('display','none');
				}
			}
		}
	});

	endTime.datetimepicker({
		format:'H:i',
		datepicker:false,
		onChangeDateTime:function( ct ) {
			if(startTime.val() != "" && startDate.val() != ""){
				var setDateStart = new Date(startDate.val());
				var setDateEnd = new Date(endDate.val());

				setDateStart = setDateStart.toLocaleDateString('en-ZA');
				setDateEnd = setDateEnd.toLocaleDateString('en-ZA');

		

				var setTimeStart = startTime.val().split(":");
					setHourStart = setTimeStart[0];
					setMinuteStart = setTimeStart[1];

				var setTimeEnd = new Date(ct);
					setHourEnd = setTimeEnd.getHours();
					setMinuteEnd = setTimeEnd.getMinutes();

				if(setDateStart == setDateEnd && ((setHourStart > setHourEnd ) || (setHourStart == setHourEnd && setMinuteStart >= setMinuteEnd)) ){
					$('#err_msonline_time_end').css('display','');
					endTime.val("");
				}else{
					$('#err_msonline_time_end').css('display','none');
				}
			}
		}
	});
</script>  

<script>
	$(function () {
		init_tinymce();
	});
</script>