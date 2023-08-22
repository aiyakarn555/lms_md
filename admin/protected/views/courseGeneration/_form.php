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
					'id'=>'CourseGeneration-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true
					),
					'errorMessageCssClass' => 'label label-important',
					'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>

				<p class="note">ค่าที่มี <span class="required">*</span> จำเป็นต้องใส่ให้ครบ</p>

				<!-- <div class="row">
					<?php //echo $form->labelEx($model, 'course_id'); ?>
					<?php //echo $form->dropDownList($model, 'course_id', CHtml::listData(Course::model()->findAll('active="y"'), 'course_id', 'course_title') , array('empty' => '-- กรุณาเลือกหลักสูตร --', 'class' => 'span8','disabled'=>true)); ?>
					<?php //echo $form->error($model, 'course_id'); ?>
				</div> -->

				<div class="row">
					<label>ชื่อรุ่น (ตัวเลขเท่านั้น) <span class="required">*</span></label>
					<?php //echo $form->labelEx($model,'gen_title'); ?>
					<?php echo $form->textField($model,'gen_title',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'gen_title'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'gen_detail'); ?>
					<?php echo $form->textField($model,'gen_detail',array('size'=>60, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'gen_detail'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'gen_detail_en'); ?>
					<?php echo $form->textField($model,'gen_detail_en',array('size'=>60, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'gen_detail_en'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'gen_person'); ?>
					<?php echo $form->textField($model,'gen_person',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
					<?php echo $form->error($model,'gen_person'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'gen_period_start'); ?>
					<?php echo $form->textField($model,'gen_period_start',array('rows'=>6, 'cols'=>50, 'class' => 'default_datetimepicker', 'autocomplete'=>'off')); ?>
					<?php echo $form->error($model,'gen_period_start'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model,'gen_period_end'); ?>
					<?php echo $form->textField($model,'gen_period_end',array('rows'=>6, 'cols'=>50, 'class' => 'default_datetimepicker', 'autocomplete'=>'off')); ?>
					<?php echo $form->error($model,'gen_period_end'); ?>
				</div>
				<div class="row">
					<?php echo $form->labelEx($model,'status'); ?>
					<?php echo $form->checkBox($model,'status',array(
						'value'=>"1", 'uncheckValue'=>"2",
						'data-toggle'=>'toggle', 'data-onstyle'=>'success', 'data-size'=>'mini'
					)); ?>
					<?php echo $form->error($model,'status'); ?>
				</div>

				<br>

				<div class="row buttons">
					<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
				</div>

				<?php $this->endWidget(); ?>

			</div>
		</div>
	</div>

	<script>
		$(function () {
			init_tinymce();
		});

		$('.default_datetimepicker').datetimepicker({
			format: 'Y-m-d H:i',
			step: 10,
			timepickerScrollbar: false
		});

		$("#CourseGeneration_gen_period_end").change(function () {
			var first = new Date($("#CourseGeneration_gen_period_start").val());
			var current = new Date($(this).val());
			if (first.getTime() > current.getTime()) {
				alert("ไม่สามารถปรับเวลาสิ้นสุดมากกว่าวันเริ่มตั้นได้");
				$(this).val("");
			}
		});
	</script>  