<!-- innerLR -->

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
				<?php $form = $this->beginWidget('AActiveForm', array(
					'id'=>'news-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true
					),
					'errorMessageCssClass' => 'label label-important',
					'htmlOptions' => array('enctype' => 'multipart/form-data')
					)); ?>
				<?php  
				$lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
				$modelLang = Language::model()->findByPk($lang_id);
			$attSearch = array("class"=>"span8",'disable_search' => false);
			$selected = $model->capRelation->cnid;
				?>
				<?php if ($lang_id != 1){ ?>
				<p class="note"><span style="color:red;font-size: 20px;">เพิ่มเนื้อหาของภาษา <?= $modelLang->language; ?></span></p>
				<?php } ?>

				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
				<div class="row">
					<div class="col-md-12">
						<?php echo $form->labelEx($model,'capt_name'); ?>
						<?php echo $form->textField($model,'capt_name',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'capt_name'); ?>
					</div>
				</div>
				<?php 
				$courseAll = CHtml::listData(CourseOnline::model()->findAllByattributes(array('active' => 'y','lang_id' => 1)), 'course_id', 'course_title');
				$type = array('1' => 'VDO','2' => 'PDF');
				if(!empty($model->type)){
					$select = json_decode($model->type);
				}else{
					$select = '1';
				}
				$att = array("class"=>"span8",
					'onchange' => 'js:$.ajax({
						url: "'.Yii::app()->createUrl("Captcha/checkboxlesson").'",
						type: "POST",
						dataType: "json",
						data: {id:$(this).val()},
						success:function(data){
							$("#droupDownLesson").html(data.textOption);
							$("#select").multipleSelect({
								placeholder: "กรุณาเลือกบทเรียน",
								position: "down"
							});
						}
					});'
				);
				?>
				<!-- <div class="row">
					
					<div class="col-md-12">
						<?php echo $form->labelEx($cap,'cnid'); ?>
						<?php echo Chosen::dropDownList('cnid',$selected, $courseAll, $attSearch); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($cap,'cnid'); ?>
					</div>
				</div> -->

				<div class="row">
					
					<div class="col-md-12">
						<?php echo $form->labelEx($model,'type'); ?>
						<?php echo Chosen::multiSelect('type',$select, $type); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'type'); ?>
					</div>
				</div>
				<!-- <div class="row">
					<div class="col-md-12">
						<label for="">เลือกบทเรียน</label>
						<br>
						<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/multiple-select.css" media="screen">
						<div id="droupDownLesson">
						</div>
					</div>
				</div>
				<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/multiple-select.js"></script> -->
				<br>

				<div class="row vdo">
					<div class="col-md-12">
						<?php echo $form->labelEx($model,'capt_time_random'); ?>
						<?php echo $form->textField($model,'capt_time_random',array('size'=>60,'maxlength'=>250, 'class'=>'span2')); ?>
						<?php echo $this->NotEmpty();?>
						Note: หน่วยเป็นนาที
						<?php echo $form->error($model,'capt_time_random'); ?>
					</div>
				</div>
<!-- 
				<div class="row vdo">
					<div class="col-md-12">
						<?php echo $form->labelEx($model,'capt_time_back'); ?>
						<?php echo $form->textField($model,'capt_time_back',array('size'=>60,'maxlength'=>250, 'class'=>'span2')); ?>
						<?php echo $this->NotEmpty();?>
						Note: หน่วยเป็นนาที
						<?php echo $form->error($model,'capt_time_back'); ?>
					</div>
				</div>

				<div class="row ">
					<div class="col-md-12">
						<?php echo $form->labelEx($model,'capt_wait_time'); ?>
						<?php echo $form->textField($model,'capt_wait_time',array('size'=>60,'maxlength'=>250, 'class'=>'span2')); ?>
						<?php echo $this->NotEmpty();?>
						Note: หน่วยเป็นวินาที
						<?php echo $form->error($model,'capt_wait_time'); ?>
					</div>
				</div>

				<div class="row ">
					<div class="col-md-12">
						<?php echo $form->labelEx($model,'capt_times'); ?>
						<?php echo $form->textField($model,'capt_times',array('size'=>60,'maxlength'=>250, 'class'=>'span2')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'capt_times'); ?>
					</div>
				</div> -->

				<div class="row pdf">
					<div class="col-md-12">
						<?php echo $form->labelEx($model,'slide'); ?>
						<?php echo $form->textField($model,'slide',array('size'=>60,'maxlength'=>250, 'class'=>'span2')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'slide'); ?>
					</div>
				</div>
	
			<!-- 	<div class="row pdf">
					<div class="col-md-12">
						<?php echo $form->labelEx($model,'prev_slide'); ?>
						<?php echo $form->textField($model,'prev_slide',array('size'=>60,'maxlength'=>250, 'class'=>'span2')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'prev_slide'); ?>
					</div>
				</div> -->
				<div class="row pdf">
					<?php echo $form->labelEx($model,'capt_hide'); ?>
					<!--<div class="toggle-button" data-toggleButton-style-enabled="success">-->
						<?php echo $form->checkBox($model,'capt_hide',array(
							'value'=>1, 'uncheckValue'=>0,
							'data-toggle'=> 'toggle','data-onstyle'=>'success','data-size'=>'mini'
							)); ?>
							<!--</div>-->
							<?php echo $form->error($model,'capt_hide'); ?>
						</div>
						<div class="row buttons">
							<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
						</div>
						<?php $this->endWidget(); ?>
					</div><!-- form -->
				</div>
			</div>
		</div>
		<!-- END innerLR -->
		<script>
			$(document).ready ( function(){
				// $('.pdf').hide();
				// $('.vdo').hide();
				// var type = $("#type").chosen().val();

				// var id = $("#ConfigCaptchatCourseLessonRelation_cnid").val();
				// $.ajax({
				// 	url: "<?php echo Yii::app()->createUrl("Captcha/checkboxlesson"); ?>",
				// 	type: "POST",
				// 	dataType: 'json',
				// 	data: {id:id,cap:'<?= $model->capid; ?>'},
				// 	success:function(data){
				// 		$("#droupDownLesson").html(data.textOption);
				// 		var e_lm = $("#select");
				// 		if(data.keys!=null)e_lm.val(data.keys);
				// 		$("#select").multipleSelect({
				// 			placeholder: "กรุณาเลือกบทเรียน",
				// 			position: "down"
				// 		});
				// 	}
				// });
				// $("#type").change(function(){
				// 	type = $("#type").chosen().val();
				// 	if(type != null){
				// 		var ck_vdo = type.includes("1");
				// 		var ck_pdf = type.includes("2");
				// 	}else{
				// 		$('.pdf').hide();
				// 		$('.vdo').hide();
				// 	}
				// 	console.log(ck_pdf);
				// 	if(ck_pdf == true && ck_vdo == true ){
				// 		// console.log('have vdo');
				// 		$('.vdo').toggle();
				// 		$('.pdf').toggle();
				// 	}else if(ck_pdf == true){
				// 		// console.log('have pdf');
				// 		$('.pdf').toggle();
				// 		$('.vdo').toggle();
				// 	}else if(ck_pdf == true && ck_vdo == true ){
				// 		// console.log('have pdf');
				// 		$('.pdf').toggle();
				// 		$('.vdo').toggle();
				// 	}
				// });
				
			});
		</script>