<!-- <script>
    $(document).ready(function(){ 
        $("#CourseOnline_course_date_start").datepicker({    
            // numberOfMonths: 2,
            onSelect: function(selected) {
                $("#CourseOnline_course_date_end").datepicker("option","minDate", selected)
            }
        });
        $("#CourseOnline_course_date_end").datepicker({
            // numberOfMonths: 2,
            onSelect: function(selected) {
                $("#CourseOnline_course_date_start").datepicker("option","maxDate", selected)
            }
        });
    });

</script> -->
<!-- innerLR -->

<!-- <style> -->
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
<!-- </style> -->
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
						$lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
	                	$parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
	                	$modelLang = Language::model()->findByPk($lang_id);
					?>
					<?php    
					if($lang_id == 1){
						$state = false;
						// $model->cate_id = null;
						$readonly = false;
						$att = array("class"=>"span8");
						$attCateAmount = array('size'=>60,'maxlength'=>255,'class'=>'span8');
						$attCourseDate = array('size'=>60,'maxlength'=>255,'class'=>'span8','readonly'=>true);
                    	$att_type = array('class'=>'span8');
						$attTime = array('class' => 'default_datetimepicker','autocomplete'=>'off');
						$dis =  'onclick="return true;"';
						$attOnlyTime = array('class' => 'default_datetimepicker_time');
						////////////////// group id 7 และเป็นคนสร้าง ถึงจะเห็น
						$check_user = User::model()->findByPk(Yii::app()->user->id);
						$group = $check_user->group;
						$group_arr = json_decode($group);
						$see_all = 2;
						if(in_array("1", $group_arr) || in_array("7", $group_arr)){
							$see_all = 1;
						}
            //////////////////
						if($see_all != 1){
							$modelList = Category::model()->findAll(array(
								"condition"=>" active = 'y' and lang_id = 1 and create_by='".Yii::app()->user->id."'"));
						}else{
							$modelList = Category::model()->findAll(array(
								"condition"=>" active = 'y' and lang_id = 1"));
						}
						$attSearch = array("class"=>"form-control span8",'disable_search' => false);
						$model_type = [1=>"หลักสูตรเลือก",2=>"หลักสูตรบังคับ"];
					
                    }else{ //Insert Multi lang
                    	$state = true;
                    	$modelChildren = $model;
                    	$model = CourseOnline::model()->findByPk($parent_id);
                    	$model->course_title = "";
                    	$model->course_short_title = "";
                    	$model->course_detail = "";
                    	$readonly = true;
                    	$att = array("class"=>"span8",'readonly' => true);
                    	$attSearch = array("class"=>"span8",'disable_search' => true);
                    	$attCateAmount = array('size'=>60,'maxlength'=>255,'class'=>'span8','readonly' => true);
						$attCourseDate = array('size'=>60,'maxlength'=>255,'class'=>'span8','readonly'=>true);
						$att_type = array('class'=>'span8','readonly' => true);
                    	$attTime = array('class' => 'default_datetimepicker','readonly'=>true,'autocomplete'=>'off');
                    	$attOnlyTime = array('class' => 'default_datetimepicker_time','readonly'=>true);
                    	$dis =  'onclick="return false;"';
                    	$modelList = Category::model()->findAll(array(
							"condition"=>" active = 'y' and cate_id = '".$model->cate_id."'"));
                    	if ($model->course_type == 1) {
                    		$model_type = [1=>"หลักสูตรเลือก"];
                    	}else{
                    		$model_type = [2=>"หลักสูตรบังคับ"];
                    	}
                    }
                    ?>

                    <?php if ($lang_id != 1){ ?>
					<p class="note"><span style="color:red;font-size: 20px;">เพิ่มเนื้อหาของภาษา <?= $modelLang->language; ?></span></p>
					<?php 
						}
					?>
                    <p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
                    <!-- <div class="row"> -->
                    	<!-- <div class="col-md-12"> -->
                    	<!-- <?php echo $form->labelEx($model,'cate_id'); ?> -->
                    	<!-- <?php echo $this->listCateTypeShow($model,'cate_id','span8');?> -->
                    	<!-- <?php echo $this->listCateTypeShow2($model,'cate_id','span8',$readonly,$lang_id,$parent_id);?> -->
                    	<!-- <?php echo $this->NotEmpty();?> -->
                    	<!-- <?php echo $form->error($model,'cate_id'); ?> -->
	                    <!-- </div> -->
                    <!-- </div> -->

                    <div class="row">
                    	<div class="col-md-12">
                    		<?php echo $form->labelEx($model,'course_type'); ?>
                    		<?php
                    		echo $form->DropDownList($model,'course_type',$model_type , $att_type);
                    		?>
                    		<?php echo $this->NotEmpty();?>
                    		<?php echo $form->error($model,'course_type'); ?>
                    	</div>
                    </div>

					<?php $list = CHtml::listData($modelList,'cate_id', 'cate_title'); ?>
					<?php (empty($model->cate_id)? $select = '' : $select = $model->cate_id); ?>
                    <div class="row">
                    	<div class="col-md-12">
                    	<?php echo $form->labelEx($model,'cate_id'); ?>
                    	<?php //echo Chosen::dropDownList('cate_id', $select, $list, $attSearch); ?>
                    	<?php echo Chosen::activeDropDownList($model, 'cate_id', $list, $attSearch); ?>
                    	<?php echo $this->NotEmpty();?>
                    	<?php echo $form->error($model,'cate_id'); ?>
	                    </div>
                    </div>
