ิ<?php 
$timeTest = Helpers::lib()->getTimeTest($lesson->time_test,$temp_all[0]->time_up);
$percent = $modelScore->score_number > 0 ? number_format(($modelScore->score_number * 100) / $modelScore->score_total,2) : 0;
if($modelScore->score_past == 'y'){
	$class = 'fa fa-check-circle';
	$classH1 = 'text-success';
	// $strMsg = 'ผ่าน';
	$strMsg = $labelCourse->label_passTest;
	$linkPass = Yii::app()->createUrl('course/detail/', array('id' => $lesson->CourseOnlines->course_id));
	$link = '#modal-pass';
} else {
	$class = 'fa fa-times-circle';
	$classH1 = 'text-danger';
	// $strMsg = 'ไม่ผ่าน';
	$strMsg = $labelCourse->label_notPassTest;
	$link = '#modal-alert';
}

$flagSussces = true; //false หมดสิทธิ์, true ยังทำได้อยู่
// $state = Helpers::lib()->CheckPostTest($lesson->course_id,Yii::app()->user->id);
$state = Helpers::lib()->CheckPostTestAll($lesson,$gen);

	$criteria=new CDbCriteria;
	$criteria->compare('user_id',Yii::app()->user->id);
	$criteria->compare('course_id',$lesson->CourseOnlines->course_id);
	$criteria->compare('active',"y");
	$criteria->compare('type',"post");
	$postTestAll = Score::model()->findAll($criteria);
	$countPostTest = count($postTestAll);
?>


<script>
	var quesType_ = "<?= $quesType_ ?>";
	var amount = <?= $lesson->cate_amount?>;
	var postTestCount = <?= $countPostTest ?>;
	$(function(){
		if("<?= $testType?>" != "pre" && amount >= postTestCount && quesType_ != 3 && "<?= $course->hidden_score ?>" != "y"){
			$('<?= $link ?>').modal('show');
		}
	});
</script>
<style type="text/css">
	.text-success {
		color: #22c020 !important; 
	}
	.bg-success{
		background-color: #5cb85c;
		color:#fff;
	}
</style>
<!-- <div class="header-page parallax-window" data-parallax="scroll" data-image-src="<?php echo Yii::app()->theme->baseUrl; ?>/images/bg-header-page.png"> -->
	<div class="container">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb breadcrumb-main">
				<li class="breadcrumb-item"><a href="<?php echo $this->createUrl('course/detail/', array('id' => $course->course_id,'gen'=>$gen)); ?>"><?php echo $labelCourse->label_course; ?></a>
					<li class="breadcrumb-item active" aria-current="page"><?= $lesson->CourseOnlines->course_title; ?></li>
				</ol>
			</nav>
		</div> 
<!-- <div class="bottom1"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/kind-bottom.png" class="img-responsive" alt=""></div>
</div> --> 

