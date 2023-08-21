    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style type="text/css">
	p{
		display: inline;
	}
</style>
<style type="text/css">
	.exams p{
		display: inline !important;
		margin-top: -3px !important;
	}
	.exams label{
		margin-bottom: 15px !important;
	}
	.exams label:after{
		top: 3px !important;
	}
	.radio label:after{
		top: 5px !important;
	}
	.exams label:before{ 
		margin-top: -4px !important;
	}
	.li-cute{
		border: solid 1px black; 
		background: white; 
		padding-top: 10px; 
		padding-bottom: 10px; 
		margin-bottom: 10px; 
		padding-left: 10px; 
		padding-right: 10px;
	}
</style>
<!-- Header page -->
<div id="exam-result">

	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb breadcrumb-main">
				<li class="breadcrumb-item"><a href="<?php echo $this->createUrl('course/detail/', array('id' => $course->course_id,'gen'=>$gen)); ?>"><?php echo $labelCourse->label_course; ?></a>
					<li class="breadcrumb-item active" aria-current="page"><?= $course->course_title; ?></li>
				</ol>
			</nav>
		</div> 
		<section class="content" id="exams">
			<div class="container">
				<!-- tabtime -->
				<div class="alert alert-danger stick center shadow">
					<h4 class="mb-0 text-center"><?= empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ? "Time allowed :" : "เวลาที่กำหนด :" ?> <span id="tabtime">00:00:00</span></h4>
				</div>
				<!-- Content -->

				<div class="well">
					<div class="exams">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div id="ques-show">
									<div class="col-sm-8">
										<form id="question-form" action="#" method="POST" role="form" onSubmit="return false">
											<div class="form-group">
												<?php
												$strTotal = 0;
												$questionTypeArray = array(1 => 'checkbox', 2 => 'radio', 3 => 'textarea', 4 => 'dropdown', 6 => 'hidden');
												$questionTypeArrayStr = array(1 => 'เลือกได้หลายคำตอบ', 2 => 'เลือกได้คำตอบเดียว', 3 => 'คำตอบแบบบรรยาย', 4 => 'คำตอบแบบจับคู่', 6 => 'คำตอบแบบจัดเรียง');									
												?>
												<h4>ข้อสอบแบบ <?= $questionTypeArrayStr[$model->ques_type]?> </h4>
												<p><?= $currentQuiz->number; ?>. <?= $model->ques_title; ?></p>
												<div class="well answer" style="margin-top: 10px;">
													<?php 
													$ansData = json_decode($currentQuiz->ans_id);
													$choiceData = json_decode($currentQuiz->question);
													$arrType4Answer = array();

													if($model->ques_type == 6 ){ 
														?>
														<ul id='sortable' style='cursor: pointer;'>
															<?php
															if( !empty( json_decode($currentQuiz->ans_id) ) ) {
																$choiceData = json_decode($currentQuiz->ans_id);
															}
														}


														if($model->ques_type == 3) {
															echo '										
															<textarea class="examsta" rows="4" cols="50" name="lecture" >'.$currentQuiz->ans_id.'</textarea>
															';

														}else{
											$countchoice = 1; // นับตัวเลือกข้อสอบแบบจับคู่
											foreach ($choiceData as $key => $val_choice) {
												$choice = Coursechoice::model()->findByPk($val_choice);
												$checked = '';
												if(in_array($choice->choice_id, $ansData)){
													$checked = 'checked';
												}
												if($model->ques_type == 1){
													echo '<div class="checkbox checkbox-info checkbox-circle">
													<input id="checkbox-'.$choice->choice_id.'" type="checkbox" '.$checked.' value="'.$choice->choice_id.'" name="Choice['.$model->ques_id.'][]">
													<label for="checkbox-'.$choice->choice_id.'">
													'.CHtml::decode($choice->choice_detail).'
													</label>
													</div>';
												}else if ($model->ques_type == 6) {
													?>

													<li class="li-cute" id='<?php echo $choice->choice_id; ?>'><?php echo CHtml::decode($choice->choice_detail); ?>
														
													</li>

													<?php



												} else if($model->ques_type == 2) {
													if(in_array($choice->choice_id, $ansData)){
														$checked = 'checked';
													}
													echo '
													<div class="radio radio-info radio-circle">
													<input id="radio-'.$choice->choice_id.'" 
													type="radio"'.$checked.' value='.$choice->choice_id.' name="Choice['.$model->ques_id.'][]">
													<label for="radio-'.$choice->choice_id.'">
													'.CHtml::decode($choice->choice_detail).'
													</label>
													</div>';
												} else if($model->ques_type == 4) {
												// $ranNumber = rand(1, 10000000);
													if($choice->choice_answer == 2){
														$thaichar = array('ก','ข','ค','ง','จ','ฉ','ช','ซ','ฌ','ญ','ฐ','ฑ','ฒ','ณ','ด','ต','ถ','ท','ธ','น','บ','ป','ผ','ฝ','พ','ฟ','ภ','ม','ย','ร','ล','ว','ศ','ษ','ส','ห','ฬ','อ','ฮ');  
														$Type4Answer[$choice->choice_id] = $thaichar[$countchoice-1];
														$countchoice++;		
													// $arrType4Answer[$ranNumber] = $val_choice;
													}
													if($choice->choice_answer == 1){
														$Type4Question[$val_choice] = $key;
													}
												}
											}
										}

											if($model->ques_type == 4) {
												echo '<label> ส่วนที่ 1 </label> <br>';
											}


											foreach ($Type4Answer as $key => $val_1) {

												$choice = Coursechoice::model()->findByPk($key);
												echo 	'<div style="display:inline">'.$val_1.'. '.CHtml::decode($choice->choice_detail).'</div>';
												echo 	'<br>';
											}
											echo '<br>';

											if($model->ques_type == 4) {
												echo '<label> ส่วนที่ 2 </label> <br>';
											}

											$ansDatas = array_flip($ansData);
											$countQuest = 0;

											foreach ($Type4Question as $key => $val_2) {
												$selected = '';
												if(in_array($countQuest, $ansDatas)){
													$selected = $ansData[$countQuest];
												}	

												$choice = Coursechoice::model()->findByPk($key);
												echo 	CHtml::dropDownList('dropdownVal[]',
													$selected_value=$selected,
													$Type4Answer,
													array('empty'=>'เลือก','class'=>'dropdown_value','id'=>'Q'.$key)).' <label>
												'.CHtml::decode($choice->choice_detail).'
												</label>';
												echo '<br>';
												$countQuest++;
											}

											?>
											<?php if($model->ques_type == 6 ){ echo "</ul>"; } ?>
										</div>
									</div>
									<!-- <button type="submit" class="btn btn-warning center-block">ส่งคำตอบ</button> -->
									<?php if($model->ques_type == 6 ){ 
										?>
										<input type="hidden" id="answer_sort" name="answer_sort" value="<?php echo implode(",", $choiceData); ?>">
										<?php
									} ?>
									<?php 
									echo CHtml::hiddenField("Question_type[" . $model->ques_id . "]", $questionTypeArray[$model->ques_type]);
									echo CHtml::hiddenField("last_ques");
									echo CHtml::hiddenField("actionEvnt");
									echo CHtml::hiddenField("course_id",$course->course_id);
									echo CHtml::hiddenField("idx_now",$currentQuiz->number);
									?>
									<div class="text-center">
										<?php 
										if(empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ){
											$Previous = "Previous";
											$Next = "Next";
										}else{  
											$Previous = "ก่อน";
											$Next = "ถัดไป";
										}
										?>
										<?php echo CHtml::tag('button', array('class' => 'submit btn btn-info btn-lg','onclick'=>'save_ans("previous")'), $Previous); ?>
										<?php echo CHtml::tag('button', array('class' => 'submit btn btn-info btn-lg','onclick'=>'save_ans("next")'), $Next); ?>
										<!-- <?php //if($last_ques==1)echo CHtml::tag('button', array('class' => 'submit btn btn-success btn-lg','onclick'=>'save_ans("save")'), 'ส่งคำตอบ'); ?> -->
									</div>
								</form>
							</div>
							<div class="col-sm-4">
								<div class="all-exams">
									<div class="exams-title">
									<?= empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ? 'Question' : 'คำถาม' ?> <span class="pull-right"><?= $countExam .' / '. count($temp_all);?></span>
									</div>
									<table class="table table-bordered table-striped">
										<tbody>
											<tr >
												<?php 
												$loop = 0;
												foreach ($temp_all as $key => $val_temp) { 
													$loop++;
													if($model->ques_id == $val_temp->ques_id){
														$class = 'btn-info';
													} else {
														$class = ($val_temp->status == '1') ? 'btn-success' : '';
													} 
													$link = 'onclick="save_ans(\''.$val_temp->number.'\')"';
													?>
													<td><a href="javascript:void(0)" <?= $link; ?> class="btn <?= $class ?> btn-block"><div style="height:100%;width:100%"><?= $val_temp->number; ?></div></a></td>
													<?php
													if ($loop == 10) {
														$loop = 0;
														echo '</tr><tr style="background-color: #f9f9f9">';
													}
												} 
												?>
											</tr>
										</tbody>
									</table>
									<center style="margin-top: 80px">
										<?php if ($last_ques == 1) echo CHtml::tag('button', array('class' => 'submit btn btn-success btn-lg', 'onclick' => 'save_ans("save")'), UserModule::t('sendQues')); ?>
									</center>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</div>
 <video width=250 height=250 id="videoCap" hidden controls autoplay></video>
 <input type="text" accept="image/png" name="current_imageCap" id="current_imageCap" hidden>
 <input type="text" placeholder="Student ID" name="useridCap" id="useridCap" hidden  value="<?=Yii::app()->user->getId(); ?>">

 <canvas id="myCanvasCap" width="400" height="350" hidden></canvas>
