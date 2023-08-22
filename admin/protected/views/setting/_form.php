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
			<?php $form = $this->beginWidget('CActiveForm', array(
				'id'=>'page-form',
		        'enableClientValidation'=>true,
		        'clientOptions'=>array(
		            'validateOnSubmit'=>true
		        ),
		        'htmlOptions' => array('enctype' => 'multipart/form-data')
			)); ?>
				<p class="note">ค่าที่มี <?php echo ClassFunction::CircleQuestionMark();?> จำเป็นต้องใส่ให้ครบ</p>
			
<!--				<div class="row">-->
<!--					--><?php //echo $form->labelEx($model,'settings_email'); ?>
<!--					--><?php //echo $form->textField($model,'settings_email',array(
//						'class'=>'span7','size'=>60,'maxlength'=>255
//					)); ?>
<!--					--><?php //echo $form->error($model,'settings_email'); ?>
<!--				</div>-->
<!---->
<!--				<div class="row">-->
<!--					--><?php //echo $form->labelEx($model,'settings_tel'); ?>
<!--					--><?php //echo $form->textField($model,'settings_tel',array(
//						'class'=>'span7','size'=>60,'maxlength'=>255
//					)); ?>
<!--					--><?php //echo $form->error($model,'settings_tel'); ?>
<!--				</div>-->
<!---->
<!--				<div class="row">-->
<!--					--><?php //echo $form->labelEx($model,'settings_line'); ?>
<!--					--><?php //echo $form->textField($model,'settings_line',array(
//						'class'=>'span7','size'=>60,'maxlength'=>255
//					)); ?>
<!--					--><?php //echo $form->error($model,'settings_line'); ?>
<!--				</div>-->

				<p><div class="progress progress-inverse progress-mini"><div class="bar" style="width: 100%;"></div></div></p>

				<!-- <div class="row">
					<?php echo $form->labelEx($model,'settings_institution'); ?>
					<?php echo $form->textField($model,'settings_institution',array(
						'class'=>'span7','size'=>60,'maxlength'=>255
					)); ?>
					<?php echo ClassFunction::CircleQuestionMark(); ?>
					<?php echo $form->error($model,'settings_institution'); ?>
				</div> -->

				<!-- <div class="row">
					<?php echo $form->labelEx($model,'settings_user_email'); ?>
					<?php echo $form->textField($model,'settings_user_email',array(
						'class'=>'span7','size'=>60,'maxlength'=>255
					)); ?>
					<?php echo ClassFunction::CircleQuestionMark(); ?>
					<?php echo $form->error($model,'settings_user_email'); ?>
				</div>
				
				<div class="row">
					<?php echo $form->labelEx($model,'settings_pass_email'); ?>
					<?php echo $form->passwordField($model,'settings_pass_email',array(
						'class'=>'span7','size'=>60,'maxlength'=>255
					)); ?>
					<?php echo ClassFunction::CircleQuestionMark(); ?>
					<?php echo $form->error($model,'settings_pass_email'); ?>
				</div> -->

				<!-- <div class="row">
					<?php echo $form->labelEx($model,'settings_testing'); ?>
						<?php echo $form->checkBox($model,'settings_testing',array(
							'value'=>1, 'uncheckValue'=>0,
                                                        'data-toggle'=> 'toggle','data-onstyle'=>'success','data-size'=>'mini'
						)); ?>
					<?php echo $form->error($model,'settings_testing'); ?>
				</div> -->

				<div class="row">
					<?php echo $form->labelEx($model,'settings_register'); ?>
					<!--<div class="toggle-button" data-toggleButton-style-enabled="success">-->
						<?php echo $form->checkBox($model,'settings_register',array(
							'value'=>1, 'uncheckValue'=>0,
                                                        'data-toggle'=> 'toggle','data-onstyle'=>'success','data-size'=>'mini'
						)); ?>
					<!--</div>-->
					<?php echo $form->error($model,'settings_register'); ?>
				</div>
				<br>
				<div class="row">
					<?php echo $form->labelEx($model,'settings_confirmmail'); ?>
					<!--<div class="toggle-button" data-toggleButton-style-enabled="success">-->
						<?php echo $form->checkBox($model,'settings_confirmmail',array(
							'value'=>1, 'uncheckValue'=>0,
                                                        'data-toggle'=> 'toggle','data-onstyle'=>'success','data-size'=>'mini'
						)); ?>
					<!--</div>-->
					<?php echo $form->error($model,'settings_confirmmail'); ?>
				</div>
				<br>
				<!-- <div class="row"> -->
					<?php //echo $form->labelEx($model,'settings_confirmface'); ?>
					<!--<div class="toggle-button" data-toggleButton-style-enabled="success">-->
						<?php //echo $form->checkBox($model,'settings_confirmface',array(
							// 'value'=>1, 'uncheckValue'=>0,
                            //                             'data-toggle'=> 'toggle','data-onstyle'=>'success','data-size'=>'mini'
						//)); ?>
					<!--</div>-->
					<?php //echo $form->error($model,'settings_confirmface'); ?>
				<!-- </div> -->
				<!-- <br> -->
				<div class="row">
					<?php echo $form->labelEx($model,'settings_confirmface_zoom'); ?>
					<!--<div class="toggle-button" data-toggleButton-style-enabled="success">-->
						<?php echo $form->checkBox($model,'settings_confirmface_zoom',array(
							'value'=>1, 'uncheckValue'=>0,
                                                        'data-toggle'=> 'toggle','data-onstyle'=>'success','data-size'=>'mini'
						)); ?>
					<!--</div>-->
					<?php echo $form->error($model,'settings_confirmface_zoom'); ?>
				</div>


				<!-- <div class="row">
					<?php echo $form->labelEx($model,'settings_register_office'); ?> -->
					<!--<div class="toggle-button" data-toggleButton-style-enabled="success">-->
						<!-- <?php echo $form->checkBox($model,'settings_register_office',array(
							'value'=>1, 'uncheckValue'=>0,
                                                        'data-toggle'=> 'toggle','data-onstyle'=>'success','data-size'=>'mini'
						)); ?> -->
					<!--</div>-->
					<!-- <?php echo $form->error($model,'settings_register_office'); ?>
				</div> -->

				
				<!-- <div class="row">
					<?php echo $form->labelEx($model,'settings_register_personal'); ?> -->
					<!--<div class="toggle-button" data-toggleButton-style-enabled="success">-->
						<!-- <?php echo $form->checkBox($model,'settings_register_personal',array(
							'value'=>1, 'uncheckValue'=>0,
                                                        'data-toggle'=> 'toggle','data-onstyle'=>'success','data-size'=>'mini'
						)); ?> -->
					<!--</div>-->
					<!-- <?php echo $form->error($model,'settings_register_personal'); ?>
				</div>
				<p><div class="progress progress-inverse progress-mini"><div class="bar" style="width: 100%;"></div></div></p> -->