<!-- Content -->
<section class="content" id="exams-finish">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-xs-12">
				<div class="well bg-greendark">
					<?php
					if($testType != "pre" && $quesType_ != 3 && $course->hidden_score != "y"){ ?>
					<div class="well text-center result">
						<h1 class="<?= $classH1; ?>"><span><i class="<?= $class; ?>" aria-hidden="true"></i></span><?= $strMsg; ?></h1>
					</div>
				<?php } ?>

					<div class="well detail">
						<ul class="list-unstyled">
							<li><?= $labelCourse->label_totalTest ?> <span class="pull-right"><?= count($temp_all) ?> <?= $labelCourse->label_list ?></span></li>
							<li><?=UserModule::t('timeTest');?> <span class="pull-right"><?= $lesson->time_test; ?> <?= empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ? UserModule::t('Minutes') : 'นาที'?></span></li>

							<li><?=UserModule::t('timeToUse');?> <span class="pull-right"><?= $timeTest ?> <?= empty(Yii::app()->session['lang']) || Yii::app()->session['lang'] == 1 ? UserModule::t('Minutes') : 'นาที' ?></span></li>
							<li><?=UserModule::t('totoal');?> <span class="pull-right"><?= $modelScore->score_total; ?> <?= $labelCourse->label_point; ?></span></li>
							<li><?= $labelCourse->label_haveCorrect; ?> 
							<span class="pull-right">
								<?= $course->hidden_score == "y" ? 'รอตรวจคำตอบ' : $modelScore->score_number." ".$labelCourse->label_point; ?>
							</span></li>
							<li><?= $labelCourse->label_percentage ?> 
								<span class="pull-right">
								<?= $course->hidden_score == "y" ? 'รอตรวจคำตอบ' : $percent." %"; ?>
								</span>
							</li>
						</ul>
					</div>
				</div>

				<div class="text-center  mt-1">
					<!-- <a href="<?= $linkNextStep; ?>" type="button" class="btn btn-warning btn-lg"><?=UserModule::t('complete_btn');?></a> -->
					<a href="javascript:void(0)" class="btn btn-warning btn-lg" type="button" onclick="nextStep();"><?= UserModule::t('complete_btn'); ?></a>
				</div>
			</div>
			<?php if($testType != "pre" && ($quesType_ != 4 && $quesType_ != 6 && $quesType_ != 3 && $course->hidden_score != "y")){ ?>
			<div class="col-sm-4">
				<aside>
					<h4 class="title text-success"><span class="pull-right"><?= $modelScore->score_number; ?></span><?=UserModule::t('scoreAll');?></h4>
					<ul class="list-unstyled">
						<?php 
						$logQues = Logques::model()->findAll(array(
							'condition' => 'score_id=:score_id AND user_id=:user_id AND test_type=:type',
							'params' => array(':score_id' => $modelScore->score_id,':user_id'=> Yii::app()->user->id,':type'=> $testType)));
						foreach ($logQues as $key => $value) {
							if($value->result >= 1){
								$class = 'fa fa-circle text-success';
								$score = $value->result;
							} else {
								$class = 'fa fa-circle text-danger';
								$score = '0';
							}
							echo '
							<li><spna class="pull-right">'.$score.'</spna><i class="'.$class.'" aria-hidden="true"></i>'.UserModule::t('list_question').' '.($key+1).'</li>
							';
						}
						?>
					</ul>
				</aside>
			</div>
		<?php } ?>
		</div>
	</div>