<?php 
 $Setting = Setting::model()->find();
 ?>


<script>

	var interval;

	var intervalPop, intervalCap , chkbacklogout , logoutface;
	var uid = document.getElementById('useridCap').value;

	$(function() {

		var chk_set = "<?= $Setting->settings_confirmface ?>";

		if(chk_set == 1){
			if(uid){
			 intervalPop = setInterval(function () { getPopup(); }, (1 * 1000) + 1000);
			}
		}

		$('#sortable').sortable({
        start: function(event, ui) {
            var start_pos = ui.item.index();
            ui.item.data('start_pos', start_pos);
        },
        change: function(event, ui) {
            var start_pos = ui.item.data('start_pos');
            var index = ui.placeholder.index();        
        },
        update: function(event, ui) {
			var start_pos = ui.item.data('start_pos');
            var index = ui.placeholder.index();
            get_li();
        }
    });

		time_test_start('<?= $time_up; ?>');

		$(".dropdown_value").each(function () {
			var $self = $(this);
			$self.data("previous_value", $self.val());
		});

		$(".dropdown_value").on("change", function () {
	    	// alert('test');

	    	var $self = $(this);
	    	var prev_value = $self.data("previous_value");
	    	var cur_value = $self.val();

	    	$(".dropdown_value").not($self).find("option").filter(function () {
	    		return $(this).val() == prev_value;
	    	}).prop("disabled", false);

	    	if (cur_value != "") {
	    		$(".dropdown_value").not($self).find("option").filter(function () {
	    			return $(this).val() == cur_value;
	    		}).prop("disabled", true);

	    		$self.data("previous_value", cur_value);
	    	}
	    });

	});

	var arr_li_answer = Array();
	function get_li(){
		arr_li_answer = [];
		$(".li-cute").each(function( index ) {
			arr_li_answer.push($( this ).attr("id"));
		});

		$("#answer_sort").val(arr_li_answer.join())
		// console.log(arr_li_answer.join());
	}

	function save_ans(evnt) {
		$("#actionEvnt").val(evnt);
		if(evnt=='save' || evnt=='timeup'){
			$('#last_ques').val(1);
		}
		if($('#last_ques').val() == 1){
			$(".submit").button('loading');
			$(".submit").attr('disabled','disabled');
		} 
		$.ajax({
			url: "<?php echo Yii::app()->createUrl('coursequestion/index', array('gen' =>$_GET['gen'], 'type'=>$_GET['type'])); ?>",
			type: "POST",
			data: $("#question-form").serialize(),
			success: function (data) {
				if ($('#last_ques').val() == 1) {
					var url = '<?php echo Yii::app()->createUrl('coursequestion/exams_finish', array('id' => $course->course_id,'gen' =>$_GET['gen'], 'type'=>$_GET['type'])); ?>';
					if(evnt=='save'){
						// var strMsg = 'คุณทำข้อสอบสำเร็จ';
						var strMsg = '<?= UserModule::t('success_test'); ?>';
						var typeMsg = 'success';
					} else {
						var strMsg = '<?= UserModule::t('fail_test'); ?>';
						var typeMsg = 'warning';
					}
					swal({
						title: "<?= UserModule::t('success_test'); ?>",
						text: strMsg,
						type: typeMsg,
						confirmButtonText: "OK",
					},
					function () {
						$('#exam-result').html(data);//window.location.href = url;
					});
				} else {
					$('#ques-show').html(data);
				}
			},
			complete: function(){
				$(".submit").button('reset');
			}
		});
	}

	function time_test_start(time_down){
		var count = time_down;
		var hours = 0;
		var minutes = 0;
		var seconds = 0;
		var timeStr = '';
		clearInterval(interval);
		interval = setInterval(function() {
			count--;
			var hours   = Math.floor(count / 3600);
			var minutes = Math.floor((count - (hours * 3600)) / 60);
			var seconds = count - (hours * 3600) - (minutes * 60);

			if (hours   < 10) {hours   = "0"+hours;}
			if (minutes < 10) {minutes = "0"+minutes;}
			if (seconds < 10) {seconds = "0"+seconds;}
			timeStr = hours+':'+minutes+':'+seconds;
			if(seconds==0){
				$.ajax({
					url: "<?php echo Yii::app()->createUrl("coursequestion/SaveTimeExam")."?type=".$_GET['type']; ?>",
					type: "POST",
					data: {course_id:<?= $course->course_id ?>,time:count},
					success:function(data){
						console.log(data);
					}
				});
			} 

			$("#tabtime").html(timeStr);
			if (count <= 0) {
				clearInterval(interval);
				save_ans('timeup');
			}
		}, 1000);
	}


	var course_id = "<?=$course->course_id?>";
	var Test_type = "Course";
	var lesson_id = 0;

	var vid = document.querySelector('video[id="videoCap"]');
		vid.onplay = function () {
			ctxCap.drawImage(this, 0, 0, mcanvas.width, mcanvas.height);
			var dataURL = mcanvas.toDataURL('image/png');
			document.getElementById("current_imageCap").value = dataURL;
			webcamStreamCap.getTracks().forEach(function (track) {
				track.stop();
			});

			ajax_db2();
			setTimeout(function () { ajax_post2(dataURL); }, 100);
		};

		function ajax_db2()
		{

			var times = $("#tabtime").html();
			var data = {
				'action':'save_db',
				'lesson_id': lesson_id,
				'course_id': course_id,
				'ques_type': Test_type,
				'time': times
			};
			$.ajax({
				url:"<?php echo Yii::app()->createUrl('question/webcam');?>",
				data: data,
                type:"POST", 
                success:function(response){
                },
	                error:function(err){
	                console.log(err.responseText);
	                }
                });
		}

		/* ajax to php and save the pic */
		function ajax_post2(base64)
		{
			$.ajax({
				url:"<?php echo Yii::app()->createUrl('question/webcam');?>",
				data: {'action':'save_pic','base64':base64},
                type:"POST",//you can also use GET method
                success:function(response){


                	var data = {
                		'lesson': lesson_id,
                		'cou': course_id,
                		'ques_type': Test_type,
                		'type_cou': 1,
                	};

                	$.ajax({
                		url:"<?php echo Yii::app()->createUrl('questionmsteams/FaceDetect');?>",
                		data: data,
                		type:"POST", 
                		success:function(response){

							response = "pass";
                			if(response == "pass"){
                				intervalPop = setInterval(function () { getPopup(); }, ((2 * 60) * 1000) + 1000);
                			}else{

                				Swal.fire({
                					title: "ใบหน้าของคุณไม่ตรงกัน",
                					text: "(ระบบจะทำการ Logout)",
                					icon: 'warning',
                					showCancelButton: false,
                					confirmButtonColor: '#3085d6',
                					cancelButtonColor: '#d33',
                					confirmButtonText: 'ตกลง',
                					cancelButtonText: 'ไม่ยินยอม',
                					allowOutsideClick: false,

                				}).then((result) => {
                					setInterval(function () {window.location.href = "<?=  $this->createUrl('login/logout'); ?>"; }, (3 * 1000) + 1000);
                					if (result.value) {
                						window.location.href = "<?=  $this->createUrl('login/logout'); ?>";
                					} else {
                						window.location.href = "<?=  $this->createUrl('login/logout'); ?>";
                					}
                				})

                			}

                		},
                		error:function(err){
                			console.log(err.responseText);
                		}
                	});
                                           
                },
                    error:function(err){
                    console.log(err.responseText);
                    }
                });
		}

	

		navigator.getUserMedia = (navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);

    mcanvas = document.getElementById("myCanvasCap");
    ctxCap = mcanvas.getContext('2d');

    var videoCap;
    var webcamStreamCap;
    function startWebcam() {
        if (navigator.getUserMedia) {
            navigator.getUserMedia(
                {
                    video: true,
                    audio: false
                },
                function (localMediaStream) {
                    videoCap = document.querySelector('video[id="videoCap"]');
                    videoCap.srcObject = localMediaStream;
                    webcamStreamCap = localMediaStream;
                },
                function (err) {
                    console.log("The following error occured: " + err);
                }
            );
        } else {
            console.log("getUserMedia not supported");
        }
    }

    function stopWebcam() {
        webcamStreamCap.stop();
    }

    var canvasCap, ctxCap;

    function init() {
        mcanvas = document.getElementById("myCanvasCap");
        ctxCap = mcanvas.getContext('2d');
    }

    function playVid() {
        startWebcam();
    }

    function getPopup() {
        var text = "ยืนยันใบหน้า";
        clearInterval(intervalPop);
        ConfirmDialog(text);
    }

    function ConfirmDialog(message) {

        var localMediaStream = null;
        var chklogout = setInterval(function () { alert('asdsad') }, 30 * 60 * 1000);
        Swal.fire({
            title: message,
            icon: 'warning',
            showCancelButton: true,

            html: '<div class="face-scan learn-scan"><div class="face-check"></div><video style="width:50;" class="video-js" height="50" id="video-cam" controls autoplay playsinline muted></video></div>',

            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยินยอม',
            cancelButtonText: 'ไม่ยินยอม',
            allowOutsideClick: false,
        }).then((result) => {
            if (result.value) {
                playVid();
                clearInterval(chklogout);
                localMediaStream.getTracks().forEach(function (track) {
                    track.stop();
                });

            } else {

                swal.close();
            }
        })
     

        let videocam = document.getElementById("video-cam");
        let canvas = document.getElementById("myCanvasCap");
        let ctx = canvas.getContext('2d');

        var constraints = {
            video: true,
            video: {
                width: { max: 960 },
                height: { max: 720 }
            },
            audio: false
        };
        navigator.mediaDevices.getUserMedia(constraints)

            .then(function (stream) {
                videocam.play();
                cameraStarted = true;
                videocam.srcObject = stream;
                localMediaStream = stream;
            })
            .catch(function (error) {

            });
        function removeControls(videocam) {
            videocam.removeAttribute('controls');
        }
        window.onload = removeControls(videocam);
    };




</script>