<!--				<div class="row">-->
<!--					--><?php //echo $form->labelEx($model,'settings_score'); ?>
<!--					--><?php //echo $form->textField($model,'settings_score',array(
//						'class'=>'span7','size'=>60,'maxlength'=>255
//					)); ?>
<!--					--><?php //echo ClassFunction::CircleQuestionMark(); ?>
<!--					--><?php //echo $form->error($model,'settings_score'); ?>
<!--				</div>-->


			<!-- 	<div class="row">
					<?php echo $form->labelEx($model,'password_expire_day'); ?>
					<?php echo $form->textField($model,'password_expire_day',array(
						'class'=>'span7','size'=>60,'maxlength'=>255
					)); ?>
					<?php echo ClassFunction::CircleQuestionMark(); ?>
					<?php echo $form->error($model,'password_expire_day'); ?>
				</div> -->

				<!-- <div class="row">
					<?php echo $form->labelEx($model,'settings_intro_status'); ?>
					<div class="toggle-button" data-toggleButton-style-enabled="success">
						<?php echo $form->checkBox($model,'settings_intro_status',array(
							'value'=>1, 'uncheckValue'=>0
						)); ?>
					</div>
					<?php echo $form->error($model,'settings_intro_status'); ?>
				</div>
				<br> -->
				<!-- <div class="row">
					<div class="pull-left">
						<div id="colorTab1">
							<div class="farbtastic">
								<div class="color" style="background-color: rgb(255, 226, 0);"></div>
								<div class="wheel"></div>
								<div class="overlay"></div>
								<div class="h-marker marker" style="left: 164px; top: 47px;"></div>
								<div class="sl-marker marker" style="left: 98px; top: 118px;"></div>
							</div>
						</div>
					</div>
				</div> -->

				<!-- <div class="row">
					<script type="text/javascript">
					$(function(){
						$('#colorTab1').farbtastic('#settings_bg_color'); 
					});
					</script>
					<?php echo $form->labelEx($model,'settings_intro_bg_color'); ?>
					<?php echo CHtml::activeTextField($model, 'settings_intro_bg_color',array(
						'class'=>'span4',
						'id'=>'settings_bg_color',
						'readonly'=>'readonly',
						//'value'=>'#5a6a87',
						'style'=>'background-color: rgb(0, 0, 0); color: rgb(255, 255, 255); '
					)); ?>
					<?php echo $form->error($model,'settings_intro_bg_color'); ?>
				</div>
				<br> -->

				<!-- <script type="text/javascript">
				function deleteImage(file_id)
				{
					$.get("<?php echo $this->createUrl('setting/DeleteImageBg'); ?>",{id:file_id},function(data){
						if($.trim(data)==1){
							notyfy({dismissQueue: false,text: "ลบภาพพื้นหลังเรียบร้อย",type: 'success'});
							$('#ImageBg').hide('fast');
						}else{
							alert('เกิดข้อผิดพลาด');
						}
					});
				}
				</script> -->

				<!-- <div class="row" id="ImageBg">
				<?php
				if(isset($imageShow))
				{     
					echo CHtml::image(Yush::getUrl($model, Yush::SIZE_ORIGINAL, $imageShow), $imageShow,array(
						"class"=>"thumbnail"
					));
				}
				?>
				<?php echo CHtml::link('<i></i>','', array('title'=>'ลบภาพพื้นหลัง','class'=>'btn-action glyphicons pencil btn-danger remove_2','style'=>'float:left; z-index:1; background-color:white; cursor:pointer;','onclick'=>'if(confirm("คุณต้องการลบรูปภาพพื้นหลังใช่หรือไม่ ?")){ deleteImage("1"); }')); ?>
				</div>
				<br> -->

				<!-- <div class="row">
					<?php echo $form->labelEx($model,'settings_intro_bg'); ?>
					<div class="fileupload fileupload-new" data-provides="fileupload">
					  	<div class="input-append">
					    	<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($model, 'settings_intro_bg'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
					  	</div>
					</div>
					<?php echo $form->error($model,'settings_intro_bg'); ?>
				</div> -->

				<!-- <div class="row">
					<?php echo $form->labelEx($model,'settings_intro_detail'); ?>
					<?php echo $form->textArea($model,'settings_intro_detail',array('rows'=>6, 'cols'=>50, 'class'=>'span8 tinymce')); ?>
					<?php echo $form->error($model,'settings_intro_detail'); ?>
				</div>
				<br> -->
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