</section>
<div class="container">
	<?php if($lesson->status == 'y' && $testType != "pre" && $quesType_ != 3){ ?>	
		<div class="question-content-wrap">
			<div class="row">
				<div class="col-md-8">

					<table class="table-question table table-bordered">
						<thead>
							<tr class="bg-success">
								<th style="text-align: center">ข้อ</th>
								<th style="text-align: left">รายละเอียด</th>
								<th style="text-align: center">สถานะ</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							foreach($temp_all as $index => $val):
								$Logchoice = logchoice::model()->findAll(" score_id=:s AND lesson_id=:q AND logchoice_answer = 1  AND user_id=:user_id AND ques_id=:ques_id", array(
									"s" => $modelScore->score_id,
									"q" => $lesson->id,
									':user_id'=> Yii::app()->user->id,
									':ques_id' => $val->ques_id
								));
								$choiceData = 0;
								$ansStr = '';
								$arrayCount = count($Logchoice);
								$choiceState = true;
								if(!$Logchoice) $ansStr .= '-';
								foreach ($Logchoice as $key => $valChoice): 
									$ansStr .= CHtml::decode($valChoice->choices->choice_detail);
									if(($arrayCount-1) != $ker)$ansStr .= ',';
									if($valChoice->is_valid_choice == 1){
										$choiceData ++;
									} else {
										$choiceState = false;
									} 
								endforeach;
								$logScore = Choice::model()->findAll(array(
									'condition'=>"ques_id=:ques_id and choice_answer='1'",
									'params' => array(':ques_id' => $val->ques_id)
								));
								$arrayCount = count($logScore);

								if($Logchoice){
									if(($choiceData == $arrayCount) && $choiceState){
										$icon_score = '<i class="fa fa-check text-success"></i>';
									}else{
										$icon_score = '<i class="fa fa-times text-danger"></i>';
									}
								} else {
									$icon_score = '<i class="icon icon-err md-close-2"></i>';
								}
								$question = Question::model()->find(array(
									'condition' => 'ques_id = '.$val->ques_id
								));
								?>
								<tr>
									<td><?= ($index+1); ?></td>
									<td class="td-quest" style="text-align: left">
										<b>คำภาม</b> : <?= $question->ques_title; ?><br>
										<b>คำตอบ</b> : <?= $ansStr; ?>      

										<br><b>เฉลย</b> : <?php 
										foreach ($logScore as $key => $log) {
											echo CHtml::decode($log->choice_detail);
											if(($arrayCount-1) != $key)echo ',';
										}; ?>
										<?php if($question->ques_explain){ ?><br><b>คำอภิปราย</b> : <?= $question->ques_explain; ?>    
											<?php 
										}
										?>
									</td>
									<td><?= $icon_score; ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	<?php } ?>

	<div class="modal fade" id="modal-alert">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><?= $labelCourse->label_swal_warning; ?></h4>
				</div>
				<div class="modal-body">
					<center>
						<i class="fa fa-exclamation-triangle" style="font-size:6em; color: #F8BB86; padding-top: 15px;padding-bottom: 15px;"></i>
						<h2 style="color: #575757;"><?= $labelCourse->label_notPassTest; ?></h2>
						<?php if($modelScore->type=='post'){ 
							if($state){
								?>
								<p><?=UserModule::t('reTest');?></p>
							<?php }else{
								?>
								<p><?=UserModule::t('reTestFail');?></p>
								<?php
							}
						} ?>
					</center>
				</div>
				<div class="modal-footer">
					<center>
						<button type="button" class="btn btn-success"  style="padding: 15px 32px; height: auto" data-dismiss="modal">OK</button>
					</center>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-pass">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><?= $labelCourse->label_swal_warning; ?></h4>
				</div>
				<div class="modal-body">
					<center>
						<i class="fa fa-check" style="font-size:6em; color: #4cdb20; padding-top: 15px;padding-bottom: 15px;"></i>
						<h2 style="color: #575757;"><?= $labelCourse->label_passTest; ?></h2>
					</center>
				</div>
				<div class="modal-footer">
					<center>
						<button type="button" class="btn btn-success"  style="padding: 15px 32px; height: auto" data-dismiss="modal">OK</button>
					</center>
				</div>

			</div>
		</div>
	</div>

	<?php 
	
	// if($modelScore->type=='post' && !$state){
	// 	Helpers::lib()->resetScore($lesson->id);
	// 	$linkNextStep = Yii::app()->createUrl('question/Resetpost/', array('id' => $lesson->id,'course'=>$lesson->course_id));
	// }else{
	// 	$linkNextStep = Yii::app()->createUrl('course/detail/', array('id' => $lesson->CourseOnlines->course_id));
	// } 
	?>
	<script type="text/javascript">
		clearInterval(intervalPop);
	function nextStep(){
		Swal.fire({
			title: 'ต้องการขั้นตอนถัดไปหรือไม่',
			text: '',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'ยืนยัน',
			cancelButtonText: 'ยกเลิก',
		}).then((result) => {
			if (result.value) {
				link = <?= Helpers::nextStepTestLesson($course->course_id,$gen,$testType) ?>;
				window.location.href = link;
			}else{
				window.location.href = "<?= $this->createUrl('course/detail/', array('id' => $course->course_id,'gen'=>$gen)) ?>"
			}
		})
	}
	</script>