<!-- 
				<div class="row">
					<?php echo $form->labelEx($model,'cate_course'); ?>
					<?php if($model->isNewRecord) { ?>
					<?php echo $this->listCateCourseTypeShow($model,'cate_course','span8');?>
					<?php } else { ?>
					<?php echo $this->listCateCourseTypeShow($model,'cate_course','span8',$model->cate_id);?>
					<?php } ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'cate_course'); ?>
				</div>
			-->
			<!--				<div class="row">-->
				<!--					--><?php //echo $form->labelEx($model,'course_number'); ?>
				<!--					--><?php //echo $form->textField($model,'course_number',array('class'=>'span8')); ?>
				<!--					--><?php //echo $this->NotEmpty();?>
				<!--					--><?php //echo $form->error($model,'course_number'); ?>
				<!--				</div>-->

				<!--				<div class="row">-->
					<!--					--><?php //echo $form->labelEx($model,'course_rector_date'); ?>
					<!--					--><?php
//					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
//		               'model'=>$model,
//		               'attribute'=>'course_rector_date',
//		               'htmlOptions' => array(
//		                   'class' => 'span8',
//		                   'readonly'=>'readonly'
//		               ),
//		               'options' => array(
//		                	'mode'=>'focus',
//		                	'dateFormat'=>'dd/mm/yy',
//		                   	'showAnim' => 'slideDown',
//		            	   	'showOn' => 'focus',
//		            	   	'showOtherMonths' => true,
//		            		'selectOtherMonths' => true,
//		                   	'yearRange' => '-5:+2',
//		            		'changeMonth' => true,
//		            		'changeYear' => true,
//		                   	'dayNamesMin' => array('อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'),
//		                   	'monthNamesShort' => array('ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.',
//		                    'ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'),
//		               )
//				    ));?>
<!--					--><?php //echo $this->NotEmpty();?>
<!--					--><?php //echo $form->error($model,'course_rector_date'); ?>
<!--				</div>-->

