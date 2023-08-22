
<?php
$this->breadcrumbs=array(
	'จัดการหลักสูตร'=>array('index'),
	'เลือกแบบประเมิน',
);
?>
<!-- innerLR -->
<div class="innerLR">

	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i>เลือกแบบประเมิน
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<div class="form">
			<p class="note">ค่าที่มี <?php echo ClassFunction::CircleQuestionMark();?> จำเป็นต้องใส่ให้ครบ</p>
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'CourseTeacher-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					  	'validateOnSubmit'=>true
				),
			)); ?>


			<div class="row">
				<?php echo $form->labelEx($teacher,'title'); ?>
				<?php echo $form->textField($teacher,'title',array('class'=>'span8'));?>
				<?php echo $this->NotEmpty();?>
				<?php echo $form->error($teacher,'title'); ?>
			</div>

			<!-- <div class="row">
				<?php echo $form->labelEx($teacher,'teacher_id'); ?>
				<?php echo $this->listTeacher_new($teacher,'span8','teacher_id');?>
				<?php echo $this->NotEmpty();?>
				<?php echo $form->error($teacher,'teacher_id'); ?>
			</div> -->

			<div class="row">
				<!-- <?php echo $form->labelEx($teacher,'survey_header_id'); ?> -->
				<label for="CourseTeacher_survey_header_id" class="required">แบบประเมิน <span class="required">*</span></label>
				<?php echo $this->listQHeader_new($teacher,'span8','survey_header_id');?>
				<?php echo $this->NotEmpty();?>
				<?php echo $form->error($teacher,'survey_header_id'); ?>
			</div>


			<div class="row buttons">
				<!-- <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?> -->
				<?php 
				echo CHtml::submitButton('บันทึกข้อมูล', array('class' => 'btn btn-primary btn-icon  ok_2','id'=>'formSave','name' => 'submit'));
				?>
			</div>
			<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
<?php
Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$.updateGridView = function(gridID, name, value) {
	    $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
	    $.fn.yiiGridView.update(gridID, {data: $.param(
	        $("#"+gridID+" input, #"+gridID+" .filters select")
	    )});
	}
	$.appendFilter = function(name, varName) {
	    var val = eval("$."+varName);
	    $("#courseteacher-form").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("CourseTeacher[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>
<div class="widget">
	<div class="widget-head">
		<h4 class="heading">รายละเอียดแบบประเมินที่เลือก</h4>
	</div>
	<div class="widget-body">
			<div class="separator bottom form-inline small">
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow('CourseTeacher');?>
				</span>
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php $this->widget('AGridView', array(
					'id'=>'courseteacher-form',
					'dataProvider'=>$teacher->search(),
					// 'filter'=>$teacher,
					'selectableRows' => 2,
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("CourseTeacher[news_per_page]");
						InitialSortTable();
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("CourseTeacher.*", "CourseTeacher.Delete", "CourseTeacher.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'name'=>'title',
							'value'=>'$data->title'
						),
						// array(
						// 	'name'=>'teacher_id',
						// 	'value'=>'$data->teacher->teacher_name'
						// ),
						array(
							'header'=>'แบบประเมิน',
							'name'=>'survey_header_id',
							'value'=>'$data->q_header->survey_name'
						),
						array(
							'header'=>'รายงานแบบประเมิน',
							//'value'=>'CHtml::button("เลือกแบบสอบถาม",  array("class" => "btn btn-primary btn-icon" ,"submit" => Yii::app()->createUrl("Lesson/ChooseQuestionnaire")))',
							'value'=>function($data){
								if($data->survey_header_id != ""){
									$str = " ".CHtml::link("รายงาน", array(
											"Questionnaire/Report_course",
											"id"=>"$data->id"
										), array(
											"class"=>"btn btn-success btn-icon"
										));
								}

								return $str;
							},
							'type'=>'raw',
							'htmlOptions'=>array('style'=>'text-align: center','width'=>'160px'),
						),
						array(
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton(
								array("CourseTeacher.*", "CourseTeacher.View", "CourseTeacher.Update", "CourseTeacher.Delete")
							),
							'buttons' => array(
								'view'=> array(
									'visible'=>'false'
								),
								'update'=> array(
									'visible'=>'Controller::PButton( array("CourseOnline.*", "CourseOnline.Update") )',
									'url'=>'$this->grid->controller->createUrl("/CourseOnline/edit_teacher", array("id"=>$data->id,"course_id"=>$data->course_id))',
								),
								'delete'=> array(
									'visible'=>'Controller::PButton( array("CourseTeacher.*", "CourseTeacher.Delete") )',
									'url'=>'$this->grid->controller->createUrl("/CourseTeacher/delete", array("id"=>"$data->id"))',
								),
							),

						),
					),
				)); ?>
			</div>
	</div>
</div>

	<?php if( Controller::DeleteAll(array("CourseTeacher.*", "CourseTeacher.Delete", "CourseTeacher.MultiDelete")) ) : ?>
		<!-- Options -->
		<div class="separator top form-inline small">
			<!-- With selected actions -->
			<div class="buttons pull-left">
				<?php
				echo CHtml::link("<i></i> ลบข้อสอบทั้งหมด",
					"#",
					array("class"=>"btn btn-primary btn-icon glyphicons circle_minus",
						"onclick"=>"return multipleDeleteNews('".$this->createUrl('//CourseTeacher/MultiDelete')."','courseteacher-form');"));
				?>
			</div>
			<!-- // With selected actions END -->
			<div class="clearfix"></div>
		</div>
		<!-- // Options END -->
	<?php endif; ?>

</div>
<!-- END innerLR -->
<script>
    $(function () {
        $('#CourseTeacher-form').submit(function(){
        	var title = $('#CourseTeacher_title').val();
        	var header_id = $( "#CourseTeacher_survey_header_id option:selected" ).text();
        	if(title != "" && header_id != ""){
        		setTimeout(function () {
        			document.getElementById('formSave').value = 'กำลังประมวล…';
        			document.getElementById('formSave').disabled = true;
        		}, 500);
        	}
		});
    });
</script>