<!--				<div class="row">-->
	<!--					--><?php //echo $form->labelEx($model,'course_lecturer'); ?>
	<!--					--><?php //echo $this->listTeacher($model,'span8');?>
	<!--					--><?php //echo $this->NotEmpty();?>
	<!--					--><?php //echo $form->error($model,'course_lecturer'); ?>
	<!--				</div>-->
	<?php if($modelChildren){
		$temp = $modelChildren;
		$model = $modelChildren;
	}
	?>

	<div class="row">
		<div class="col-md-12">
		<?php echo $form->labelEx($model,'course_title'); ?>
		<?php echo $form->textField($model,'course_title',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'course_title'); ?>
		</div>
	</div>
	<?php if($state){ 
	$model = CourseOnline::model()->findByPk($parent_id); 
	}
	?>

	 <div class="row">
		<div class="col-md-12">
		 <?php echo $form->labelEx($model,'course_number'); ?>
		<?php echo $form->textField($model,'course_number',$attCateAmount); ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'course_number'); ?>
		 </div>
	</div> 

	<?php if($state){
		$model = $modelChildren; 
	}
	?>

	<div class="row">
		<div class="col-md-12">
		<?php echo $form->labelEx($model,'course_short_title'); ?>
		<?php echo $form->textArea($model,'course_short_title',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'course_short_title'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<label><h4>รายละเอียดหลักสูตร</h4></label>
			<textarea name="CourseOnline[course_detail]" class="survey-header-detail tinymce" id="CourseOnline_course_detail" cols="30" rows="10"><?php echo ($model->course_detail); ?></textarea>
		</div>

	</div>
	<br>
	<?php if($state){ 
	$model = CourseOnline::model()->findByPk($parent_id); 
	}
	?>
	<div class="row">
		<div class="col-md-12">
		<?php echo $form->labelEx($model,'course_date_start'); ?>
		<?php echo $form->textField($model,'course_date_start',$attTime); ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'course_date_start'); ?>
		<input type="hidden" id="course_date_start" >
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
		<?php echo $form->labelEx($model,'course_date_end'); ?>
		<?php echo $form->textField($model,'course_date_end',$attTime); ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'course_date_end'); ?>
		<input type="hidden" id="course_date_end" >
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
		<?php echo $form->labelEx($model,'course_day_learn'); ?>
		<?php echo $form->textField($model,'course_day_learn',$attCourseDate); ?> วัน
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'course_day_learn'); ?>
		</div>
	</div>


	<div class="row">
		<div class="col-md-12">
		<?php echo $form->labelEx($model,'percen_test'); ?>
		<?php echo $form->textField($model,'percen_test',$attCateAmount); ?> %
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'percen_test'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
		<?php echo $form->labelEx($model,'cate_amount'); ?>
		<?php echo $form->textField($model,'cate_amount',$attCateAmount); ?> ครั้ง
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'cate_amount'); ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
		<?php echo $form->labelEx($model,'time_test'); ?>
		<?php echo $form->textField($model,'time_test',$attCateAmount); ?> นาที
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'time_test'); ?>
		</div>
	</div>

	<!-- <div class="row"> -->
		<?php //echo $form->labelEx($model,'special_category'); ?>
		<!-- <div class="toggle-button" data-toggleButton-style-enabled="success"> -->
			<?php //echo $form->checkBox($model,'special_category',array('value'=>"y", 'uncheckValue'=>"n")); ?>
			<!-- </div> -->
			<?php //echo $form->error($model,'recommend'); ?>
                <!-- </div>
                	<br> -->
	
					<div class="row">
                		<?php echo $form->labelEx($model,'course_refer'); ?>
                		<!--<div class="toggle-button" data-toggleButton-style-enabled="success">-->
                			<?php echo $form->checkBox($model,'course_refer',array(
                				'data-toggle'=> 'toggle','value'=>"y", 'uncheckValue'=>"n"
                				)); ?>
                				<!--</div>-->
                				<?php echo $form->error($model,'course_refer'); ?>
                			</div>

                	<div class="row">
                		<?php echo $form->labelEx($model,'recommend'); ?>
                		<!--<div class="toggle-button" data-toggleButton-style-enabled="success">-->
                			<?php echo $form->checkBox($model,'recommend',array(
                				'data-toggle'=> 'toggle','value'=>"y", 'uncheckValue'=>"n"
                				)); ?>
                				<!--</div>-->
                				<?php echo $form->error($model,'recommend'); ?>
                			</div>


				<!-- <div class="row">
					<?php echo $form->labelEx($model,'course_refer'); ?>
					<?php echo $form->textField($model,'course_refer',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'course_refer'); ?>
				</div> -->

				<!-- <div class="row">
					<?php echo $form->labelEx($model,'course_book_number'); ?>
					<?php echo $form->textField($model,'course_book_number',array('class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'course_book_number'); ?>
				</div> -->

				<!-- <div class="row">
					<?php echo $form->labelEx($model,'course_book_date'); ?>
					<?php
					$this->widget('zii.widgets.jui.CJuiDatePicker', array(
		               'model'=>$model,
		               'attribute'=>'course_book_date',
		               'htmlOptions' => array(
		                   'class' => 'span8',
		                   'readonly'=>'readonly'
		               ),  
		               'options' => array(
		                	'mode'=>'focus',
		                	'dateFormat'=>'dd/mm/yy',
		                   	'showAnim' => 'slideDown',
		            	   	'showOn' => 'focus', 
		            	   	'showOtherMonths' => true,
		            		'selectOtherMonths' => true,
		                   	'yearRange' => '-5:+2', 
		            		'changeMonth' => true,
		            		'changeYear' => true,
		                   	'dayNamesMin' => array('อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'),
		                   	'monthNamesShort' => array('ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.',
		                    'ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'),
		               )
				    ));?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'course_book_date'); ?>
				</div> -->

				 

<!--				<div class="row">
					<?php // echo $form->labelEx($model,'course_hour'); ?>
					<?php // echo $form->textField($model,'course_hour',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php // echo $form->error($model,'course_hour'); ?>
				</div>-->

				<!-- <div class="row">
					<?php echo $form->labelEx($model,'course_other'); ?>
					<?php echo $form->textField($model,'course_other',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'course_other'); ?>
				</div> -->
				
				<!-- <div class="row">
					<?php echo $form->labelEx($model,'course_tax'); ?>
					<?php
					echo $form->DropDownList($model,'course_tax',array('0'=>'ไม่เสียภาษี (n.v.)','1'=>'เสียภาษี') , array(
						'empty'=>'กรุณาเลือกประเภท',
						'class'=>'span8'
					));
					?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'course_tax'); ?>
				</div> -->

				<div class="row">
					<?php // echo $form->labelEx($model,'course_note'); ?>
					<?php // echo $form->textField($model,'course_note',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
					<?php // echo $form->error($model,'course_note'); ?>
				</div>

				<!-- <div class="row">
					<?php echo $form->labelEx($model,'course_price'); ?>
					<?php echo $form->textField($model,'course_price',array('class'=>'span8')); ?>
					<?php echo $this->NotEmpty();?>
					<?php echo $form->error($model,'course_price'); ?>
				</div> -->

				<div class="row">
					<?php //echo $form->labelEx($model,'course_point'); ?>
					<?php //echo $form->textField($model,'course_point',array('class'=>'span8')); ?>
					<?php //echo $this->NotEmpty();?>
					<?php //echo $form->error($model,'course_point'); ?>
				</div>

				<?php if($state){
					$model = $modelChildren; 
					}
				?>
				
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
					<?php echo $form->labelEx($model,'course_picture'); ?>
					<div class="fileupload fileupload-new" data-provides="fileupload">
						<div class="input-append">
							<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-default btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><?php echo $form->fileField($model, 'course_picture'); ?></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
						</div>
					</div>
					<?php echo $form->error($model,'course_picture'); ?>
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

	$('#CourseOnline_course_date_start').datetimepicker({
		format:'Y-m-d H:i',
		step:10,
		timepickerScrollbar:false,
		onSelectDate: function(db,$input){
			$('#course_date_start').val($input.val())

			countDate()
		}
	});
	$('#CourseOnline_course_date_end').datetimepicker({
		format:'Y-m-d H:i',
		step:10,
		timepickerScrollbar:false,
		onSelectDate: function(db,$input){
			$('#course_date_end').val($input.val())

			countDate()
		}
	});

	function countDate() {
		if($('#course_date_start').val() != '' && $('#course_date_end').val() != '') {
			let date_start = $('#course_date_start').val();
			let date_end = $('#course_date_end').val();

			let d1 = date_start.split(' ');
			let start = d1[0].split('-');
			let d2 = date_end.split(' ');
			let end = d2[0].split('-');

			let firstDate = new Date(parseInt(start[0]),parseInt(start[1]),parseInt(start[2])); // Todays date
			let secondDate = new Date(parseInt(end[0]),parseInt(end[1]),parseInt(end[2]));

			let diffDays = getDifferenceInDays(firstDate,secondDate)
		
			$('#CourseOnline_course_day_learn').val(diffDays);
		}
	}

	function getDifferenceInDays(date1, date2) {
		const diffInMs = Math.abs(date2 - date1);
		return diffInMs / (1000 * 60 * 60 * 24);
	}

</script>  
<script>
	function getState(val) {
		if(val != ''){
			$.ajax({
				type: "POST",
				url: '<?php echo Yii::app()->request->baseUrl. '/index.php/CourseOnline/courseAjax' ?>',
				data:'cate_id='+val,
				success: function(data){
					$("#CourseOnline_cate_course").html(data);
				}
			});
		}
	}
</script>
<script>
	$(function () {
		init_tinymce();
	});
</script>
